<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class maintenance extends MX_Controller {
	public $tb_users;

	public function __construct(){
		$this->tb_users = USERS;
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		if (!get_option("is_maintenance_mode")) {
			redirect(cn());
		}
		$data = array();
		$this->template->set_layout('maintenance');
		$this->template->build('index', $data);
	}

	public function access(){
		if (!get_option("is_maintenance_mode")) {
			redirect(cn());
		}
		$data = array();
		$this->template->set_layout('auth');
		$this->template->build('maintenance_access', $data);
	}

	public function ajax_get_access(){
		if (!get_option("is_maintenance_mode")) {
			redirect(cn());
		}

		$email    = post("email");
		$password = md5(post("password"));

		if($email == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("email_is_required")
			));
		}

		if($password == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("Password_is_required")
			));
		}

		$user = $this->model->get("id, status, ids, email, password, role, first_name, last_name, timezone", $this->tb_users, ['email' => $email]);

		$error = false;
		if (!$user) {
			$error = true;
		}else{
			// check the last hash password
			if ($this->model->app_password_verify(post("password"), $user->password)) {
				$error = false;
			}else{
				$error = true;
			}
		}

		if($error){
			ms(array(
				"status"  => "error",
				"message" => lang("email_address_and_password_that_you_entered_doesnt_match_any_account_please_check_your_account_again")
			));
		}

		if($user->status != 1){
			ms(array(
				"status"  => "error",
				"message" => lang("your_account_has_not_been_activated")
			));
		}	

		if($user->role != 'admin'){
			ms(array(
				"status"  => "error",
				"message" => "You don't currenctly have permission to access maintenance mode"
			));
		}

		set_session("uid", $user->id);
		set_cookie("verify_maintenance_mode", encrypt_encode("verified"), 1209600);
		$this->model->history_ip($user->id);

		ms(array(
			"status"  => "success",
			"message" => lang("Login_successfully")
		));

		
	}
}