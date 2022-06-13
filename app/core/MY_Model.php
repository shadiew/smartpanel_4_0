<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MY_Model extends CI_Model
{
    protected $tb_order;
    protected $tb_main;
    protected $tb_users;
    protected $tb_users_price;
    protected $tb_services;
    protected $tb_categories;
    protected $tb_tickets;
    protected $tb_ticket_message;
    protected $tb_api_providers;
    protected $tb_language_list;
    protected $tb_news;
    protected $tb_faqs;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tb_main = '';
        $this->tb_users             = USERS;
        $this->tb_users_price       = USERS_PRICE;
        $this->tb_services          = SERVICES;
        $this->tb_tickets           = TICKETS;
        $this->tb_ticket_message    = TICKET_MESSAGES;
        $this->tb_categories        = CATEGORIES;
        $this->tb_api_providers     = API_PROVIDERS;
        $this->tb_transaction_logs  = TRANSACTION_LOGS;
        $this->tb_language_list     = LANGUAGE_LIST;
        $this->tb_order             = ORDER;
        $this->tb_news              = NEWS;
        $this->tb_faqs              = FAQS;

    }

    public function fetch($select = "*", $table = "", $where = "", $order = "", $by = "DESC", $start = -1, $limit = 0, $return_array = false)
    {
        $this->db->select($select);
        if ($where != "") {
            $this->db->where($where);
        }
        if ($order != "" && (strtolower($by) == "desc" || strtolower($by) == "asc")) {
            if ($order == 'rand') {
                $this->db->order_by('rand()');
            } else {
                $this->db->order_by($order, $by);
            }
        }

        if ((int) $start >= 0 && (int) $limit > 0) {
            $this->db->limit($limit, $start);
        }
        #Query
        $query = $this->db->get($table);
        if ($return_array) {
            $result = $query->result_array();
        } else {
            $result = $query->result();
        }
        $query->free_result();
        return $result;
    }

    public function get($select = "*", $table = "", $where = "", $order = "", $by = "DESC", $return_array = false)
    {
        $this->db->select($select);
        if ($where != "") {
            $this->db->where($where);
        }
        if ($order != "" && (strtolower($by) == "desc" || strtolower($by) == "asc")) {
            if ($order == 'rand') {
                $this->db->order_by('rand()');
            } else {
                $this->db->order_by($order, $by);
            }
        }
        #Query
        $query = $this->db->get($table);
        if ($return_array) {
            $result = $query->row_array();
        } else {
            $result = $query->row();
        }
        $query->free_result();

        return $result;
    }

    public function delete($table, $ids, $check_user)
    {

        if (DEMO_VERSION) {
            ms(array(
                "status" => "error",
                "message" => "For security reasons, in demo version there have been disabled some features",
            ));
        }

        if (!empty($ids)) {

            if ($check_user) {
                $where = array("uid" => session("uid"));
            } else {
                $where = array();
            }

            if (!get_role('admin')) {
                ms(array(
                    "status" => "error",
                    "message" => "You don't have permission to delete this item!",
                ));
            }

            if (!$ids) {
                ms(array(
                    "status" => "error",
                    "message" => lang('the_item_does_not_exist_please_try_again'),
                ));
            }

            if (is_array($ids)) {
                foreach ($ids as $key => $id) {
                    $where["ids"] = $id;
                    $this->db->delete($table, $where);
                }

                ms(array(
                    "status" => "success",
                    "ids" => $ids,
                    "message" => lang("Deleted_successfully"),
                ));
            } else {
                $item = $this->model->get("*", $table, "ids = '{$ids}'");
                if (!empty($item)) {

                    if (isset($item->role) && $item->role == "admin") {
                        ms(array(
                            "status" => "error",
                            "message" => lang("can_not_delete_administrator_account"),
                        ));
                    }

                    $where["id"] = $item->id;
                    $this->db->delete($table, $where);

                    // Delete all related items
                    switch ($table) {
                        case 'categories':
                            $this->db->delete("services", ["cate_id" => $item->id]);
                            break;

                        case 'api_providers':
                            $this->db->delete("services", ["api_provider_id" => $item->id]);
                            break;

                        case 'general_lang_list':
                            $this->db->delete("general_lang", ["lang_code" => $item->code]);
                            break;

                        case 'tickets':
                            $this->db->delete("ticket_messages", ["ticket_id" => $item->id]);
                            break;

                        case 'general_users':
                            $this->db->delete("tickets", ["uid" => $item->id]);
                            $this->db->delete("ticket_messages", ["uid" => $item->id]);
                            $this->db->delete("orders", ["uid" => $item->id]);
                            $this->db->delete(USERS_PRICE, ["uid" => $item->id]);
                            break;

                        case 'services':
                            $this->db->delete(USERS_PRICE, ["service_id" => $item->id]);
                            break;
                    }

                    ms(array(
                        "status" => "success",
                        "ids" => $ids,
                        "message" => lang("Deleted_successfully"),
                    ));
                } else {
                    ms(array(
                        "status" => "error",
                        "message" => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
                    ));
                }
            }
        } else {
            load_404();
        }
    }

    /**
     * @param $table
     * @param $where
     * @param $select_sum - a field want to sum
     * @return int
     */
    public function sum_results($select_sum, $table, $where = "")
    {
        if ($where != "") {
            $this->db->where($where);
        }
        $this->db->select_sum($select_sum);
        $query = $this->db->get($table);
        $result = $query->result();
        if ($result[0]->$select_sum > 0) {
            return $result[0]->$select_sum;
        } else {
            return 0;
        }
    }

    /**
     * @param $table
     * @param $where
     * @param $count active rows - a field want to count
     * @return int
     */
    public function count_results($select_field, $table, $where = "")
    {
        if ($where != "") {
            $this->db->where($where);
        }
        $this->db->select($select_field);
        $this->db->from($table);
        $query = $this->db->get();
        $rows = $query->num_rows();
        return $rows;
    }

    public function check_record($fields, $table, $id, $check_user, $get_data)
    {
        if (!$get_data) {
            if ($id == "") {
                return false;
            }
        }

        if ($check_user) {
            $where = array(
                "uid" => session("uid"),
                "id" => $id,
            );
        } else {
            $where = array(
                "id" => $id,
                "status" => 1,
            );
        }

        $item = $this->model->get($fields, $table, $where);

        if ($get_data) {
            return $item;
        }

        if (!empty($item)) {
            return true;
        } else {
            return false;
        }
    }

    public function history_ip($userid)
    {
        $user = $this->model->get("id, history_ip", USERS, ['id' => $userid]);
        if (!empty($user)) {
            $this->db->update(USERS, array('history_ip' => get_client_ip()), array("id" => $userid));
        }
    }

    /**
     * From Ver3.6
     * Crud user
     * @param int $uid - user ID
     * @param array $params - new balance
     * @param array $option - task
     * @return bool
     */
    public function crud_user($params = [], $option = [])
    {
        $select_fields = (isset($params['fields'])) ? $params['fields'] : '*';
        $item_user = $this->get($select_fields, $this->tb_users, ['id' => $params['uid']], '', '', true);

        if (empty($item_user)) {
            return false;
        }

        switch ($option['task']) {
            case 'update-balance':
                $data = [
                    "balance" => $item_user['balance'] + $params['new_amount'],
                ];
                $this->db->update($this->tb_users, $data, ["id" => $params['uid']]);
                if ($this->db->affected_rows() > 0) {
                    return true;
                } else {
                    return false;
                }
                break;
        }
    }

    public function send_email($subject, $email_content, $user_id, $check_replace = true)
    {
        $user_info = $this->get("first_name, last_name, email, timezone, reset_key, activation_key", USERS, "id = '{$user_id}'");

        if (empty($user_info)) {
            return "Account does not exists!";
        }
        /*----------  Get Mail Template  ----------*/
        $mail_template = file_get_contents(APPPATH . '/libraries/PHPMailer/template.php');

        /*----------  replace variable in email content, subject  ----------*/
        $email_from = get_option('email_from', '') ? get_option('email_from', '') : "do-not-reply@smm.com";
        $email_name = get_option('email_name', '') ? get_option('email_name', '') : get_option('website_title', '');
        $user_firstname = $user_info->first_name;
        $user_lastname = $user_info->last_name;
        $user_timezone = $user_info->timezone;
        $user_email = $user_info->email;

        $website_link = PATH;
        $website_logo = get_option('website_logo', BASE . "assets/images/logo.png");
        $website_name = get_option("website_name", "SMM PANEL");
        $copyright = get_option('copy_right_content', "Copyright &copy; 2020 - SmartPanel");

        /*----------  Need to replace subject, content or Not  ----------*/
        if ($check_replace) {
            $subject = str_replace("{{user_firstname}}", $user_firstname, $subject);
            $subject = str_replace("{{user_lastname}}", $user_lastname, $subject);
            $subject = str_replace("{{user_timezone}}", $user_timezone, $subject);
            $subject = str_replace("{{user_email}}", $user_email, $subject);
            $subject = str_replace("{{activation_link}}", cn("auth/activation/" . $user_info->activation_key), $subject);
            $subject = str_replace("{{website_name}}", $website_name, $subject);
            $subject = str_replace("{{recovery_password_link}}", cn("auth/reset_password/" . $user_info->reset_key), $subject);

            $email_content = str_replace("{{user_firstname}}", $user_firstname, $email_content);
            $email_content = str_replace("{{user_lastname}}", $user_lastname, $email_content);
            $email_content = str_replace("{{user_timezone}}", $user_timezone, $email_content);
            $email_content = str_replace("{{activation_link}}", cn("auth/activation/" . $user_info->activation_key), $email_content);
            $email_content = str_replace("{{user_email}}", $user_email, $email_content);
            $email_content = str_replace("{{website_name}}", $website_name, $email_content);
            $email_content = str_replace("{{recovery_password_link}}", cn("auth/reset_password/" . $user_info->reset_key), $email_content);
        }

        $mail_template = str_replace("{{website_logo}}", $website_logo, $mail_template);
        $mail_template = str_replace("{{website_link}}", $website_link, $mail_template);
        $mail_template = str_replace("{{website_name}}", $website_name, $mail_template);
        $mail_template = str_replace("{{copyright}}", $copyright, $mail_template);
        $mail_template = str_replace("{{email_content}}", $email_content, $mail_template);

        /*----------  Call PHPMaler  ----------*/
        $this->load->library("Phpmailer_lib");
        $mail = new PHPMailer(true);
        $mail->CharSet = "utf-8";
        try {

            /*----------  Check send email through PHP mail or SMTP  ----------*/
            $email_protocol_type = get_option("email_protocol_type", "");
            $smtp_server = get_option("smtp_server", "");
            $smtp_port = get_option("smtp_port", "");
            $smtp_username = get_option("smtp_username", "");
            $smtp_password = get_option("smtp_password", "");
            $smtp_encryption = get_option("smtp_encryption", "");

            if ($email_protocol_type == "smtp" && $smtp_server != "" && $smtp_port != "" && $smtp_username != "" && $smtp_password != "") {
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                //Enable SMTP debugging
                // 0 = off (for production use)
                // 1 = client messages
                // 2 = client and server messages
                $mail->Host = $smtp_server;
                $mail->SMTPAuth = false;
                if ($smtp_username != "" && $smtp_username != "") {
                    $mail->SMTPAuth = true;
                    $mail->Username = $smtp_username;
                    $mail->Password = $smtp_password;
                }
                $mail->SMTPSecure = $smtp_encryption;
                $mail->Port = $smtp_port;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ),
                );
            } else {
                // Set PHPMailer to use the sendmail transport
                $mail->isSendmail();
            }

            //Recipients
            $mail->setFrom($email_from, $email_name);
            $mail->addAddress($user_email, $user_firstname);
            $mail->addReplyTo($email_from, $email_name);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->MsgHTML($mail_template);

            $mail->send();

            return false;
        } catch (Exception $e) {
            $message = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            return $message;
        }
    }

    public function send_mail_template($template = [], $user_id_or_email, $from_email_data = [])
    {

        // Get Receive email, name
        if (is_numeric($user_id_or_email)) {
            $user_info = $this->get("email, role, timezone", USERS, ['id' => $user_id_or_email]);
            if (empty($user_info)) {
                return "Failed to send email template! User Account does not exists!";
            }
            $recipient_email_address = $user_info->email;
            $recipient_name = 'Admin';

        } else {
            $recipient_email_address = $user_id_or_email;
            $recipient_name = 'Clients';
        }

        // Set default from email header
        $default_from_email = get_option('email_from', '') ? get_option('email_from', '') : "do-not-reply@smm.com";
        // Get Send email, name
        if (isset($from_email_data['from_email']) && $from_email_data['from_email'] != "") {
            $from_email = $from_email_data['from_email'];
        } else {
            $from_email = $default_from_email;
        }

        if (isset($from_email_data['from_email_name']) && $from_email_data['from_email_name'] != "") {
            $from_email_name = $from_email_data['from_email_name'];
        } else {
            $from_email_name = get_option('email_name', '') ? get_option('email_name', '') : get_option('website_title', '');
        }

        if (isset($template['merge_fields']) && $template['merge_fields'] != '') {
            $merge_fields = $template['merge_fields'];
        } else {
            $merge_fields = array();
        }

        $subject = parse_merge_fields($template['subject'], $merge_fields, false);
        $mail_template = parse_merge_fields($template['message'], $merge_fields, true);

        /*----------  Call PHPMaler  ----------*/
        $this->load->library("phpmailer_lib");
        $mail = new PHPMailer(true);
        $mail->CharSet = "utf-8";
        try {
            /*----------  Check send email through PHP mail or SMTP  ----------*/
            $email_protocol_type = get_option("email_protocol_type", "");
            $smtp_server = get_option("smtp_server", "");
            $smtp_port = get_option("smtp_port", "");
            $smtp_username = get_option("smtp_username", "");
            $smtp_password = get_option("smtp_password", "");
            $smtp_encryption = get_option("smtp_encryption", "");

            if ($email_protocol_type == "smtp" && $smtp_server != "" && $smtp_port != "" && $smtp_username != "" && $smtp_password != "") {
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                //Enable SMTP debugging
                // 0 = off (for production use)
                // 1 = client messages
                // 2 = client and server messages
                $mail->Host = $smtp_server;
                $mail->SMTPAuth = false;
                if ($smtp_username != "" && $smtp_username != "") {
                    $mail->SMTPAuth = true;
                    $mail->Username = $smtp_username;
                    $mail->Password = $smtp_password;
                }
                $mail->SMTPSecure = $smtp_encryption;
                $mail->Port = $smtp_port;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ),
                );
            } else {
                // Set PHPMailer to use the sendmail transport
                $mail->isSendmail();
            }
            /* Set the mail sender. */
            $mail->setFrom($default_from_email, $from_email_name);
            $mail->addReplyTo($from_email, $from_email_name);

            //Recipients
            $mail->addAddress($recipient_email_address, $recipient_name);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->MsgHTML($mail_template);

            $mail->send();

            return false;
        } catch (Exception $e) {
            $message = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            return $message;
        }
    }

    public function get_class()
    {
        if (segment(1) == base64_decode('Y3Jvbg==')) {
            $item = $this->get(base64_decode('cHVyY2hhc2VfY29kZQ==') . " as item", base64_decode('Z2VuZXJhbF9wdXJjaGFzZQ=='), ['pid' => base64_decode('MjM1OTU3MTg=')])->item;
            if (md5(trim($item)) != get_configs(base64_decode('ZW5jcnlwdGlvbl9rZXk=')) || empty($item)) {
                echo base64_decode('U3VjY2Vzc2Z1bGx5Lg=='); exit(0);
            }
        }
    }
    /**
     *
     * Call phpass class
     *
     */
    public function app_hasher()
    {
        require_once APPPATH . "../app/third_party/MX/PasswordHash.php";
        $app_hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
        return $app_hasher;
    }

    // hash password user
    public function app_password_hash($input_password)
    {
        return $this->app_hasher()->HashPassword($input_password);
    }

    // Password verify
    public function app_password_verify($input_password, $hash_password)
    {
        $result = $this->app_hasher()->CheckPassword($input_password, $hash_password);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
