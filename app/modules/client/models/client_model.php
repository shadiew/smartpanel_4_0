<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class client_model extends MY_Model {

    public function __construct(){
        parent::__construct();
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items-category-in-services') {
            $result = $this->fetch("id, ids, name, sort, status", $this->tb_categories, ['status' => 1], 'sort', 'ASC', '', '', true);
        }
        
        if ($option['task'] == 'list-items-news') {
            $this->db->select('*');
            $this->db->from($this->tb_news);
            $this->db->where("(expiry  > '".NOW."')");
            $this->db->where("(created < '".NOW."')");
            $this->db->where('status', 1);
            $this->db->order_by('created', 'DESC');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        
        if ($option['task'] == 'list-items-faq') {
            $result = $this->fetch("*", $this->tb_faqs, ['status' => 1], 'sort', 'ASC', '', '', true);
        }

        return $result;
    }
    
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'get-item-language'){
            $result = $this->get("*", $this->tb_language_list, ['ids' => $params['ids']], '', '', false);
        }
        return $result;
    }

}

