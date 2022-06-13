<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class payments_model extends MY_Model 
{

    protected $tb_users;
    protected $tb_main;
    protected $tb_payments_bonuses;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->controller_name = 'payments';
        $this->tb_main     = PAYMENTS_METHOD;
        $this->tb_payments_bonuses = PAYMENTS_BONUSES;

        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = (in_array($this->controller_name, app_config('config')['search'])) ? app_config('config')['search'][$this->controller_name] : app_config('config')['search']['default'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
       
        if ($option['task'] == 'list-items') {
            $this->db->select('id, type, name, sort, min, max, new_users, status');
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
            $this->db->order_by('sort', 'ASC');
            $this->db->order_by('id', 'ASC');
            if ($params['pagination']['limit'] != "" && $params['pagination']['start'] >= 0) {
                $this->db->limit($params['pagination']['limit'], $params['pagination']['start']);
            }

            $query = $this->db->get();
            $result = $query->result_array();
        }

        // List active in Users and PM bonuses
        if ($option['task'] == 'admin-active-list-items') {
            $result = $this->fetch("id, type, sort, name", $this->tb_main, ['status' => 1], '', '', true);
        }

        // List items for user add funds
        if ($option['task'] == 'user-list-items-add-funds') {
            $result = $this->fetch("id, type, sort, name", $this->tb_main, '', '', '', true);
        }

        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;

        if($option['task'] == 'get-item'){
            $result = $this->get("id, type, name, sort, min, max, new_users, params, status", $this->tb_main, ['id' => $params['id']], '', '', true);
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

    public function save_item($params = null, $option = null)
    {
        switch ($option['task']) {

            case 'edit-item':
                $data = [
                    "name"      => $params['name'],
                    "min"       => $params['min'],
                    "max"       => $params['max'],
                    "status"    => (int)$params['status'],
                    "new_users" => (int)$params['new_users'],
                    "params"    => json_encode($params),
                ];
                $this->db->update($this->tb_main, $data, ["id" => post('id')]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'change-status':
                $this->db->update($this->tb_main, ['status' => $params['status']], ["id" => $params['id']]);
                $this->db->update($this->tb_payments_bonuses, ['status' => 0], ["payment_id" => $params['id']]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;
            
            case 'change-sort':
                $this->form_validation->set_rules('sort', 'sort', "trim|required|is_natural_no_zero|is_unique[$this->tb_main.sort]");
                if (!$this->form_validation->run()) _validation('error', strip_tags(validation_errors()));

                $this->db->update($this->tb_main, ['sort' => $params['sort']], ["id" => $params['id']]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'bulk-action':
                if (in_array($params['type'], ['delete', 'deactive', 'active']) && empty($params['ids'])) {
                    return ["status"  => "error", "message" => 'Please choose at least one item'];
                }
                $arr_ids = convert_str_number_list_to_array($params['ids']);
                switch ($params['type']) {
                    case 'deactive':
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 0]);
                        
                        $this->db->where_in('payment_id', $arr_ids);
                        $this->db->update($this->tb_payments_bonuses,  ['status' => 0]);

                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                    case 'active':
                        //  Payment bonues
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 1]);
                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                }
                break;
        }
    }
}
