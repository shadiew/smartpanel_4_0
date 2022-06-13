<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users_model extends MY_Model 
{

    protected $tb_main;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = USERS;

        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = app_config('config')['search']['users'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
       
        if ($option['task'] == 'list-items') {
            $this->db->select('id, ids, role, first_name, last_name, email, balance, history_ip, status, created');
            $this->db->from($this->tb_main);

            // filter
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }

            $this->db->order_by('id', 'DESC');
            if ($params['pagination']['limit'] != "" && $params['pagination']['start'] >= 0) {
                $this->db->limit($params['pagination']['limit'], $params['pagination']['start']);
            }

            $query = $this->db->get();
            $result = $query->result_array();
        }
        
        if ($option['task'] == 'export-list-items') {
            $result = $this->fetch('id, first_name, last_name, email, timezone, balance, status, created', $this->tb_main);
        }

        if ($option['task'] == 'user-price-list-items') {
            $this->db->select('up.id, up.uid, up.service_id, up.service_price');
            $this->db->select('s.name, s.original_price, s.price');
            $this->db->from($this->tb_services." s");
            $this->db->join($this->tb_users_price." up", "s.id = up.service_id", 'left');
            $this->db->where('up.uid', $params['uid']);
            $this->db->order_by('up.id', 'ASC');
            $query = $this->db->get();
            $result = $query->result_array();
        }

        if ($option['task'] == 'items-last-users') {
            $this->db->select('id, ids, role, first_name, last_name, email, balance, history_ip, status, created');
            $this->db->from($this->tb_main);
            $this->db->order_by('id', 'desc');
            $this->db->limit($params['limit'], 0);
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        
        if($option['task'] == 'get-item'){
            $result = $this->get("id, ids, role, first_name, last_name, timezone, email, balance, history_ip, more_information, status, created, settings", $this->tb_main, ['ids' => $params['ids']], '', '', true);
        }

        if($option['task'] == 'get-item-user-custom-rate'){
            $result = $this->get("id, ids, role, first_name, last_name, timezone, email, balance, history_ip, status, created, settings", $this->tb_main, ['ids' => $params['ids'], 'status' => 1], '', '', true);
        }

        if ($option['task'] == 'get-item-current-admin') {
            $result = $this->get("id, ids, first_name, last_name, email, timezone, role, password", $this->tb_main, ['id' => session('uid'), 'role' => 'admin'], '', '', true);
        }
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'count-items-group-by-status') {
            $this->db->select('count(id) as count, status');
            $this->db->from($this->tb_main);
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }

            $this->db->order_by('status', 'DESC');
            $this->db->group_by('status');
            $query = $this->db->get();
            $result = $query->result_array();
        }

        // Count items for pagination
        if ($option['task'] == 'count-items-for-pagination') {
            $this->db->select('id');
            $this->db->from($this->tb_main);
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
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
            $item = $this->get("id, ids", $this->tb_main, ['ids' => $params['id']]);
            if ($item) {
                $this->db->delete($this->tb_main, ["ids" => $params['id']]);
                $this->db->delete($this->tb_tickets, ["uid" => $item->id]);
                $this->db->delete($this->tb_ticket_message, ["uid" => $item->id]);
                $this->db->delete($this->tb_order, ["uid" => $item->id]);
                $this->db->delete($this->tb_users_price, ["uid" => $item->id]);
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
        if (in_array($option['task'], ['add-item', 'edit-item'])) {
            $data = array(
                "first_name"   => post("first_name"),
                "last_name"    => post("last_name"),
                "email"        => post("email"),
                "status"       => (int)post("status"),
                "timezone"     => post("timezone"),
                "changed"      => NOW,
                "settings"     => json_encode(post('settings')),
                "reset_key"    => ids(),
            );
        }
        switch ($option['task']) {
            
            case 'add-item':
                $data['ids']         = ids();
                $data['password']    = $this->app_password_hash(post('password'));
                $data['login_type']  = 'create_by_'. session('uid');
                $data['created']     = NOW;
                $data['api_key']     = create_random_string_key(32);
                $this->db->insert($this->tb_main, $data);
                return ["status"  => "success", "message" => 'Added successfully'];
                break;

            case 'edit-item':
                $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
                return ["status"  => "success", "message" => 'Updated successfully'];
                break;

            case 'edit-item-information':
                $more_information = [
                    'skype_id' => post('skype_id'),
                    'phone' => post('phone'),
                    'what_asap' => post('what_asap'),
                    'website' => post('website'),
                ];
                $data['more_information'] = json_encode($more_information);
                $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
                return ["status"  => "success", "message" => 'Updated successfully'];
                break;

            case 'change-status':
                $this->db->update($this->tb_main, ['status' => $params['status'], 'changed' => NOW], ["ids" => $params['id']]);
                return ["status"  => "success", "message" => 'Updated successfully'];
                break;

            case 'set-password':
                $data = [
                    'password' => $this->app_password_hash(post('password')),
                    'changed'  => NOW,
                ];
                $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
                return ["status"  => "success", "message" => 'Password changed successfully!'];
                break;

            case 'bulk-action':
                if (in_array($params['type'], ['delete', 'deactive', 'active']) && empty($params['ids'])) {
                    return ["status"  => "error", "message" => 'Please choose at least one item'];
                }
                $arr_ids = convert_str_number_list_to_array($params['ids']);
                switch ($params['type']) {
                    case 'delete':
                        $this->db->where_in('ids', $arr_ids);
                        $this->db->delete($this->tb_main);

                        return ["status"  => "success", "message" => 'Delete successfully'];
                        break;
                    case 'deactive':
                        // Category
                        $this->db->where_in('ids', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 0]);

                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                    case 'active':
                        $this->db->where_in('ids', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 1]);

                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                }
                break;
        }
    }

    public function save_funds($params = null, $option = null)
    {
        if ($option['task'] == 'add-funds') {
            // Update balance to user
            $data_item = [
                'balance' => $params['item']['balance'] + (double)post('amount'),
            ];
            $this->db->update($this->tb_main, $data_item, ['ids' => post('ids')]);
            if ($this->db->affected_rows()) {
                //insert to transaction id
                $data_item_tnx = [
                    "ids"            => ids(),
                    "uid"            => $params['item']['id'],
                    "type"           => post('payment_method'),
                    "transaction_id" => post('transaction_id'),
                    "txn_fee"        => post('tnx_fee'),
                    "note"           => post('tnx_note'),
                    "amount"         => (double)post('amount'),
                    "created"        => NOW,
                ];
                $this->db->insert($this->tb_transaction_logs, $data_item_tnx);
                return ["status"  => "success", "message" => 'Update successfully'];
            };
            
        }
        if ($option['task'] == 'edit-funds') {
            $data_item = [
                'balance' => (double)post('new_balance'),
            ];
            $this->db->update($this->tb_main, $data_item, ['ids' => post('ids')]);
            if ($this->db->affected_rows()) {
                return ["status"  => "success", "message" => 'Update successfully'];
            };
        }
    }

    public function save_custom_rates($params = null, $option = null)
    {
        if ($option['task'] == 'set-custom-rate') {
            $item_user = $this->get('id, ids, email', $this->tb_users, ['status' => 1, 'ids' => $params['user_ids']], '', '', true);
            if (empty($item_user)) {
                return ["status"  => "error", "message" => "There was an error processing your request. Please try again later"];
            }

            if (!empty($params['custom_rates'])) {
                // $exist_db_custom_rates = [];
                $current_services = $this->fetch('*', $this->tb_users_price, ['uid' => $item_user['id']], '', '', '', '', true);
                if ($current_services) {
                    $current_services = array_sort_by_new_key($current_services, 'service_id');
                    /*----------  Compare services  ----------*/
                    $disabled_services    = array_diff_key($current_services, $params['custom_rates']);
                    $new_services         = array_diff_key($params['custom_rates'], $current_services);
                    $exists_services      = array_diff_key($params['custom_rates'], $new_services);
                    // Update
                    if ($exists_services) {
                        foreach ($exists_services as $key => $item) {
                            $this->db->update($this->tb_users_price, ['service_price' => $item['service_price']], ['service_id' => $item['service_id'], 'uid' => $item['uid']]);
                        }	
                    }
                    // Delete disabled service
                    if ($disabled_services) {
                        $this->db->where_in('id', array_column($disabled_services, 'id'));
                        $this->db->delete($this->tb_users_price);
                    }

                    // add 
                    if ($new_services) {
                        $this->db->insert_batch($this->tb_users_price, $new_services);
                    }
                } else {
                    $this->db->insert_batch($this->tb_users_price, $params['custom_rates']);
                }
            }else{
                $this->db->delete($this->tb_users_price, ['uid' => $item_user['id']]);
            }
            return ["status"  => "success", "message" => 'Update successfully'];
        }
    }

    public function verify_admin_access($params = null, $option = null)
    {
        if ($option['task'] == 'check-admin-secret-key') {
            $item_admin = $this->get_item(null, ['task' => 'get-item-current-admin']);
            $check_secret_key   = $this->app_password_verify($params['secret_key'], $item_admin['password']);
            if ($item_admin['role'] == 'admin' && $check_secret_key) {
                return true;
            } else {
                return false;
            }
        }
    }
}
