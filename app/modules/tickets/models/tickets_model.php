<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tickets_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = TICKETS;
    }

    
    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items') {
            $this->db->select('id, ids, uid, subject, user_read, created, changed, status');
            $this->db->from($this->tb_main);
            $this->db->where('uid', session('uid'));
            $this->db->order_by("FIELD ( status, 'answered', 'pending', 'closed')");
            $this->db->order_by('changed', 'DESC');
            if ($params['pagination']['limit'] != "" && $params['pagination']['start'] >= 0) {
                $this->db->limit($params['pagination']['limit'], $params['pagination']['start']);
            }
            $query = $this->db->get();
            $result = $query->result_array();
        }

        if ($option['task'] == 'list-items-ticket-message') {
            $this->db->select('tm.id, tm.ids, tm.uid, tm.message, tm.support, tm.created');
            $this->db->select('u.first_name, u.last_name');
            $this->db->from($this->tb_ticket_message . ' tm');
            $this->db->join($this->tb_users." u", "tm.uid = u.id", 'left');
            $this->db->where('tm.ticket_id', $params['ticket_id']);
            $this->db->order_by('tm.id', 'DESC');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;
        // Count items for pagination
        if ($option['task'] == 'count-items-for-pagination') {
            $this->db->select('id');
            $this->db->from($this->tb_main);
            $this->db->where('uid', session('uid'));
            $query = $this->db->get();
            $result = $query->num_rows();
        }
        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            $result = $this->get("id, ids, uid, subject, description, status, user_read, admin_read, created", $this->tb_main, ['id' => $params['id']], '', '', true);
        }

        if ($option['task'] == 'view-get-item') {
            $this->db->select('tk.id, tk.ids, tk.uid, tk.subject, tk.description, tk.status, tk.created');
            $this->db->select('u.email, u.first_name, u.last_name');
            $this->db->from($this->tb_main . ' tk');
            $this->db->join($this->tb_users." u", "tk.uid = u.id", 'left');
            $this->db->where('tk.id', $params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
            $data_item = [
                'user_read' => 0,
                'changed'    => NOW,
            ];
            $this->db->update($this->tb_main, $data_item, ['id' => $params['id']]);
        }
        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'add-item') {
            $data = array(
                "ids"         => ids(),
                "uid"         => session('uid'),
                "subject"     => $params['subject'],
                "description" => $params['description'],
                'user_read'   => 0,
                'admin_read'  => 1,
                "changed"     => NOW,
                "created"     => NOW,
            );
            $this->db->insert($this->tb_main, $data);
            if ($this->db->affected_rows() > 0) {
                if (get_option('is_ticket_notice_email_admin', 0) && get_role('user')) {
                    $ticket_id = $this->db->insert_id();
                    $admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'", "id", "ASC")->id;
                    if ($admin_id == "") {
                        return ["status"  => "error", "message" => lang('There_was_an_error_processing_your_request_Please_try_again_later')];
                    }
                    $subject = "{{website_name}}" . " - New Ticket #" . $ticket_id . " - [" . $subject . "]";
                    $template = ['subject' => $params['subject'], 'message' => $params['description'], 'type' => 'default'];
                    $user_info = session('user_current_info');
                    $username = $user_info['first_name'] . " " . $user_info['last_name'];
                    $from_email_data = ['from_email' => $user_info['email'], 'from_email_name' => $username];
                    $send_message = $this->model->send_mail_template($template, $admin_id, $from_email_data);
                    if ($send_message) {
                        return ["status"  => "error", "message" => $send_message];
                    }
                }
                return ["status"  => "success", "message" => lang("ticket_created_successfully")];
            } else {
                return ["error"  => "success", "message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")];
            }
        }

        if ($option = 'add-item-ticket-massage') {
            $item = $this->get('id, ids, uid, subject', $this->tb_main, ['ids' => post('ids')], '', '', true);
                if (!$item) return ["status"  => "success", "message" => 'There was some wrong with your request'];
                $data_item = [
                    'status'     => 'pending',
                    'user_read'  => 0,
                    'admin_read' => 1,
                    'changed'    => NOW,
                ];
                $author = $_SESSION['user_current_info']['first_name'] . ' ' . $_SESSION['user_current_info']['last_name'];
                $data_item_ticket_message = [
                    'ids'        => ids(),
                    'message'    => $this->input->post('message', true),
                    'uid'        => session('uid'),
                    "author"     => $author,
                    "support"    => 0,
                    'ticket_id'  => $item['id'],
                    'created'    => NOW,
                    'changed'    => NOW,
                ];
                $this->db->update($this->tb_main, $data_item, ['id' => $item['id']]);
                $this->db->insert($this->tb_ticket_message, $data_item_ticket_message);
                return ["status"  => "success", "message" => lang("Update_successfully")];
        }

        return $result;
    }


    function get_tickets($total_rows = false, $status = "", $limit = "", $start = ""){
        $is_admin = 0;
        if (get_role("admin")) {
            $is_admin = 1;
        }

        if (!$is_admin) {
            $this->db->where("tk.uid", session("uid"));
        }
        if($status != "all" && !empty($status)){
            $this->db->where("tk.status", $status);
        }
        if ($limit != "" && $start >= 0) {
            $this->db->limit($limit, $start);
        }

        $this->db->select('tk.*, u.email as user_email, u.last_name, u.first_name');
        $this->db->from($this->tb_tickets." tk");
        $this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');

        if($is_admin){
            $this->db->order_by('tk.admin_read', 'DESC');
            $this->db->order_by("FIELD ( tk.status, 'pending', 'answered', 'closed')");
        }
        
        if(!$is_admin){
            $this->db->order_by("FIELD ( tk.status, 'answered', 'pending', 'closed')");
        }
        $this->db->order_by('tk.changed', 'DESC');
        $query = $this->db->get();
        if ($total_rows) {
            $result = $query->num_rows();
            return $result;
        }else{
            $result = $query->result();
            return $result;
        }
        return false;
    }

    function get_ticket_detail($id){
        if (get_role("user")) {
            $this->db->where("tk.uid", session("uid"));
        }
        $this->db->select('tk.*, u.email as user_email, u.first_name, u.last_name,u.role');
        $this->db->from($this->tb_tickets." tk");
        $this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');
        $this->db->where("tk.id", $id);
        $this->db->order_by('tk.changed', 'DESC');
        $query = $this->db->get();
        if($query->row()){
            return $data = $query->row();
        }else{
            return false;
        }
    }

    function get_ticket_content($id){
        // if (!get_role("admin")) {
        // 	$this->db->where("tk_m.uid", session("uid"));
        // }
        $this->db->select('tk_m.*, u.email as user_email, u.first_name, u.last_name,u.role');
        $this->db->from($this->tb_ticket_message." tk_m");
        $this->db->join($this->tb_users." u", "u.id = tk_m.uid", 'left');
        $this->db->where("tk_m.ticket_id", $id);
        $this->db->order_by('tk_m.created', 'ASC');
        $query = $this->db->get();
        if($query->result()){
            return $data = $query->result();
        }else{
            return false;
        }
    }

    function get_search_tickets($k){
        $k = trim(htmlspecialchars($k));

        if (get_role("user")) {
            $this->db->select('tk.*, u.email as user_email, u.first_name, u.last_name');
            $this->db->from($this->tb_tickets." tk");
            $this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');

            if ($k != "" && strlen($k) >= 2) {
                $this->db->where("(`tk`.`id` LIKE '%".$k."%' ESCAPE '!' OR `tk`.`subject` LIKE '%".$k."%' ESCAPE '!' OR  `tk`.`status` LIKE '%".$k."%' ESCAPE '!')");
            }	

            $this->db->where("tk.uid", session("uid"));
            $this->db->order_by("FIELD ( tk.status, 'answered', 'pending', 'closed')");
            $this->db->order_by('tk.changed', 'DESC');
            $query = $this->db->get();

        }else{
            $this->db->select('tk.*, u.email as user_email, u.first_name, u.last_name');
            $this->db->from($this->tb_tickets." tk");
            $this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');

            if ($k != "" && strlen($k) >= 2) {
                $this->db->where("(`tk`.`id` LIKE '%".$k."%' ESCAPE '!' OR `tk`.`subject` LIKE '%".$k."%' ESCAPE '!' OR  `tk`.`status` LIKE '%".$k."%' ESCAPE '!' OR  `u`.`email` LIKE '%".$k."%' ESCAPE '!' OR  `u`.`last_name` LIKE '%".$k."%' ESCAPE '!' OR  `u`.`first_name` LIKE '%".$k."%' ESCAPE '!')");
            }	
            $this->db->order_by("FIELD ( tk.status, 'new', 'pending', 'closed')");
            $this->db->order_by('tk.changed', 'DESC');
            $query = $this->db->get();
        }
        if($query->result()){
            return $data = $query->result();
        }else{
            return false;
        }
    }

    // Get Count of orders by Search query
    public function get_count_tickets_by_search($search = []){
        $k = trim($search['k']);
        $where_like = "";
        if (get_role("user")) {
            $this->db->where("tk.uid", session("uid"));
            $where_like = "(`tk`.`id` LIKE '%".$k."%' ESCAPE '!' OR `tk`.`subject` LIKE '%".$k."%' ESCAPE '!')";
        }else{
            switch ($search['type']) {
                case 1:
                    #Ticket ID
                    $where_like = "`tk`.`id` LIKE '%".$k."%' ESCAPE '!'";
                    break;
                case 2:
                    # User Email
                    $where_like = "`u`.`email` LIKE '%".$k."%' ESCAPE '!'";
                    break;

                case 3:
                    # Subjects
                    $where_like = "`tk`.`subject` LIKE '%".$k."%' ESCAPE '!'";
                    break;
            }
        }
        $this->db->select('tk.id');
        $this->db->from($this->tb_tickets." tk");
        $this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');
        if ($where_like) $this->db->where($where_like);
        $query = $this->db->get();
        $number_row = $query->num_rows();
        return $number_row;
    }

    // Search Logs by keywork and search type
    public function search_logs_by_get_method($search, $limit = "", $start = ""){
        $k = trim($search['k']);
        $where_like = "";
        if (get_role("user")) {
            $this->db->select('tk.*, u.email as user_email, u.first_name, u.last_name');
            $this->db->from($this->tb_tickets." tk");
            $this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');

            $this->db->where("(`tk`.`id` LIKE '%".$k."%' ESCAPE '!' OR `tk`.`subject` LIKE '%".$k."%' ESCAPE '!')");

            $this->db->where("tk.uid", session("uid"));
            $this->db->order_by("FIELD ( tk.status, 'answered', 'pending', 'closed')");
            $this->db->order_by('tk.changed', 'DESC');
            $this->db->limit($limit, $start);
            $query = $this->db->get();
            $result = $query->result();
        }else{
            switch ($search['type']) {
                case 1:
                    #Ticket ID
                    $where_like = "`tk`.`id` LIKE '%".$k."%' ESCAPE '!'";
                    break;
                case 2:
                    # User Email
                    $where_like = "`u`.`email` LIKE '%".$k."%' ESCAPE '!'";
                    break;

                case 3:
                    # Subjects
                    $where_like = "`tk`.`subject` LIKE '%".$k."%' ESCAPE '!'";
                    break;
            }

            $this->db->select('tk.*, u.email as user_email, u.first_name, u.last_name');
            $this->db->from($this->tb_tickets." tk");
            $this->db->join($this->tb_users." u", "u.id = tk.uid", 'left');

            if ($where_like) $this->db->where($where_like);

            $this->db->order_by('tk.admin_read', 'DESC');
            $this->db->order_by("FIELD ( tk.status, 'pending', 'answered', 'closed')");
            $this->db->order_by('tk.changed', 'DESC');
            $this->db->limit($limit, $start);
            $query = $this->db->get();
            $result = $query->result();
        }
        return $result;
    }
}
