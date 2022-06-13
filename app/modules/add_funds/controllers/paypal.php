<?php
defined('BASEPATH') or exit('No direct script access allowed');

class paypal extends MX_Controller
{
    public $tb_users;
    public $tb_transaction_logs;
    public $tb_payments;
    public $tb_payments_bonuses;
    public $paypal;
    public $payment_type;
    public $payment_id;
    public $currency_code;
    public $mode;
    public $payment_lib;
    public $client_id;
    public $secret_key;
    public $take_fee_from_user;

    public function __construct($payment = "")
    {
        parent::__construct();
        $this->load->model('add_funds_model', 'model');

        $this->tb_users = USERS;
        $this->payment_type = 'paypal';
        $this->tb_transaction_logs = TRANSACTION_LOGS;
        $this->tb_payments = PAYMENTS_METHOD;
        $this->tb_payments_bonuses = PAYMENTS_BONUSES;
        $this->currency_code = get_option("currency_code", "USD");
        if ($this->currency_code == "") {
            $this->currency_code = 'USD';
        }

        if (!$payment) {
            $payment = $this->model->get('id, type, name, params', $this->tb_payments, ['type' => $this->payment_type]);
        }
        $this->payment_id = $payment->id;
        $params                   = $payment->params;
        $option                   = get_value($params, 'option');
        $this->mode               = get_value($option, 'environment');
        $this->take_fee_from_user = get_value($params, 'take_fee_from_user');
        //options
        $this->client_id          = get_value($option, 'client_id');
        $this->secret_key         = get_value($option, 'secret_key');

        $this->load->library("paypalapi");
        $this->payment_lib        = new paypalapi($this->client_id, $this->secret_key, $this->mode);

    }

    public function index()
    {
        redirect(cn("add_funds"));
    }

    /**
     *
     * Create payment
     *
     */
    public function create_payment($data_payment = "")
    {
        _is_ajax($data_payment['module']);
        $amount = $data_payment['amount'];
        if (!$amount) {
            _validation('error', lang('There_was_an_error_processing_your_request_Please_try_again_later'));
        }

        if (!$this->client_id || !$this->secret_key) {
            _validation('error', lang('this_payment_is_not_active_please_choose_another_payment_or_contact_us_for_more_detail'));
        }

        $users = session('user_current_info');
        $data = (object) array(
            "amount" => $amount,
            "currency" => $this->currency_code,
            "redirectUrls" => cn("add_funds/paypal/complete"),
            "cancelUrl" => cn("add_funds/unsuccess"),
            "description" => lang('Deposit_to_') . get_option('website_name') . '. (' . $users['email'] . ')',
        );

        $response = $this->payment_lib->create_payment($data, $this->mode);
        if (isset($response->status)) {
            switch ($response->status) {
                case 'success':
                    $data_tnx_log = array(
                        "ids" => ids(),
                        "uid" => session("uid"),
                        "type" => $this->payment_type,
                        "transaction_id" => $response->data->id,
                        "amount" => $amount,
                        "status" => 0,
                        "created" => NOW,
                    );

                    $transaction_log_id = $this->db->insert($this->tb_transaction_logs, $data_tnx_log);
                    if ($this->input->is_ajax_request()) {
                        ms(['status' => 'success', 'redirect_url' => $response->approvalUrl]);
                    }
                    break;

                case 'error':
                    _validation('error', $response->message);
                    break;
            }

        } else {
            _validation('error', lang('There_was_an_error_processing_your_request_Please_try_again_later'));
        }
    }

    /**
     *
     * Call Execute payment after creating payment
     *
     */
    public function complete()
    {
        if ( !isset($_REQUEST["token"]) ) {
        	redirect(cn("add_funds"));
        }
        $token = get('token');
        $payer_id = get('PayerID');
        $response = $this->payment_lib->execute_payment($token , $payer_id, $this->mode);
        $transaction   = $this->model->get('*', $this->tb_transaction_logs, ['transaction_id' => $token, 'type' => $this->payment_type]);
        if (!$transaction) {
            redirect(cn("add_funds"));
        }
        if ($response->statusCode == 201 && $response->result->status == 'COMPLETED' && $transaction) {
            $paypal_fee  = 0;
            $captureId   = '';
            $payee_email = '';
            foreach($response->result->purchase_units as $purchase_unit)
            {
                $payee_email = $purchase_unit->payee->email_address;
                foreach($purchase_unit->payments->captures as $capture)
                {    
                    $captureId   = $capture->id;
                    $paypal_fee = $capture->seller_receivable_breakdown->paypal_fee->value;
                }
            }
            $data_tnx_log = array(
                "transaction_id" => ($captureId) ? $captureId : $transaction->transaction_id,
                'txn_fee'        => ($paypal_fee > 0) ? $paypal_fee : 0,
                'payer_email'    => $payee_email,
                "status"         => 1,
            );
            $this->db->update($this->tb_transaction_logs, $data_tnx_log, ['id' => $transaction->id]);
            /*----------  Add funds to user balance  ----------*/
            // Canculate new funds
            if ($this->take_fee_from_user) {
                $transaction->txn_fee =  $data_tnx_log['txn_fee'];
            } else {
                $transaction->txn_fee = 0;
            }
            // Update Balance
            $this->model->add_funds_bonus_email($transaction, $this->payment_id);

            set_session("transaction_id", $transaction->id);
            redirect(cn("add_funds/success"));
           

        } else {
            redirect(cn("add_funds/unsuccess"));
        }

    }

    
    public function complete_old_version()
    {
        if (!isset($_GET["paymentId"])) {
            redirect(cn("add_funds/unsuccess"));
        }
        $result = $this->payment_lib->execute_payment($_GET["paymentId"], $_GET["PayerID"], $this->mode);
        // get Transaction Id
        $transactions        = $result->getTransactions();
        $related_resources   = $transactions[0]->getRelatedResources();
        $sale                = $related_resources[0]->getSale();
        $get_transaction_fee = $sale->getTransactionFee();
        $sale_id             = $sale->getId();
        $txt_status          = $sale->getState();   //completed
        $payer_info          = $result->getPayer(); //Get Payer Infor

        $transaction = $this->model->get('*', $this->tb_transaction_logs, ['transaction_id' => $_GET["paymentId"], 'status' => 0, 'type' => $this->payment_type]);

        if (!$transaction) {
            redirect(cn("add_funds"));
        }

        if ($result && $result->state == 'approved' && $transaction) {
            /*----------  Insert to Transaction table  ----------*/
            $transaction_fee = $get_transaction_fee->getValue();
            $amount = $result->transactions[0]->amount;
            $data_tnx_log = array(
                "transaction_id" => $sale_id,
                "amount" => $amount->total,
                'txn_fee' => ($this->take_fee_from_user) ? $transaction_fee : 0,
                'payer_email' => $payer_info->payer_info->email,
                "status" => ($txt_status == 'completed') ? 1 : 0,
            );

            $this->db->update($this->tb_transaction_logs, $data_tnx_log, ['id' => $transaction->id]);
            /*----------  Add funds to user balance  ----------*/
            if ($txt_status == 'completed') {
                // Canculate new funds
                if ($this->take_fee_from_user) {
                    $transaction->txn_fee = $transaction_fee;
                } else {
                    $transaction->txn_fee = 0;
                }
                // Update Balance
                $this->model->add_funds_bonus_email($transaction, $this->payment_id);

                set_session("transaction_id", $transaction->id);
                redirect(cn("add_funds/success"));
            } else {
                redirect(cn('transactions'));
            }

        } else {
            redirect(cn("add_funds/unsuccess"));
        }

    }
}
