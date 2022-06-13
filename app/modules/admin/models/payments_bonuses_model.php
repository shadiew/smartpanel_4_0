<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class payments_bonuses_model extends MY_Model 
{

    protected $tb_users;
    protected $tb_main;
    protected $tb_payments;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->controller_name = 'Payments_bonuses';
        $this->tb_main     = PAYMENTS_BONUSES;
        $this->tb_payments = PAYMENTS_METHOD;

        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = (in_array($this->controller_name, app_config('config')['search'])) ? app_config('config')['search'][$this->controller_name] : app_config('config')['search']['default'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items') {
            $this->db->select('pb.id, pb.payment_id, pb.bonus_from, pb.percentage, pb.status');
            $this->db->select('pm.name');
            $this->db->from($this->tb_main . ' pb');
            $this->db->join($this->tb_payments." pm", "pb.payment_id = pm.id", 'left');

            // filter
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('pb.status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'name') ? 'pm.'.$column : 'pb.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'name') ? 'pm.'.$params['search']['field'] : 'pb.'.$params['search']['field'];
                $this->db->like($column, $params['search']['query']); 
            }

            $this->db->order_by('id', 'ASC');
            if ($params['pagination']['limit'] != "" && $params['pagination']['start'] >= 0) {
                $this->db->limit($params['pagination']['limit'], $params['pagination']['start']);
            }

            $query = $this->db->get();
            $result = $query->result_array();
        }
        
        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'get-item'){
            $result = $this->get("id,  payment_id, bonus_from, percentage, status", $this->tb_main, ['id' => $params['id']], '', '', true);
        }
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'count-items-group-by-status') {
            $this->db->select('count(pb.id) as count, pb.status');
            $this->db->from($this->tb_main . ' pb');
            $this->db->join($this->tb_payments." pm", "pb.payment_id = pm.id", 'left');
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'name') ? 'pm.'.$column : 'pb.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'name') ? 'pm.'.$params['search']['field'] : 'pb.'.$params['search']['field'];
                $this->db->like($column, $params['search']['query']); 
            }

            $this->db->order_by('pb.status', 'DESC');
            $this->db->group_by('pb.status');
            $query = $this->db->get();
            $result = $query->result_array();
        }

        // Count items for pagination
        if ($option['task'] == 'count-items-for-pagination') {
            $this->db->select('pb.id');
            $this->db->from($this->tb_main . ' pb');
            $this->db->join($this->tb_payments." pm", "pb.payment_id = pm.id", 'left');
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('pb.status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'name') ? 'pm.'.$column : 'pb.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'name') ? 'pm.'.$params['search']['field'] : 'pb.'.$params['search']['field'];
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
            $item = $this->get("id, ids", $this->tb_main, ['id' => $params['id']]);
            if ($item) {
                $this->db->delete($this->tb_main, ["id" => $params['id']]);
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

            case 'add-item':
                $data = [
                    "ids"             => ids(),
                    "payment_id"      => post("payment_id"),
                    "percentage"      => post("percentage"),
                    "bonus_from"      => post("bonus_from"),
                    "status"          => (int)post("status"),
                ];
                $this->db->insert($this->tb_main, $data);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'edit-item':
                $data = [
                    "percentage"      => post("percentage"),
                    "bonus_from"      => post("bonus_from"),
                    "status"          => (int)post("status"),
                ];
                $this->db->update($this->tb_main, $data, ["id" => post('id')]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'change-status':
                $this->db->update($this->tb_main, ['status' => $params['status']], ["id" => $params['id']]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'bulk-action':
                if (in_array($params['type'], ['delete', 'deactive', 'active']) && empty($params['ids'])) {
                    return ["status"  => "error", "message" => 'Please choose at least one item'];
                }
                $arr_ids = convert_str_number_list_to_array($params['ids']);
                switch ($params['type']) {
                    case 'deactive':
                        // Category
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 0]);
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
