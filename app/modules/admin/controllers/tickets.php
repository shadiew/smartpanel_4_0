<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class tickets extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "tickets";
        $this->params            = [];

        $this->columns     =  array(
            "id"             => ['name' => 'ID',    'class' => 'text-center'],
            "user"           => ['name' => 'User', 'class' => 'text-center'],
            "subject"        => ['name' => 'Subject',  'class' => 'text-center'],
            "status"         => ['name' => 'Status',  'class' => 'text-center'],
            "created"        => ['name' => 'Created',  'class' => 'text-center'],
        );
    }

    public function view($id = "")
    {
        $item = $this->main_model->get_item(['id' => (int)$id], ['task' => 'view-get-item']);
        if (!$item) redirect(admin_url($this->controller_name));
        $items_ticket_message = $this->main_model->list_items(['ticket_id' => $id], ['task' => 'list-items-ticket-message']);
        $data = array(
            "controller_name"       => $this->controller_name,
            "item"                  => $item,
            "items_ticket_message"  => $items_ticket_message,
        );
        $this->template->build($this->path_views . '/view', $data);
    }

    public function store()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->form_validation->set_rules('message', 'message', 'trim|required|xss_clean');

        if (!$this->form_validation->run()) _validation('error', validation_errors());

        if(!$this->input->post('ids')) _validation('error', 'There was some wrong with your request');

        $task   = 'add-item-ticket-massage';
        $response = $this->main_model->save_item( null, ['task' => $task]);
        ms($response);
    }

    // Change status
    public function change_status($status = "", $id = "")
    {
        if (!in_array($status, ['closed', 'pending', 'unread', 'answered']) || !$id) {
            redirect(admin_url($this->controller_name));
        }
        $params = [
            'id'        => $id,
            'status'    => $status,
        ];
        $response = $this->main_model->save_item($params, ['task' => 'change-status']);
        if ($response['status'] && $status == 'unread') {
            redirect(admin_url($this->controller_name));
        } else{
            redirect(admin_url($this->controller_name . '/view/' . $id));
        }
    }
}
