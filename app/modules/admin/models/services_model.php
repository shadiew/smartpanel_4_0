<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class services_model extends MY_Model 
{

    protected $tb_users;
    protected $tb_main;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = SERVICES;

        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = app_config('config')['search']['services'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
       
        if ($option['task'] == 'list-items') {
            $this->db->select('s.id, s.ids, s.name, s.cate_id, s.price, s.original_price, s.min, s.max, s.type, s.add_type, s.api_service_id, s.api_provider_id, s.status, s.desc');
            $this->db->select('api.name as api_name, c.name as category_name');
            $this->db->from($this->tb_main." s");
            $this->db->join($this->tb_categories." c", "c.id = s.cate_id", 'left');
            $this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'name') ? 's.'.$column : 's.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'name') ? 's.'.$params['search']['field'] : 's.'.$params['search']['field'];
                $this->db->like($column, $params['search']['query']); 
            }

            // Sort By
            if ($params['sort_by']['cate_id'] != "") {
                $this->db->where('s.cate_id', $params['sort_by']['cate_id']);
            }

            $this->db->order_by("c.sort", 'ASC');
            $this->db->order_by("s.price", 'ASC');
            $this->db->order_by("s.name", 'ASC');
            $query = $this->db->get();
            $result = $query->result_array();
            if ($result) {
                $result = group_by_criteria($result, 'category_name');
            }
        }

        if ($option['task'] == 'user-custom-rate-list-items') {
            $result = $this->fetch('id, price, name, original_price', $this->tb_services, ['status' => 1], '', '', 'id', 'ASC', true);
        }

        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'get-item'){
            $result = $this->get("id, ids, name, desc, cate_id, price, dripfeed, original_price, min, max, type, add_type, api_service_id, api_provider_id, status", $this->tb_main, ['id' => $params['id']], '', '', true);
        }
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;
        return $result;
    }

    public function delete_item($params = null, $option = null)
    {
        $result = [];
        
        if($option['task'] == 'delete-item'){
            $item = $this->get("id, ids", $this->tb_main, ['id' => $params['id']]);
            if ($item) {
                $this->db->delete($this->tb_main, ["id" => $params['id']]);
                $this->db->delete($this->tb_services, ["cate_id" => $params['id']]);
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

        if($option['task'] == 'delete-custom-rate-item'){
            $item = $this->get("id, ids", $this->tb_main, ['id' => $params['id']]);
            if ($item) {
                $this->db->delete($this->tb_users_price, ["service_id" => $params['id']]);
                $result = [
                    'status' => 'success',
                    'message' => 'Deleted custom rates successfully',
                    "ids"     => '',
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
            $data = [
                "name"             => post('name'),
                "add_type"         => post('add_type'),
                "cate_id"          => post('category'),
                "desc"             => post('desc'),
                "min"              => post('min'),
                "max"              => post('max'),
                "price"            => (double)post('price'),
                "status"           => (int)post('status'),
            ];
            if (post('add_type') == 'api') {
                $data['api_provider_id'] = post("api_provider_id");
                $data['api_service_id']  = post("api_service_id");
                $data['original_price']  = post("original_price");
                $data['type']            = post("api_service_type");
                $data['dripfeed']        = (int)post("api_service_dripfeed");
            } else {
                $data['api_provider_id'] = "";
                $data['api_service_id']  = "";
                $data['type']            = post("service_type");
                $data['dripfeed']        = (int)post("dripfeed");
            }
        }
        switch ($option['task']) {
            case 'add-item':
                $data["ids"]     = ids();
                $data["changed"] = NOW;
                $data["created"] = NOW;
                $this->db->insert($this->tb_main, $data);
                return ["status"  => "success", "message" => 'Add successfully'];
                break;
                
            case 'edit-item':
                $data["changed"] = NOW;
                $this->db->update($this->tb_main, $data, ["id" => post('id')]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'change-status':
                $this->db->update($this->tb_main, ['status' => $params['status'], 'changed' => NOW], ["id" => $params['id']]);
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
                        return ["status"  => "success", "message" => 'Delete successfully'];
                        break;
                    case 'delete_custom_rates':
                        $this->db->where_in('service_id', $arr_ids);
                        $this->db->delete($this->tb_users_price);
                        return ["status"  => "success", "message" => 'Delete custom rates successfully'];
                        break;
                    case 'deactive':
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 0]);
                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                    case 'active':
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 1]);
                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                }
                break;
        }
    }
}
