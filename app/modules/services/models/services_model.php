<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class services_model extends MY_Model {
    protected $tb_users;
    protected $tb_main;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = SERVICES;
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
       
        if ($option['task'] == 'list-items') {
            $this->db->select('s.id, s.desc, s.ids, s.name, s.min, s.max, s.price');
            $this->db->select('c.name as category_name');
            $this->db->from($this->tb_main." s");
            $this->db->join($this->tb_categories." c", "c.id = s.cate_id", 'left');
            if ($params['cate_id'] != 0) {
                $this->db->where("s.cate_id", $params['cate_id']);
            }
            $this->db->where("s.status", "1");
            $this->db->order_by("c.sort", 'ASC');
            $this->db->order_by("s.price", 'ASC');
            $this->db->order_by("s.name", 'ASC');
            $query = $this->db->get();
            $result = $query->result_array();
            if ($result) {
                $result = group_by_criteria($result, 'category_name');
            }
        }
       
        if ($option['task'] == 'list-items-user-price') {
            if (!session('uid')) {
                return $result;
            }
            $result = $this->fetch('uid, service_id, service_price', $this->tb_users_price, ['uid' => session('uid')], '', '', '', '', true);
            if (!empty($result)) {
                $result = array_column($result, 'service_price', 'service_id');
            }
        }
       
        if ($option['task'] == 'list-items-by-category-in-new-order') {
            $result = $this->fetch('*', $this->tb_main, ['status' => 1, 'cate_id' => $params['cate_id']], 'price', 'ASC', '', '', true);
        }
        return $result;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item-in-new-order') {
            $result = $this->get('*', $this->tb_main, ['id' => $params['id'], 'status' => 1] ,'', '', true);
        }
        return $result;
    }

    public function get_custom_rates(){
        $custom_rates = $this->model->fetch('uid, service_id, service_price',$this->tb_users_price, ['uid' => session('uid')]);
        $exist_db_custom_rates = [];
        if (!empty($custom_rates)) {
            foreach ($custom_rates as $key => $row) {
                $exist_db_custom_rates[$row->service_id]['uid']           = $row->uid;
                $exist_db_custom_rates[$row->service_id]['service_id']    = $row->service_id;
                $exist_db_custom_rates[$row->service_id]['service_price'] = $row->service_price;
            }
        }
        return $exist_db_custom_rates;
    }
}
