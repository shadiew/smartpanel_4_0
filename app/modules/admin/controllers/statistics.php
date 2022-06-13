<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class statistics extends My_AdminController {

    private $tb_main = CATEGORIES;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "statistics";
        $this->params            = [];
    }

    public function index()
    {
        $this->load->model('Users_model');
        $items_last_users = $this->Users_model->list_items(['limit' => 5], ['task' => 'items-last-users']);
        $header_area           = $this->main_model->header_statistics();
        $chart_and_orders_area = $this->main_model->chart_and_orders_statistics();
        $header_area['orders']['value'] = $chart_and_orders_area['orders_statistics']['orders']['value'];
        $data = array(
            "controller_name"         => $this->controller_name,
            "header_area"             => $header_area,
            "chart_and_orders_area"   => $chart_and_orders_area,
            "items_last_users"        => $items_last_users,
        );
        
        $this->template->build($this->path_views . "/index", $data);
    }
}