<?php
defined('BASEPATH') or exit('No direct script access allowed');

class statistics extends My_UserController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'model');
        $this->load->library('user_agent');
    }

    public function index()
    {
        $this->load->model('order/order_model');
        $top_bestsellers = $this->order_model->list_items_best_seller(['limit' => 10], ['task' => 'user']);

        $data = array(
            "module" => get_class($this),
            "header_area" => $this->model->header_statistics(),
            "chart_and_orders_area" => $this->model->chart_and_orders_statistics(),
            "items_top_best_seller" => $top_bestsellers,
        );
        $this->template->build("index", $data);
    }
}
