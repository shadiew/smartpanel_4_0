<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'./modules/auth/libraries/google/autoload.php';

class auth extends My_UserController
{
    public $tb_users;
    public $tb_user_logs;
    public $tb_user_block_ip;
    public $google_capcha;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'model');
        $this->tb_users 			= USERS;
        $this->tb_user_logs   		= USER_LOGS;
        $this->tb_user_block_ip   	= USER_BLOCK_IP;

        if (get_option("enable_goolge_recapcha", '')  &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
            $this->recaptcha = new \ReCaptcha\ReCaptcha(get_option('google_capcha_secret_key'));
        }

        if(session("uid") && segment(2) != 'logout'){
            redirect(cn("statistics"));
        }
    }

    public function index(){
        redirect(cn("auth/login"));
    }


    public function login(){
        $this->lang->load('../../../../themes/'.get_theme().'/language/english/'.get_theme());
        $data = array();
        $this->template->set_layout('blank_page');
        $this->template->build('../../../themes/'.get_theme().'/views/sign_in', $data);
    }

    public function logout(){
        /*----------  Insert User logs  ----------*/
        $this->insert_user_activity_logs('logout');
        unset_session("uid");
        unset_session("auto_confirm");
        unset_session("user_current_info");
        $this->session->sess_destroy();
        if (get_option("is_maintenance_mode")) {
            delete_cookie("verify_maintenance_mode");
        }
        redirect(cn(''));
    }

    public function signup(){
        if(get_option('disable_signup_page')){
            redirect(cn('auth/login'));
        }
        $this->lang->load('../../../../themes/'.get_theme().'/language/english/'.get_theme());
        $data = array();
        $this->template->set_layout('blank_page');
        $this->template->build('../../../themes/'.get_theme().'/views/sign_up', $data);
    }

    public function forgot_password(){
        $this->lang->load('../../../../themes/'.get_theme().'/language/english/'.get_theme());
        $data = array();
        $this->template->set_layout('blank_page');
        $this->template->build('../../../themes/'.get_theme().'/views/forgot_password', $data);
    }

    public function reset_password(){
        /*----------  check users exists  ----------*/
        $reset_key = segment(3);
        $user = $this->model->get("id, ids, email", $this->tb_users, "reset_key = '{$reset_key}'");
        if (!empty($user)) {
            // redirect to change password page
            $data = array(
                "reset_key" => $reset_key,
            );
            $this->lang->load('../../../../themes/'.get_theme().'/language/english/'.get_theme());
            $this->template->set_layout('blank_page');
            $this->template->build('../../../themes/'.get_theme().'/views/change_password', $data);
        }else{
            redirect(cn("auth/login"));
        }
    }

    public function ajax_sign_up($ids = ""){
        _is_ajax(get_class($this));
        $terms              = post('terms');
        $first_name         = post('first_name');
        $last_name          = post('last_name');
        $email              = post('email');
        $password           = post('password');
        $re_password        = post('re_password');
        $timezone           = post('timezone');
        if($first_name == '' || $last_name == '' || $password == ''|| $email == ''){
            ms(array(
                'status'  => 'error',
                'message' => lang("please_fill_in_the_required_fields"),
            ));
        }

        if (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
            ms(array(
                'status'  => 'error',
                'message' => lang("only_letters_and_white_space_allowed"),
            ));
        }

        if (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
            ms(array(
                'status'  => 'error',
                'message' => lang("only_letters_and_white_space_allowed"),
            ));
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              ms(array(
                'status'  => 'error',
                'message' => lang("invalid_email_format"),
            ));
        }

        if($password != ''){
            if(strlen($password) < 6){
                ms(array(
                    'status'  => 'error',
                    'message' => lang("Password_must_be_at_least_6_characters_long"),
                ));
            }

            if($re_password!= $password){
                ms(array(
                    'status'  => 'error',
                    'message' => lang("Password_must_be_at_least_6_characters_long"),
                ));
            }
        }

        if (!$terms) {
            ms(array(
                'status'  => 'error',
                'message' => lang("oops_you_must_agree_with_the_terms_of_services_or_privacy_policy"),
            ));
        }

        if ($this->is_banned_ip_address()) {
            ms(array(
                "status"  => "error",
                "message" => "Access from your IP address has been blocked for security reasons. Please contact the administrator!"
            ));
        }

        if (isset($_POST['g-recaptcha-response']) && get_option("enable_goolge_recapcha", '')  &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
            $resp = $this->recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                      ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if (!$resp->isSuccess()) {
                ms(array(
                    'status'  => 'error',
                    'message' => lang("please_verify_recaptcha"),
                ));
            }
        }

        // Get Settings (Limit payments) for new user
        $limit_payments = $this->model->get_payments_list_for_new_user();
        $settings = [
            'limit_payments' => $limit_payments
        ];

        $data = array(
            "ids"					  => ids(),
            "first_name"              => $first_name,
            "last_name"               => $last_name,
            "password"                => $this->model->app_password_hash($password),
            "timezone"                => $timezone,
            "status"                  => get_option('is_verification_new_account', 0) ? 0 : 1,
            "api_key"                 => create_random_string_key(32),
            "settings"                => json_encode($settings),
            'history_ip'              => get_client_ip(),
            "reset_key"               => create_random_string_key(32),
            "activation_key"          => create_random_string_key(32),
            "changed"                 => NOW,
        );
        
        if (get_option("enable_signup_skype_field", '')) {
            $skype_id			= post("skype_id");
            if($skype_id == ''){
                ms(array(
                    'status'  => 'error',
                    'message' => lang("please_fill_in_the_required_fields"),
                ));
            }
            $more_information = array(
                "skype_id"        => $skype_id,
            );
            $data['more_information'] = json_encode($more_information);
        }

        if($email != ''){
            // check email
            $checkUserEmail = $this->model->get('email, ids', $this->tb_users,"email='{$email}'");
            if(!empty($checkUserEmail)){
                ms(array(
                    'status'  => 'error',
                    'message' => lang("An_account_for_the_specified_email_address_already_exists_Try_another_email_address"),
                ));
            }

            $data['created'] = NOW;
            $data['email']   = $email;
            $data['login_type']  = 'Sign_up_page';

            if($this->db->insert($this->tb_users, $data)){
                $uid = $this->db->insert_id();
                if (get_option('is_verification_new_account', 0)) {
                    $check_send_email_issue = $this->model->send_email(get_option('verification_email_subject', ''), get_option('verification_email_content', 0), $uid);
                    if($check_send_email_issue){
                        ms(array(
                            "status" => "error",
                            "message" => $check_send_email_issue,
                        ));
                    }

                    ms(array(
                        "status"  => "success",
                        "message" => lang('thank_you_for_signing_up_please_check_your_email_to_complete_the_account_verification_process')
                    ));
                }else{
                    set_session('uid', $uid);
                    $data_session = array(
                        'role'       => 'user',
                        'email'      => $email,
                        'first_name' => $first_name,
                        'last_name'  => $last_name,
                        'timezone'   => $timezone,
                    );
                    set_session('user_current_info', $data_session);
                    
                    /*----------  Insert User logs  ----------*/
                    $this->insert_user_activity_logs('logout');

                    /*----------  Check is send welcome email or not  ----------*/
                    if (get_option("is_welcome_email", '')) {
                        $check_send_email_issue = $this->model->send_email(get_option('email_welcome_email_subject', ''), get_option('email_welcome_email_content', 0), $uid);
                        if($check_send_email_issue){
                            ms(array(
                                "status" => "error",
                                "message" => $check_send_email_issue,
                            ));
                        }
                    }

                    /*----------  Send email notificaltion for Admin  ----------*/
                    if (get_option("is_new_user_email", '')) {
                        $subject = get_option('email_new_registration_subject', '');
                        $subject = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $subject);

                        $email_content = get_option('email_new_registration_content', '');
                        $email_content = str_replace("{{user_firstname}}", $first_name, $email_content);
                        $email_content = str_replace("{{user_lastname}}", $last_name, $email_content);
                        $email_content = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $email_content);
                        $email_content = str_replace("{{user_timezone}}", $timezone, $email_content);
                        $email_content = str_replace("{{user_email}}", $email, $email_content);

                        $admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'","id","ASC")->id;
                        if ($admin_id == "") {
                            $admin_id = 1;
                        }
                        
                        $check_send_email_issue = $this->model->send_email( $subject, $email_content, $admin_id, false);
                        if($check_send_email_issue){
                            ms(array(
                                "status" => "error",
                                "message" => $check_send_email_issue,
                            ));
                        }
                    }
                }

                ms(array(
                    'status'  => 'success',
                    'message' => lang("welcome_you_have_signed_up_successfully"),
                ));
            }else{
                ms(array(
                    "status"  => "Failed",
                    "message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
                ));
            }
        }
    }

    public function activation($activation_key = ""){
        $user = $this->model->get("id, first_name, last_name, timezone, email, activation_key", $this->tb_users, "activation_key = '".$activation_key."'");
        if(!empty($user)){
            $this->db->update($this->tb_users, ['status' => 1, 'activation_key' => 1], ['id' => $user->id]);
            /*----------  Check is send welcome email or not  ----------*/
            if (get_option("is_welcome_email", '')) {
                $check_send_email_issue = $this->model->send_email(get_option('email_welcome_email_subject', ''), get_option('email_welcome_email_content', 0), $user->id);
                if($check_send_email_issue){
                    ms(array(
                        "status" => "error",
                        "message" => $check_send_email_issue,
                    ));
                }
            }

            /*----------  Send email notificaltion for Admin  ----------*/
            if (get_option("is_new_user_email", '')) {
                $subject = get_option('email_new_registration_subject', '');
                $subject = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $subject);

                $email_content = get_option('email_new_registration_content', '');
                $email_content = str_replace("{{user_firstname}}", $user->first_name, $email_content);
                $email_content = str_replace("{{user_lastname}}", $user->last_name, $email_content);
                $email_content = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $email_content);
                $email_content = str_replace("{{user_timezone}}", $user->timezone, $email_content);
                $email_content = str_replace("{{user_email}}", $user->email, $email_content);

                $admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'","id","ASC")->id;
                if ($admin_id == "") {
                    $admin_id = 1;
                }
                
                $check_send_email_issue = $this->model->send_email( $subject, $email_content, $admin_id, false);
                if($check_send_email_issue){
                    ms(array(
                        "status" => "error",
                        "message" => $check_send_email_issue,
                    ));
                }
            }

            $this->lang->load('../../../../themes/'.get_theme().'/language/english/'.get_theme());
            $data = array();
            $this->template->set_layout('blank_page');
            $this->template->build('../../../themes/'.get_theme().'/views/activation_successfully', $data);
        }else{
            redirect(cn("auth/login"));
        }
    }

    public function ajax_sign_in(){
        _is_ajax(get_class($this));
        $email    = post("email");
        $password = md5(post("password"));
        $remember = post("remember");

        if($email == ""){
            ms(array(
                "status"  => "error",
                "message" => lang("email_is_required")
            ));
        }

        if($password == ""){
            ms(array(
                "status"  => "error",
                "message" => lang("Password_is_required")
            ));
        }

        if ($this->is_banned_ip_address()) {
            ms(array(
                "status"  => "error",
                "message" => "Access from your IP address has been blocked for security reasons. Please contact the administrator!"
            ));
        }

        if (isset($_POST['g-recaptcha-response']) && get_option("enable_goolge_recapcha", '')  &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
            $resp = $this->recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                      ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if (!$resp->isSuccess()) {
                ms(array(
                    'status'  => 'error',
                    'message' => lang("please_verify_recaptcha"),
                ));
            }
        }

        $user = $this->model->get("id, status, ids, email, password, role, first_name, last_name, timezone", $this->tb_users, ['email' => $email]);

        $error = false;
        if (!$user) {
            $error = true;
        }else{
            // check the first with old hash password method
            if ($user->password == md5(post("password"))) {
                // update new password_hash
                $this->db->update($this->tb_users, ['password' => $this->model->app_password_hash(post("password"))] , ['id' => $user->id]);
                $error = false;
            }else{
                // check the last hash password
                if ($this->model->app_password_verify(post("password"), $user->password)) {
                    $error = false;
                }else{
                    $error = true;
                }
            }
        }
        
        if(!$error){
            if($user->status != 1){
                ms(array(
                    "status"  => "error",
                    "message" => lang("your_account_has_not_been_activated")
                ));
            }
            set_session("uid", $user->id);
            $data_session = array(
                'role'       => $user->role,
                'email'      => $user->email,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'timezone'   => $user->timezone,
            );
            set_session('user_current_info', $data_session);
            $this->model->history_ip($user->id);
            /*----------  Insert User logs  ----------*/
            $this->insert_user_activity_logs();
            
            if($remember){
                set_cookie("cookie_email", encrypt_encode(post("email")), 1209600);
                set_cookie("cookie_pass", encrypt_encode(post("password")), 1209600);
            }else{
                delete_cookie("cookie_email");
                delete_cookie("cookie_pass");
            }

            // Update new Reset key
            $this->db->update($this->tb_users, ['reset_key' => ids() ], ['id' => $user->id]);

            ms(array(
                "status"  => "success",
                "message" => lang("Login_successfully")
            ));
        }else{
            ms(array(
                "status"  => "error",
                "message" => lang("email_address_and_password_that_you_entered_doesnt_match_any_account_please_check_your_account_again")
            ));
        }
    }

    public function ajax_forgot_password(){
        _is_ajax(get_class($this));
        $email = post("email");

        if($email == ""){
            ms(array(
                "status"  => "error",
                "message" => lang("email_is_required")
            ));
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
              ms(array(
                "status"  => "error",
                "message" => lang("invalid_email_format")
            ));
        }

        if (isset($_POST['g-recaptcha-response']) && get_option("enable_goolge_recapcha", '')  &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
            $resp = $this->recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                      ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if (!$resp->isSuccess()) {
                ms(array(
                    'status'  => 'error',
                    'message' => lang("please_verify_recaptcha"),
                ));
            }
        }

        $user = $this->model->get("*", USERS, "email = '{$email}'");
        if(!empty($user)){
            $email_error = $this->model->send_email(get_option("email_password_recovery_subject", ""), get_option("email_password_recovery_content", ""), $user->id);

            if($email_error){
                ms(array(
                    "status"  => "error",
                    "message" => $email_error
                ));
            }

            ms(array(
                "status"  => "success",
                "message" => lang("we_have_send_you_a_link_to_reset_password_and_get_back_into_your_account_please_check_your_email"),
            ));
        }else{
            ms(array(
                "status" => "error",
                "message" => lang("the_account_does_not_exists")
            ));
        }
    }

    public function ajax_reset_password($reset_key = ""){
        _is_ajax(get_class($this));
        $user = $this->model->get("id, ids, email", $this->tb_users, "reset_key = '{$reset_key}'");
        $password           = post('password');
        $re_password        = post('re_password');

        if($password == '' || $re_password == ''){
            ms(array(
                'status'  => 'error',
                'message' => lang("please_fill_in_the_required_fields"),
            ));
        }

        if($password != ''){
            if(strlen($password) < 6){
                ms(array(
                    'status'  => 'error',
                    'message' => lang("Password_must_be_at_least_6_characters_long"),
                ));
            }

            if($re_password != $password){
                ms(array(
                    'status'  => 'error',
                    'message' => lang("Password_must_be_at_least_6_characters_long"),
                ));
            }
        }

        if (!empty($user)) {
            $data = array(
                "password"  => $this->model->app_password_hash($password),
                "reset_key" => ids(),
                "changed"	=> NOW,
            );

            $this->db->update($this->tb_users, $data, "id = '".$user->id."'");
            if ($this->db->affected_rows() > 0) {
                ms(array(
                    "status"   => "success",
                    "message"  => lang("your_password_has_been_successfully_changed"),
                ));
            }else{
                ms(array(
                    "status"  => "Failed",
                    "message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
                ));
            }
        }else{
            ms(array(
                "status"  => "error",
                "message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
            ));
        }
    }

    private function insert_user_activity_logs($type = ''){
        if (!$this->db->table_exists($this->tb_user_logs)) {
            return false;
        }
        if (session('uid')) {
            $ip_address = get_client_ip();
            $data_user_logs = array(
                "ids"		=> ids(),
                "uid"		=> session('uid'),
                "ip"		=> $ip_address,
                "type"		=> ($type == 'logout') ? 0 : 1,
                "created"   => NOW,
            );
            $location = get_location_info_by_ip($ip_address);
            if ($location->country != 'Unknown' && $location->country != '') {
                $data_user_logs['country'] = $location->country;
            }else{
                $data_user_logs['country'] = 'Unknown';
            }
            $this->db->insert($this->tb_user_logs, $data_user_logs);
        }
    }

    private function is_banned_ip_address(){
        if (!$this->db->table_exists($this->tb_user_block_ip)) {
            return false;
        }
        $ip_address = get_client_ip();
        $check_item = $this->model->get('ip', $this->tb_user_block_ip, ["ip" => $ip_address]);
        if (!empty($check_item)) {
            return true;
        }
        return false;
    }
}