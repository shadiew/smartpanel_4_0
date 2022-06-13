<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class settings_model extends MY_Model {
	public $tb_users;
	public $tb_order;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;

	public function __construct(){
		parent::__construct();
	}
}
