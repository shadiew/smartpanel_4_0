<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transactions_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = TRANSACTION_LOGS;
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items') {
            $this->db->select('id, uid, amount, status, type, txn_fee, created');
            $this->db->from($this->tb_main);
            $this->db->where('status', 1);
            $this->db->where('uid', session('uid'));
            $this->db->order_by('id', 'DESC');
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
            $this->db->select('id');
            $this->db->from($this->tb_main);
            $this->db->where('status', 1);
            $this->db->where('uid', session('uid'));
            $query = $this->db->get();
            $result = $query->num_rows();
        }
        return $result;
    }
    
    function delete_unpaid_payment($day = ""){
        if ($day == "") {
            $day = 7;
        }
        $SQL   = "DELETE FROM ".$this->tb_transaction_logs." WHERE `status` != 1 AND created < NOW() - INTERVAL ".$day." DAY";
        $query = $this->db->query($SQL);
        return $query;
    }

}
