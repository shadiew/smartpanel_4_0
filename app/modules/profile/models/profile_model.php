<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile_model extends MY_Model {
	public $tb_users;

	public function __construct(){
		parent::__construct();
		$this->tb_users = USERS;
	}

}
