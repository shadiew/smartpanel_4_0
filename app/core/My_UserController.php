<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_UserController extends MX_Controller
{
    protected $controller_title  = '';
    protected $controller_name   = '';
    protected $path_views        = '';
    protected $params = [];
    protected $columns = [];
    protected $limit_per_page = 5;

    public function __construct()
    {
        parent::__construct();
        if (is_admin_logged_in()) {
            redirect(admin_url('users'));
        }
    }
}
