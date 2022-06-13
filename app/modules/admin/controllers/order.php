<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class order extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "order";
        $this->params            = [];

        $this->columns     =  array(
            "id"                => ['name' => 'Order ID',    'class' => ''],
            "user"              => ['name' => 'user', 'class' => ''],
            "order_details"     => ['name' => 'Order Details', 'class' => 'text-center'],
            "created"           => ['name' => 'Created', 'class' => 'text-center'],
            "response"          => ['name' => 'API Response', 'class' => 'text-center'],
            "status"            => ['name' => 'Status',  'class' => 'text-center'],
        );
    }

    public function store(){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->form_validation->set_rules('link', 'link', 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_counter', 'start counter', 'trim|is_natural|xss_clean');
        $this->form_validation->set_rules('remains', 'remains', 'trim|is_natural|xss_clean');
        if (post('status') == 'partial') {
            $this->form_validation->set_rules('remains', 'remains', 'trim|required|is_natural|xss_clean');
        }
        if (!$this->form_validation->run()) _validation('error', validation_errors());
        $task   = 'edit-item';
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

    public function resend($id = ""){
        $item = $this->main_model->get_item(['id' => (int)$id], ['task' => 'get-item']);
        if (!$item || (!in_array($item['status'], ['error', 'fail']))) redirect(admin_url($this->controller_name));
        $task   = 'resend-item';
        $this->params = [
            'item' => $item
        ];
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        redirect(admin_url($this->controller_name));
    }

}