<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class faqs extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "faqs";
        $this->params            = [];

        $this->columns     =  array(
            "faq"              => ['name' => 'Detail',      'class' => 'text-center'],
            "sort"             => ['name' => 'Sort',      'class' => 'text-center'],
            "status"           => ['name' => 'Status',   'class' => 'text-center'],
            "changed"          => ['name' => 'Changed',  'class' => 'text-center'],
        );
    }

    public function store($id = null){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->form_validation->set_rules('question', 'question', 'trim|required|xss_clean');
        $this->form_validation->set_rules('answer', 'answer', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sort', 'sort', 'trim|required|is_natural_no_zero|xss_clean');
        $this->form_validation->set_rules('status', 'status', 'trim|required|in_list[0,1]|xss_clean');

        if (!$this->form_validation->run()) _validation('error', validation_errors());

        $task = 'add-item';
        if($id !== null){
            $task   = 'edit-item';
        }
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

    public function change_sort($id = ""){
		if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $params = [
            'id'        => $id,
            'sort'      => (int)post('sort'),
        ];
		$response = $this->main_model->save_item($params, ['task' => 'change-sort']);
		ms($response);
	}

}