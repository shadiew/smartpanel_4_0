<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class monoka extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->template->set_layout('blank_page');
	}

	public function index(){
		if (get_option("enable_disable_homepage", 0)) {
			redirect(cn("auth/login"));
		}
		$data = array();
		$this->template->build('index', $data);
	}

	public function header($display_html = true){
		$data = array(
			'display_html' => $display_html,
		);

		$this->load->view('blocks/header', $data);
	}

	public function footer($display_html = true){
		$data = array(
			'display_html' => $display_html,
			'lang_current' => get_lang_code_defaut(),
			'languages'    => $this->model->fetch("*", LANGUAGE_LIST, "status = 1")
		);
		$this->load->view('blocks/footer', $data);
	}
}