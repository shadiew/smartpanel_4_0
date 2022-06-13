<?php
defined('BASEPATH') or exit('No direct script access allowed');

class add_funds_model extends MY_Model
{
    public $tb_users;
    public $tb_transaction_logs;
    public $tb_payments;
    public $tb_payments_bonuses;
    public $module;
    public $module_icon;

    public function __construct()
    {
        parent::__construct();
        $this->tb_users            = USERS;
        $this->tb_transaction_logs = TRANSACTION_LOGS;
        $this->tb_payments         = PAYMENTS_METHOD;
        $this->tb_payments_bonuses = PAYMENTS_BONUSES;
    }

    // Add fund, bonus and send email
    public function add_funds_bonus_email($data_tnx, $payment_id = "")
    {
        if (!$data_tnx) {
            return false;
        }

        if (!isset($data_tnx->transaction_id)) {
            return false;
        }

        // Update Balance  and total spent
        $user = $this->model->get('id, role, first_name, last_name, email, balance, timezone, spent', $this->tb_users, ["id" => $data_tnx->uid]);

        if (!$user) {
            return false;
        }

        $new_funds = $data_tnx->amount - $data_tnx->txn_fee;
        $new_balance = $user->balance + $new_funds;

        if ($user->spent == "") {
            $total_spent_before = $this->model->sum_results('amount', $this->tb_transaction_logs, ['status' => 1, 'uid' => $data_tnx->uid]);
            $total_spent = (double) round($total_spent_before + $data_tnx->amount, 4);
        } else {
            $total_spent = (double) round($user->spent + $data_tnx->amount, 4);
        }

        $user_update_data = [
            "balance" => $new_balance,
            "spent" => $total_spent,
        ];
        $this->db->update($this->tb_users, $user_update_data, ["id" => $data_tnx->uid]);

        //Add bonus
        if ($payment_id) {
            $data_pm_bonus = [
                'payment_id' => $payment_id,
                'uid' => $data_tnx->uid,
                'amount' => $new_funds,
            ];
            $this->add_payment_bonuses((object) $data_pm_bonus);
        }

        /*----------  Send payment notification email  ----------*/
        if (get_option("is_payment_notice_email", '')) {
            $this->send_mail_payment_notification(['user' => $user]);
        }
        return true;
    }

    private function add_payment_bonuses($data_pm = "")
    {

        if (!$data_pm) {
            return false;
        }

        if (!isset($data_pm->payment_id)) {
            return false;
        }

        // get payment bonuses
        $payment_bonus = $this->model->get("id, bonus_from, percentage, status", $this->tb_payments_bonuses, ['payment_id' => $data_pm->payment_id, 'status' => 1, 'bonus_from <=' => $data_pm->amount]);
        if (!$payment_bonus) {
            return false;
        }

        // add bonuses
        $user_info = $this->model->get('id, role, first_name, last_name, email, balance, timezone', $this->tb_users, ["id" => $data_pm->uid]);
        $user_balance = $user_info->balance;
        $bonus = ($payment_bonus->percentage / 100) * $data_pm->amount;
        $user_balance += $bonus;
        $this->db->update($this->tb_users, ["balance" => $user_balance], ["id" => $data_pm->uid]);

        // insert transaction id:
        $data_tnx_log = array(
            "ids" => ids(),
            "uid" => $data_pm->uid,
            "type" => 'Bonus',
            "transaction_id" => "",
            "amount" => $bonus,
            "status" => 1,
            "created" => NOW,
        );
        $transaction_log_id = $this->db->insert($this->tb_transaction_logs, $data_tnx_log);
        return true;
    }
    
    private function send_mail_payment_notification($data_pm_mail = "")
    {
        if ($data_pm_mail['user']) {

            $user = $data_pm_mail['user'];
            $subject = get_option('email_payment_notice_subject', '');
            $message = get_option('email_payment_notice_content', '');
            // get Merge Fields
            $merge_fields = [
                '{{user_firstname}}' => $user->first_name,
            ];
            $template = ['subject' => $subject, 'message' => $message, 'type' => 'default', 'merge_fields' => $merge_fields];
            $send_message = $this->model->send_mail_template($template, $user->id);

            if ($send_message) {
                ms(array(
                    'status' => 'error',
                    'message' => $send_message,
                ));
            }
            return true;
        } else {
            return false;
        }
    }
}
