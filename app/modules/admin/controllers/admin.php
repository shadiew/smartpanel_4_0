<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class admin extends My_AdminController {

    private $tb_main = USERS;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "admin";
        $this->params            = [];
        $this->tb_main           = USERS;
    }
    
    public function index()
    {
        redirect(admin_url('users'));
    }
    
    public function profile()
    {   
        $this->load->model('users_model');
        $item = $this->users_model->get_item($this->params, ['task' => 'get-item-current-admin']);
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
        );
        $this->template->build('profile/profile', $data);
    }

    public function store()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));

        if ($this->input->post('store_type') == 'update_info') {
            $task = 'update-info-item';
            $this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('timezone', 'timezone', 'trim|required|xss_clean');
        }

        if ($this->input->post('store_type') == 'change_pass') {
            $task = 'change-pass-item';

            $this->form_validation->set_rules('old_password', 'old password', 'trim|required|min_length[6]|max_length[25]|xss_clean');
            $this->form_validation->set_rules('password', 'new password', 'trim|required|min_length[6]|max_length[25]|differs[old_password]|xss_clean');
            $this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|min_length[6]|max_length[25]|matches[password]|xss_clean');
            //Check secret key
            $this->load->model('users_model');
            $is_valid_secret_key = $this->users_model->verify_admin_access(['secret_key' => post('old_password')], ['task' => 'check-admin-secret-key']);
            if (!$is_valid_secret_key) {
                _validation('error', 'The old password you entered does not match your existing password');
            }
        }
        if (!$this->form_validation->run()) _validation('error', validation_errors());
        $response = $this->main_model->save_item($this->params, ['task' => $task]);
        ms($response);
    }

    public function logout(){
        unset_session("uid");
        unset_session("auto_confirm");
        unset_session("user_current_info");
        $this->session->sess_destroy();
        if (get_option("is_maintenance_mode")) {
            delete_cookie("verify_maintenance_mode");
        }
        redirect(cn());
    }
}