<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transactions_model extends MY_Model 
{

    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = TRANSACTION_LOGS;

        $this->filter_accepted = array_keys(app_config('template')['transactions_status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = app_config('config')['search']['transactions'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items') {
            $this->db->select('tl.*');
            $this->db->select('u.email');
            $this->db->from($this->tb_main . ' tl');
            $this->db->join($this->tb_users." u", "tl.uid = u.id", 'left');

            // filter
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('tl.status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'email') ? 'u.'.$column : 'tl.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'email') ? 'u.'.$params['search']['field'] : 'tl.'.$params['search']['field'];
                $this->db->like($column, $params['search']['query']); 
            }

            $this->db->order_by('id', 'DESC');
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
            $result = $this->get("id, ids, uid, payer_email, type, transaction_id, txn_fee, note, data, amount, status, created", $this->tb_main, ['id' => $params['id']], '', '', true);
        }
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'count-items-group-by-status') {
            $this->db->select('count(tl.id) as count, tl.status');
            $this->db->from($this->tb_main . ' tl');
            $this->db->join($this->tb_users." u", "tl.uid = u.id", 'left');
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'email') ? 'u.'.$column : 'tl.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'email') ? 'u.'.$params['search']['field'] : 'tl.'.$params['search']['field'];
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }

            $this->db->order_by('tl.status', 'DESC');
            $this->db->group_by('tl.status');
            $query = $this->db->get();
            $result = $query->result_array();
        }

        // Count items for pagination
        if ($option['task'] == 'count-items-for-pagination') {
            $this->db->select('tl.id');
            $this->db->from($this->tb_main . ' tl');
            $this->db->join($this->tb_users." u", "tl.uid = u.id", 'left');

            // filter
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('tl.status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        $column = ($column == 'email') ? 'u.'.$column : 'tl.'.$column;
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $column = ($params['search']['field'] == 'email') ? 'u.'.$params['search']['field'] : 'tl.'.$params['search']['field'];
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
            
            case 'edit-item':
                
                $item = $this->get("id, ids, uid, amount, status, type, txn_fee", $this->tb_main, ['ids' => post('ids')], '', '', true);
                if (empty($item)) return ['status' => 'error', 'message' => 'Transaction does not exists'];

                $data_tnx = array(
                    'note'   => post("note"),
                    'status' => (int)post("status")
                );
                $this->db->update($this->tb_main, $data_tnx, ['ids' => post('ids')]);
                if (post("status") == 1 && $item['status'] == 0) {
                    $new_amount = $item['amount'] - $item['txn_fee'];
                    $response = $this->crud_user(['uid' => $item['uid'], 'fields' => 'balance', 'new_amount' => $new_amount], ['task' => 'update-balance']);
                    if (!$response) {
                        return ['status' => 'error', 'message' => 'There was some issue with your request'];
                    }
                } 
                return ['status' => 'success', 'message' => 'Update successfully'];;
                break;
            }
    }
}
