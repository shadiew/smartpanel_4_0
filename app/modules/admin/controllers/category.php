<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class category extends My_AdminController {

    private $tb_main = CATEGORIES;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "category";
        $this->params            = [];

        $this->columns     =  array(
            "name"             => ['name' => 'Name',    'class' => ''],
            "sort"             => ['name' => 'Sorting', 'class' => 'text-center'],
            "status"           => ['name' => 'Status',  'class' => 'text-center'],
        );
    }

    public function store(){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        
        $this->form_validation->set_rules('sort', 'sort', 'trim|required|is_natural_no_zero|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]|xss_clean');
        $task = 'add-item';
        $id = post('id');
        $name_unique = "|is_unique[$this->tb_main.name]";
        if ($id) {
            $task   = 'edit-item';
            $name_unique = "|edit_unique[$this->tb_main.name.$id]";
        }
        $this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean'. $name_unique, [
            'is_unique' => 'The name already exists.',
        ]);
        if (!$this->form_validation->run()) _validation('error', validation_errors());
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

    public function change_sort($id = "")
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $params = [
            'id'        => $id,
            'sort'      => (int)post('sort'),
        ];
        $response = $this->main_model->save_item($params, ['task' => 'change-sort']);
        ms($response);
    }

}