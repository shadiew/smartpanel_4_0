<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dripfeed_model extends MY_Model 
{

    protected $tb_main;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = ORDER;

        $this->filter_accepted = array_keys(app_config('config')['status']['dripfeed']);
        unset($this->filter_accepted['all']);
        $this->field_search_accepted = app_config('config')['search']['dripfeed'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items') {
            $this->db->select('o.id, o.ids, o.runs, o.type, o.service_id, o.api_provider_id, o.api_service_id, o.api_order_id, o.status, o.charge, o.formal_charge, o.profit, o.link, o.quantity, o.dripfeed_quantity, o.sub_response_orders, o.interval, o.created, o.changed, o.note');
            $this->db->select('u.email');
            $this->db->select('s.name as service_name');
            $this->db->select('api.name as api_name');
            $this->db->from($this->tb_main . ' o');
            $this->db->join($this->tb_users." u", "o.uid = u.id", 'left');
            $this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');
            $this->db->join($this->tb_api_providers." api", "api.id = o.api_provider_id", 'left');

            // filter
            if ($params['filter']['status'] != 'all' && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('o.status', $params['filter']['status']);
            }

            $this->db->where("o.is_drip_feed =", 1);

            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'email') ? 'u.'.$column : 'o.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'email') ? 'u.'.$params['search']['field'] : 'o.'.$params['search']['field'];
                $this->db->like($column, $params['search']['query']); 
            }

            $this->db->order_by('id', 'desc');
            if ($params['pagination']['limit'] != "" && $params['pagination']['start'] >= 0) {
                $this->db->limit($params['pagination']['limit'], $params['pagination']['start']);
            }
            $query = $this->db->get();
            $result = $query->result_array();
        }
        if ($option['task'] == 'list-items-in-bulk-action') {
            $this->db->select('id, ids, cate_id, service_id, service_type, api_provider_id, api_service_id, charge, uid, quantity, status, formal_charge, profit');
            $this->db->from($this->tb_main);
            $this->db->where_in('id', $params['ids_arr']);
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'get-item'){
            $result = $this->get("id, ids, runs, type, service_id, service_type, api_provider_id, api_service_id, charge, uid, quantity, status, formal_charge, profit, interval, link", $this->tb_main, ['id' => $params['id']], '', '', true);
        }
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;

        if ($option['task'] == 'count-items-by-status') {
            $this->db->select("id");
            $this->db->from($this->tb_main);
            $this->db->where("status", $params['status']);
            $this->db->where("is_drip_feed", 1);
            $query = $this->db->get();
            return $query->num_rows();
        }

        // Count items for pagination
        if ($option['task'] == 'count-items-for-pagination') {
            $this->db->select('o.id');
            $this->db->from($this->tb_main . ' o');
            $this->db->join($this->tb_users." u", "o.uid = u.id", 'left');
            $this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');
            $this->db->join($this->tb_api_providers." api", "api.id = o.api_provider_id", 'left');

            // filter
            if ($params['filter']['status'] != 'all' && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('o.status', $params['filter']['status']);
            }

            $this->db->where("o.is_drip_feed", 1);

            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'email') ? 'u.'.$column : 'o.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'email') ? 'u.'.$params['search']['field'] : 'o.'.$params['search']['field'];
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
            case 'edit-item':
                $item = $this->get('id, ids, cate_id, service_id, service_type, api_provider_id, api_service_id, charge, uid, quantity, status, formal_charge, profit', $this->tb_main, ['id' => post('id')], '', '', true);
                if (!$item) {
                    return ["status"  => "error", "message" => 'The item does not exists'];
                }
                $data = array(
                    "link" 	    	=> post('link'),
                    "status"    	=> post('status'),
                    "changed" 		=> NOW,
                );
                if (in_array(post('status'), ['canceled'])) {
                    
                    if (!in_array($item['status'], array('cancelled'))) {
                        $response = $this->crud_user(['uid' => $item['uid'], 'fields' => 'balance', 'new_amount' => $item['charge']], ['task' => 'update-balance']);
                        if (!$response) {
                            return ['status' => 'error', 'message' => 'There was some issue with your request'];
                        }
                    }
                }
                $this->db->update($this->tb_main, $data, ["id" => $item['id']]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'bulk-action':
                if (in_array($params['type'], ['delete', 'deactive', 'active']) && empty($params['ids'])) {
                    return ["status"  => "error", "message" => 'Please choose at least one item'];
                }
                $arr_ids = convert_str_number_list_to_array($params['ids']);
                switch ($params['type']) {
                    case 'delete':
                        $this->db->where_in('id', $arr_ids);
                        $this->db->delete($this->tb_main);
                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;

                    case 'completed':
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 'completed', 'changed' => NOW]);
                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;


                    case 'cancel':
                        $items = $this->list_items(['ids_arr' => $arr_ids], ['task' => 'list-items-in-bulk-action']);
                        if ($items) {
                            foreach ($items as $key => $item) {
                                $response = $this->crud_user(['uid' => $item['uid'], 'fields' => 'balance', 'new_amount' => $item['charge']], ['task' => 'update-balance']);
                                if (!$response) {
                                    return ['status' => 'error', 'message' => 'There was some issue with your request'];
                                }
                                $data = [
                                    'status'       => 'canceled',
                                    'changed'       => NOW,
                                ];
                                $this->db->update($this->tb_main, $data, ['id' => $item['id']]);
                            }
                        }
                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                }
                break;
        }
    }
}
