<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class home extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'model');
        if (session('uid')) {
            if (get_role('admin')) {
                redirect(admin_url('users'));
            }
            redirect(cn('new_order'));
        }
    }

    public function index()
    {
        $home_page_type =  get_theme();
        if (get_option("enable_disable_homepage") && !in_array($home_page_type, ['monoka'])) {
            redirect(cn("auth/login"));
        }
        $data = [
            'lang_current' => get_lang_code_defaut(),
			'languages'    => $this->model->fetch("*", LANGUAGE_LIST, "status = 1")
        ];
        $this->template->set_layout('blank_page');
        $this->template->build('../../../themes/'.$home_page_type.'/views/index', $data);
    }
    
}