<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class stripe extends MX_Controller {
    public $tb_users;
    public $tb_transaction_logs;
    public $tb_payments;
    public $tb_payments_bonuses;
    public $stripeapi;
    public $payment_type;
    public $payment_fee;
    public $payment_lib;
    public $currency_code;
    public $mode;

    public function __construct($payment = ""){
        parent::__construct();
        $this->load->model('add_funds_model', 'model');

        $this->tb_users            = USERS;
        $this->tb_transaction_logs = TRANSACTION_LOGS;
        $this->tb_payments         = PAYMENTS_METHOD;
        $this->tb_payments_bonuses = PAYMENTS_BONUSES;
        $this->payment_type		   = "stripe";
        $this->currency_code       = get_option("currency_code", "USD");
        if ($this->currency_code == "") {
            $this->currency_code = 'USD';
        }

        if (!$payment) {
            $payment = $this->model->get('id, type, name, params', $this->tb_payments, ['type' => $this->payment_type]);
        }
        $this->payment_id 	= $payment->id;
        $params  			= $payment->params;
        $option             = get_value($params, 'option');
        $this->mode         = get_value($option, 'environment');
        $this->payment_fee  = get_value($option, 'tnx_fee');
        $this->load->library("stripeapi");
        $this->payment_lib = new stripeapi(get_value($option, 'secret_key'), get_value($option, 'public_key'));
    }

    public function index(){
        redirect(cn("add_funds"));
    }

    /**
     *
     * Create payment
     *
     */
    public function create_payment($data_payment = ""){
        _is_ajax($data_payment['module']);

        $amount = $data_payment['amount'];
        $stripeToken  = post("stripeToken");
        if (!$stripeToken) {
            _validation('error', 'Your card number is incomplete.');
        }
        $users = session('user_current_info');
        // Item info
        $description   = lang("Balance_recharge")." - ".  $users['email'];
        $itemNumber    = 'SMMPANEL9271';
        $orderID       = "ORDS" . strtotime(NOW);

        if (strtolower($this->currency_code) == 'jpy') {
            $charge = $amount;
        }else{
            $charge = $amount * 100;
        }

        $data_charge = array(
            'amount'       => $charge,
            'currency'     => strtolower($this->currency_code),
            'description'  => $description,
            'source'       => $stripeToken,
            'metadata'     => array(
                'order_id' => $orderID
            )
        );

        //charge a credit or a debit card
        $result = $this->payment_lib->create_payment($data_charge);
        if (!empty($result) && $result->status == 'success') {
            $exists_txnid = $this->model->get('id, transaction_id', $this->tb_transaction_logs, ['transaction_id' => $result->response->id, 'uid' => session('uid')]);

            if ($exists_txnid) {
                 redirect(cn("add_funds"));
            } 
            /*----------  Insert to Transaction table  ----------*/
            $response = $result->response;
            if (strtolower($this->currency_code) == 'jpy') {
                $tx_amount = $response->amount;
            }else{
                $tx_amount = $response->amount / 100;
            }

            $data_tnx = array(
                "ids" 				=> ids(),
                "uid" 				=> session("uid"),
                "type" 				=> $this->payment_type,
                "transaction_id" 	=> $response->id,
                "amount" 	        => $tx_amount,
                'txn_fee'           => $tx_amount * ($this->payment_fee / 100),
                "created" 			=> NOW,
            );

            $this->db->insert($this->tb_transaction_logs, $data_tnx);
            $transaction_id = $this->db->insert_id();
            $data_tnx['id'] = $transaction_id;
            // Update Balance
            $this->model->add_funds_bonus_email((object)$data_tnx, $this->payment_id);
            set_session("transaction_id", $transaction_id);
            $this->load->view("redirect", ['redirect_url' => cn("add_funds/success")]);
        }else{
            if (isset($result->status) && $result->status == 'error') {
                _validation('error', $result->message);
            }
        }
    
        
    }
}