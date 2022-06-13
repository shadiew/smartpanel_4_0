<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class news extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "news";
        $this->params            = [];

        $this->columns     =  array(
            "description" => ['name' => 'description', 'class' => 'text-center'],
            "type"        => ['name' => 'Type',        'class' => 'text-center'],
            "start"       => ['name' => 'Start',       'class' => 'text-center'],
            "expiry"      => ['name' => 'Expiry',      'class' => 'text-center'],
            "status"      => ['name' => 'status',      'class' => 'text-center'],
        );
    }

    public function store($id = null){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $type = implode(',', array_keys(app_config('template')['news']));
        $this->form_validation->set_rules('type', 'type', "trim|required|in_list[$type]|xss_clean",[
            'in_list' => 'The type field is invalid format'
        ]);
        $this->form_validation->set_rules('start', 'start', 'trim|required|xss_clean');
        $this->form_validation->set_rules('expiry', 'expiry', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'status', 'trim|required|in_list[0,1]|xss_clean');

        if (!$this->form_validation->run()) _validation('error', validation_errors());

        $task = 'add-item';
        if($id !== null){
            $task   = 'edit-item';
        }
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

    public function view()
    {
        if (!$this->input->is_ajax_request()) redirect(cn($this->controller_name));
        set_cookie("news_annoucement", "clicked", 21600);
        $data = array(
            "controller_name" => $this->controller_name,
            "items"           => $this->main_model->list_items(null, ['task' => 'list-items-view-news']),
        );
        $this->load->view($this->path_views . "/view", $data);
    }
}