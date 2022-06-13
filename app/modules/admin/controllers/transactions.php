<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class transactions extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "transactions";
        $this->params            = [];

        $this->columns     =  array(
            "user"             => ['name' => 'User',    'class' => ''],
            "transaction_id"   => ['name' => 'Transaction id', 'class' => 'text-center'],
            "payment"          => ['name' => 'Payment',  'class' => 'text-center'],
            "amount"           => ['name' => 'Amount',  'class' => 'text-center'],
            "tnx_fee"          => ['name' => 'Transaction fee',  'class' => 'text-center'],
            "note"             => ['name' => 'Note',  'class' => 'text-center'],
            "created"          => ['name' => 'Created',  'class' => 'text-center'],
            "Status"           => ['name' => 'Status',  'class' => 'text-center'],
        );
    }

    public function store(){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->form_validation->set_rules('status', 'Status', 'trim|required|integer|in_list[-1,0,1]|xss_clean',[
            'in_list' => 'The status is invalid',
        ]);
        if (!$this->form_validation->run()) _validation('error', validation_errors());
        if($this->input->post('ids')){
            $task   = 'edit-item';
        }
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

}