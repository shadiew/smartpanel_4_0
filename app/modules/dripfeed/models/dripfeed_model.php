<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dripfeed_model extends MY_Model {
    protected $tb_main;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
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
            $this->db->select('o.id, o.ids, o.runs, o.service_id, o.api_provider_id, o.api_service_id, o.api_order_id, o.status, o.charge, o.formal_charge, o.profit, o.link, o.quantity, o.dripfeed_quantity, o.sub_response_orders, o.interval, o.created, o.changed, o.note');
            $this->db->select('s.name as service_name');
            $this->db->from($this->tb_main . ' o');
            $this->db->join($this->tb_services." s", "s.id = o.service_id", 'left');

            // filter
            // filter
            if ($params['filter']['status'] != 'all' && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('o.status', $params['filter']['status']);
            }
            $this->db->where("o.uid", session("uid"));
            $this->db->where("o.is_drip_feed =", 1);
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
            $this->db->select('o.id');
            $this->db->from($this->tb_main . ' o');
            // filter
            if ($params['filter']['status'] != 'all' && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('o.status', $params['filter']['status']);
            }

            $this->db->where("o.is_drip_feed", 1);
            $this->db->where("o.uid", session("uid"));
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
}