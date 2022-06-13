<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tickets_model extends MY_Model 
{

    protected $tb_users;
    protected $tb_main;
    protected $tb_services;
    protected $filter_accepted;
    protected $field_search_accepted;
    protected $bulk_action_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = TICKETS;

        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = app_config('config')['search']['tickets'];

        $this->bulk_action_accepted = (array_key_exists('tickets', app_config('config')['bulk_action'])) ? app_config('config')['bulk_action']['tickets'] : app_config('config')['bulk_action']['default'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
       
        if ($option['task'] == 'list-items') {
            $this->db->select('tk.id, tk.ids, tk.uid, tk.subject, tk.description, tk.status, tk.user_read, tk.admin_read, tk.created');
            $this->db->select('u.email');
            $this->db->from($this->tb_main . ' tk');
            $this->db->join($this->tb_users." u", "tk.uid = u.id", 'left');
            
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'email') ? 'u.'.$column : 'tk.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'email') ? 'u.'.$params['search']['field'] : 'tk.'.$params['search']['field'];
                $this->db->like($column, $params['search']['query']); 
            }
            $this->db->order_by('tk.admin_read', 'DESC');
            $this->db->order_by("FIELD (tk.status, 'pending', 'answered', 'closed')");

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
            // Update admin read
            $data_item = [
                'admin_read' => 0,
                'changed'    => NOW,
            ];
            $this->db->update($this->tb_main, $data_item, ['id' => $params['id']]);
        }
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;

        // Count items for pagination
        if ($option['task'] == 'count-items-for-pagination') {
            $this->db->select('tk.id');
            $this->db->from($this->tb_main . ' tk');
            $this->db->join($this->tb_users." u", "tk.uid = u.id", 'left');

            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'email') ? 'u.'.$column : 'tk.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'email') ? 'u.'.$params['search']['field'] : 'tk.'.$params['search']['field'];
                $this->db->like($column, $params['search']['query']); 
            }
            $query = $this->db->get();
            $result = $query->num_rows();
        }
        return $result;
    }

    public function delete_item($params = null, $option = null)
    {
        $result = [];
        if($option['task'] == 'delete-item'){
            $item = $this->get("id, ids", $this->tb_main, ['id' => $params['id']]);
            if ($item) {
                $this->db->delete($this->tb_main, ["id" => $params['id']]);
                $this->db->delete($this->tb_ticket_message, ["ticket_id" => $params['id']]);
                $result = [
                    'status' => 'success',
                    'message' => 'Deleted successfully',
                    "ids"     => $item->ids,
                ];
            }else{
                $result = [
                    'status' => 'error',
                    'message' => 'There was an error processing your request. Please try again later',
                ];
            }
        }
        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        switch ($option['task']) {
            case 'add-item-ticket-massage':
                $item = $this->get('id, ids, uid, subject', $this->tb_main, ['ids' => post('ids')], '', '', true);
                if (!$item) return ["status"  => "success", "message" => 'There was some wrong with your request'];
                $data_item = [
                    'status'     => 'answered',
                    'user_read'  => 1,
                    'admin_read' => 0,
                    'changed'    => NOW,
                ];
                $author = $_SESSION['user_current_info']['first_name'] . ' ' . $_SESSION['user_current_info']['last_name'];
                $data_item_ticket_message = [
                    'ids'        => ids(),
                    'message'    => $this->input->post('message', true),
                    'uid'        => session('uid'),
                    "author"     => $author,
                    "support"    => 1,
                    'ticket_id'  => $item['id'],
                    'created'    => NOW,
                    'changed'    => NOW,
                ];
                $this->db->update($this->tb_main, $data_item, ['id' => $item['id']]);
                $this->db->insert($this->tb_ticket_message, $data_item_ticket_message);

                if (get_option("is_ticket_notice_email", '')) {
                    $subject           = $item['subject'];
                    $ticket_number     = $item['id'];
                    $subject           = get_option("website_name", "") ." - #Ticket"."$ticket_number - $subject";
                    $check_email_issue = $this->send_email($subject, $message , $item['uid'], false);
                    if ($check_email_issue) {
                        return ["status"  => "error", "message" => $check_email_issue];
                    }
                }
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'change-status':

                if ($params['status'] === 'unread') {
                    $data_item = [
                        'user_read'  => 0,
                        'admin_read' => 1,
                        'changed'    => NOW,
                    ];
                    $this->db->update($this->tb_main, $data_item, ['id' => $params['id']]);
                } else {
                    $this->db->update($this->tb_main, ['status' => $params['status'], 'changed' => NOW], ["id" => $params['id']]);
                }
                return ["status"  => true];
                break;

            case 'bulk-action':
                $action_type = strtolower($params['type']);
                if (!in_array($action_type, $this->bulk_action_accepted) || empty($params['ids'])) {
                    return ["status"  => "error", "message" => 'Please choose at least one item'];
                }
                $arr_ids = convert_str_number_list_to_array($params['ids']);
                
                if ($action_type == 'delete') {
                    // main table
                    $this->db->where_in('id', $arr_ids);
                    $this->db->delete($this->tb_main);
                    // related table
                    $this->db->where_in('ticket_id', $arr_ids);
                    $this->db->delete($this->tb_ticket_message);
                    return ["status"  => "success", "message" => 'Update successfully'];
                }

                if ($action_type == 'unread') {
                    $data_item = [
                        'user_read'  => 0,
                        'admin_read' => 1,
                        'changed'    => NOW,
                    ];
                    $this->db->where_in('id', $arr_ids);
                    $this->db->update($this->tb_main, $data_item);
                    return ["status"  => "success", "message" => 'Update successfully'];
                }

                if (in_array($action_type, ['pending', 'closed', 'answered'])) {
                    $this->db->where_in('id', $arr_ids);
                    $this->db->update($this->tb_main, ['status' => $action_type, 'changed' => NOW]);
                    return ["status"  => "success", "message" => 'Update successfully'];
                }
                break;
        }
    }
}
