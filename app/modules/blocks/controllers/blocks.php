<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class blocks extends MX_Controller {
	

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		//Config Module
		$this->tb_tickets    		= TICKETS;
		$this->tb_users    		    = USERS;
		$this->tb_ticket_message    = TICKET_MESSAGES;

	}


}