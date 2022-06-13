<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class client extends My_UserController {
    public $tb_users;
    public $tb_subscribers;
    public $tb_order;
    public $tb_categories;
    public $tb_services;
    public $module_name;
    public $module_icon;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        //Config Module
        $this->tb_users               = USERS;
        $this->tb_subscribers         = SUBSCRIBERS;
        $this->tb_order               = ORDER;
        $this->tb_categories          = CATEGORIES;
        $this->tb_services            = SERVICES;
        $this->controller_name        = strtolower(get_class($this));
    }
    
    public function index(){
        redirect(cn());
    }

    public function faq()
    {
        $data = array(
            "controller_name" => $this->controller_name,
            "items"           => $this->main_model->list_items(null, ['task' => 'list-items-faq']),
        );
        if (!session('uid')) {
            $this->template->set_layout('general_page');
            $this->template->build("faq/index", $data);
        }
        $this->template->build("faq/index", $data);
    }

    public function subscriber()
    {
        $email = post('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == "") {
              ms(array(
                'status'  => 'error',
                'message' => lang("invalid_email_format"),
            ));
        }

        $ip_address = get_client_ip();
        $data = array(
            "ids"		=> ids(),
            "ip"		=> $ip_address,
            "email"		=> $email,
            "created"   => NOW,
            "changed"   => NOW,
        );

        $location = get_location_info_by_ip($ip_address);
        if ($location->country != 'Unknown' && $location->country != '') {
            $data['country'] = $location->country;
        }else{
            $data['country'] = 'Unknown';
        }

        $is_exist_email = $this->main_model->get('id', $this->tb_subscribers, ['email' => $email]);
        if (!$is_exist_email) {
            $this->db->insert($this->tb_subscribers, $data);
            if($this->db->affected_rows() > 0) {
                ms(array(
                    'status'   => 'success',
                    'message'  => lang("you_subscribed_successfully_to_our_newsletter_thank_you_for_your_subsrciption"),
                ));
            }else{
                ms(array(
                    'status'   => 'error',
                    'message'  => lang("an_error_occurred_while_subscribing_please_try_again"),
                ));
            }
        }else{
            ms(array(
                'status'   => 'error',
                'message'  => lang("a_subscriber_for_the_specified_email_address_already_exists_try_another_email_address"),
            ));
        }
    }

    public function terms()
    {
        $data = array();
        if (!session('uid')) {
            $this->template->set_layout('general_page');
            $this->template->build("terms/index", $data);
        }
        $this->template->build("terms/index", $data);
    }

    public function cookie_policy(){
        if (!get_option("is_cookie_policy_page")) {
            redirect(cn('statistics'));
        }
        $data = array();
        if (!session('uid')) {
            $this->template->set_layout('general_page');
            $this->template->build("cookies_policy/index", $data);
        }
        
        $this->template->build("cookies_policy/index", $data);
    }

    public function news_annoucement()
    {
        if (!$this->input->is_ajax_request()) redirect(cn($this->controller_name));
        set_cookie("news_annoucement", "clicked", 21600);
        $data = array(
            "controller_name" => $this->controller_name,
            "items"           => $this->main_model->list_items(null, ['task' => 'list-items-news']),
        );
        $this->load->view("news/index", $data);
    }

    public function set_language()
    {
        $item = $this->main_model->get_item(['ids' => get('ids')], ['task' => 'get-item-language']);
        if (!empty($item)) {
            unset_session('langCurrent');
            set_session('langCurrent', $item);
        }
        redirect(get('redirect'));
    }

    public function back_to_admin()
    {
        if (session('uid_tmp')) {
            $redirect_url = admin_url('users') . '?field=email&query=' . current_logged_user()->email;
            unset_session("uid_tmp");
            unset_session("user_current_info");
            ms([
                'status'       => 'success', 
                'message'      => 'Your request is being processed', 
                'redirect_url' => $redirect_url,
            ]);
        } else {
            redirect(cn());
        }
    }
}