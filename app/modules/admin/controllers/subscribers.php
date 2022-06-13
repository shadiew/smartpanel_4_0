<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class subscribers extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "subscribers";
        $this->params            = [];

        $this->columns     =  array(
            "mail"     => ['name' => 'Mail',    'class'    => ''],
            "ip"       => ['name' => 'IP address', 'class' => 'text-center'],
            "location" => ['name' => 'Location',  'class'    => 'text-center'],
            "created"  => ['name' => 'Created',  'class'   => 'text-center'],
        );
    }
}