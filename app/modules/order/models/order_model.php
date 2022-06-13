<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class order_model extends MY_Model {
    

    public function __construct(){
        parent::__construct();
        $this->tb_main     = ORDER;
        $this->filter_accepted = array_keys(app_config('config')['status']['dripfeed']);
        unset($this->filter_accepted['all']);
        $this->field_search_accepted = ['id', 'link'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items') {
            $item_main_id = 0;
            if (get('subscription')) {
                $item_main_id = (int)get('subscription');
            } elseif (get('drip-feed')) {
                $item_main_id = (int)get('drip-feed');
            }

            $this->db->select('o.id, o.ids, o.runs, o.service_id, o.status, o.charge, o.link, o.quantity, o.start_counter, o.changed, o.remains, o.created');
            $this->db->select('s.name as service_name');
            $this->db->from($this->tb_main . ' o');
            $this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');
            // filter
            if ($params['filter']['status'] != 'all' && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('o.status', $params['filter']['status']);
            }
            $this->db->where("o.service_type !=", "subscriptions");
            $this->db->where("o.is_drip_feed !=", 1);
            $this->db->where("o.uid", session("uid"));
            // Get all orders relate to main order id
            if ($item_main_id > 0) {
                $this->db->where("o.main_order_id", $item_main_id);
            }

            //Search
            if ($params['search']['query'] != '') {
                $field_value = $this->db->escape_like_str($params['search']['query']);
                $where_like = "(`o`.`id` LIKE '%" . $field_value ."%' ESCAPE '!' OR `o`.`link` LIKE '%". $field_value ."%' ESCAPE '!')";
                $this->db->where($where_like);
            }

            $this->db->order_by('id', 'desc');
            if ($params['pagination']['limit'] != "" && $params['pagination']['start'] >= 0) {
                $this->db->limit($params['pagination']['limit'], $params['pagination']['start']);
            }
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
            $item_main_id = 0;
            if (get('subscription')) {
                $item_main_id = (int)get('subscription');
            } elseif (get('drip-feed')) {
                $item_main_id = (int)get('drip-feed');
            }

            $this->db->select('o.id');
            $this->db->from($this->tb_main . ' o');
            // filter
            if ($params['filter']['status'] != 'all' && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('o.status', $params['filter']['status']);
            }
            $this->db->where("o.service_type !=", "subscriptions");
            $this->db->where("o.is_drip_feed !=", 1);
            $this->db->where("o.uid", session("uid"));
            // Get all orders relate to main order id
            if ($item_main_id > 0) {
                $this->db->where("o.main_order_id", $item_main_id);
            }
             //Search
            if ($params['search']['query'] != '') {
                $field_value = $this->db->escape_like_str($params['search']['query']);
                $where_like = "(`o`.`id` LIKE '%" . $field_value ."%' ESCAPE '!' OR `o`.`link` LIKE '%". $field_value ."%' ESCAPE '!')";
                $this->db->where($where_like);
            }

            $query = $this->db->get();
            $result = $query->num_rows();
        }
        return $result;
    }

    function get_log_details($id){
        $this->db->select('o.*, u.email as user_email, s.name as service_name, api.name as api_name');
        $this->db->from($this->tb_order." o");
        $this->db->join($this->tb_users." u", "u.id = o.uid", 'left');
        $this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');
        $this->db->join($this->tb_api_providers." api", "api.id = o.api_provider_id", 'left');
        $this->db->where("o.main_order_id", $id);
        $this->db->order_by("o.id", 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function list_items_best_seller($params = [], $option = []){
        $result = [];
        $limit = (isset($params['limtt'])) ? $params['limtt'] : 10;

        $query = "SELECT count(service_id) as total_orders, service_id FROM {$this->tb_order} GROUP BY service_id ORDER BY total_orders DESC LIMIT 30";
        $items_top_sellers =  $this->db->query($query)->result_array();

        if (!$items_top_sellers) {
            return $result;
        }
        $items_arr_service_id = array_column($items_top_sellers, 'service_id');
        if ($option['task'] == 'admin') {
            $this->db->select('s.*, api.name as api_name');
            $this->db->from($this->tb_services." s");
            $this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
            $this->db->where("s.id", $item['service_id']);
            $this->db->where("s.status", 1);
            $this->db->order_by("s.price", 'ASC');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        if ($option['task'] == 'user') {
            $this->db->select('id, ids, name, min, max, price, desc');
            $this->db->from($this->tb_services);
            $this->db->where_in("id", $items_arr_service_id);
            $this->db->where("status", 1);
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }
}
