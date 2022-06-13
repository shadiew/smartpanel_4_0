<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api_model extends MY_Model {
	public $tb_users;
	public $tb_users_price;
	public $tb_categories;
	public $tb_services;
	public $tb_orders;

	public function __construct(){
		$this->tb_categories 	= CATEGORIES;
		$this->tb_services   	= SERVICES;
		$this->tb_orders     	= ORDER;
		$this->tb_users_price   = USERS_PRICE;
		parent::__construct();
	}

	function get_services_list($uid = ""){
		$data  = array();
		$this->db->select("s.id as service, s.name, c.name as category, s.price as rate, s.min, s.max, s.type, s.desc, s.dripfeed");
		$this->db->from($this->tb_services ." s");
		$this->db->join($this->tb_categories." c", "s.cate_id = c.id", 'left');
		$this->db->where("s.status", "1");
		$this->db->where("c.status", "1");
		$this->db->order_by("c.sort", "ASC");
		$this->db->order_by("s.price", "ASC");
		$query = $this->db->get();
		if($query->result()){
			$data = $query->result();
			$custom_rates = $this->get_custom_rates($uid);
			if ($custom_rates && $uid) {
				foreach ($data as $key => $row) {
					if (isset($custom_rates[$row->service])) {
						$data[$key]->rate = $custom_rates[$row->service]['service_price'];
					}
				}
			}
			return $data;
		}else{
			false;
		}
	}

	// Get all user price
	private function get_custom_rates($uid = ""){
		$custom_rates = $this->model->fetch('uid, service_id, service_price', $this->tb_users_price, ['uid' =>$uid ] );
		$exist_db_custom_rates = [];
		if (!empty($custom_rates)) {
			foreach ($custom_rates as $key => $row) {
				$exist_db_custom_rates[$row->service_id]['uid']           = $row->uid;
				$exist_db_custom_rates[$row->service_id]['service_price'] = $row->service_price;
			}
		}
		return $exist_db_custom_rates;
	}

	function get_order_id($id, $uid){
		$this->db->select("id as order, status, charge, start_counter as start_count, remains");
		$this->db->from($this->tb_orders);
		$this->db->where("id", $id);
		$this->db->where("uid", $uid);
		$query = $this->db->get();

		$result = $query->row();
		if(!empty($result)){
			switch ($result->status) {

				case 'completed':
					$result->status = 'Completed';
					break;
					
				case 'completed':
					$result->status = 'Completed';
					break;

				case 'processing':
					$result->status = 'Processing';
					break;

				case 'pending':
					$result->status = 'Pending';
					break;

				case 'inprogress':
					$result->status = 'In progress';
					break;

				case 'partial':
					$result->status = 'Partial';
					break;

				case 'cancelled':
					$result->status = 'Cancelled';
					break;

				case 'refunded':
					$result->status = 'Refunded';
					break;

			}
			return $result;
		}
		return false;
	}

}
