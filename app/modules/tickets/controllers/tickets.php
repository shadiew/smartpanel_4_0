<?php
defined('BASEPATH') or exit('No direct script access allowed');

class tickets extends My_UserController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'main_model');

        $this->controller_name = strtolower(get_class($this));
        $this->controller_title = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views = "";
        $this->params = [];
        $this->columns = [];
    }

    public function index()
    {
        $page = (int) get("p");
        $page = ($page > 0) ? ($page - 1) : 0;
        if (in_array($this->controller_name, ['orders', 'dripfeed', 'subscriptions'])) {
            $filter_status = (isset($_GET['status'])) ? get('status') : 'all';
        } else {
            $filter_status = (isset($_GET['status'])) ? (int) get('status') : '3';
        }
        $this->params = [
            'pagination' => [
                'limit' => $this->limit_per_page,
                'start' => $page * $this->limit_per_page,
            ],
            'filter' => ['status' => $filter_status],
            'search' => ['query' => get('query'), 'field' => get('field')],
        ];
        $items = $this->main_model->list_items($this->params, ['task' => 'list-items']);
        $items_status_count = $this->main_model->count_items($this->params, ['task' => 'count-items-group-by-status']);
        $data = array(
            "controller_name" => $this->controller_name,
            "params" => $this->params,
            "columns" => $this->columns,
            "items" => $items,
            "items_status_count" => $items_status_count,
            "from" => $page * $this->limit_per_page,
            "pagination" => create_pagination([
                'base_url' => cn($this->controller_name),
                'per_page' => $this->limit_per_page,
                'query_string' => $_GET, //$_GET
                'total_rows' => $this->main_model->count_items($this->params, ['task' => 'count-items-for-pagination']),
            ]),
        );
        $this->template->build($this->path_views . 'index', $data);
    }

    public function add()
    {
        $data = array(
            "controller_name" => $this->controller_name,
        );
        $this->load->view('add', $data);
    }

    public function view($id = "")
    {
        $item = $this->main_model->get_item(['id' => (int)$id], ['task' => 'view-get-item']);
        if (!$item) redirect(cn($this->controller_name));
        $items_ticket_message = $this->main_model->list_items(['ticket_id' => $id], ['task' => 'list-items-ticket-message']);
        $data = array(
            "controller_name"       => $this->controller_name,
            "item"                  => $item,
            "items_ticket_message"  => $items_ticket_message,
        );
        $this->template->build('view', $data);
    }

    public function store()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(cn($this->controller_name));
        }
        $subject = post("subject");
        $description = $this->input->post('description', true);
        $description = strip_tags($description);

        $this->form_validation->set_rules('subject', 'subject', 'trim|required|xss_clean',[
            'required' => lang("subject_is_required")
        ]);

        switch ($subject) {
            case 'subject_order':
                $subject = lang("Order");
                $request = post("request");
                $orderid = post("orderid");
                $this->form_validation->set_rules('request', 'request', 'trim|required|xss_clean',[
                    'required' => lang("please_choose_a_request")
                ]);
                $this->form_validation->set_rules('orderid', 'orderid', 'trim|required|xss_clean',[
                    'required' => lang("order_id_field_is_required")
                ]);
                switch ($request) {
                    case 'refill':
                        $request = lang("Refill");
                        break;
                    case 'cancellation':
                        $request = lang("Cancellation");
                        break;
                    case 'speed_up':
                        $request = lang("Speed_Up");
                        break;
                    default:
                        $request = lang("Other");
                        break;
                }
                $subject = $subject . " - " . $request . " - " . $orderid;
                break;

            case 'subject_payment':
                $subject = "Payment";
                $payment = post("payment");
                $transaction_id = post("transaction_id");
                $this->form_validation->set_rules('payment', 'payment', 'trim|required|xss_clean',[
                    'required' => lang("please_choose_a_payment_type")
                ]);
                $this->form_validation->set_rules('transaction_id', 'transaction_id', 'trim|required|xss_clean',[
                    'required' => lang("transaction_id_field_is_required")
                ]);

                switch ($payment) {
                    case 'paypal':
                        $payment = lang("Paypal");
                        break;
                    case 'stripe':
                        $payment = lang("Stripe");
                        break;
                    case 'twocheckout':
                        $payment = lang("2Checkout");
                        break;
                    default:
                        $payment = lang("Other");
                        break;
                }
                $subject = $subject . " - " . $payment . " - " . $transaction_id;

                break;

            case 'subject_service':
                $subject = lang("Service");
                break;

            default:
                $subject = lang("Other");
                break;
        }
        $this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean',[
            'required' => lang("description_is_required")
        ]);
        if (!$this->form_validation->run()) _validation('error', validation_errors());
        $this->params = [
            'subject'     => $subject,
            'description' => $description,
        ];
        $response = $this->main_model->save_item($this->params, ['task' => 'add-item']);
        ms($response);
    }
    
    public function store_message()
    {
        if (!$this->input->is_ajax_request()) redirect(cn($this->controller_name));
        $this->form_validation->set_rules('message', 'message', 'trim|required|xss_clean', [
            'required' => lang('message_is_required')
        ]);
        if (!$this->form_validation->run()) _validation('error', validation_errors());
        if(!$this->input->post('ids')) _validation('error', lang("There_was_an_error_processing_your_request_Please_try_again_later"));
        $task   = 'add-item-ticket-massage';
        $response = $this->main_model->save_item( null, ['task' => $task]);
        ms($response);
    }

    public function ajax_update($ids)
    {
        
        $check_item = $this->model->get("ids, id, uid, subject", $this->tb_tickets, "ids = '{$ids}'");

        if (!empty($check_item)) {
            $data["ticket_id"] = $check_item->id;
            $this->db->insert($this->tb_ticket_message, $data);
            if ($this->db->affected_rows() > 0) {
                /*----------  Update time for changed in Tickets  ----------*/
                $data_ticket = array(
                    "changed" => NOW,
                );

                if (get_role('admin') || get_role('subporter')) {
                    $data_ticket['status'] = 'answered';
                    $data_ticket['admin_read'] = 0;
                    $data_ticket['user_read'] = 1;
                } else {
                    $data_ticket['status'] = 'pending';
                    $data_ticket['admin_read'] = 1;
                    $data_ticket['user_read'] = 0;
                }

                $this->db->update($this->tb_tickets, $data_ticket, ["id" => $check_item->id]);
                /*----------  Send email notification to new user and Admin  ----------*/
                if (get_option("is_ticket_notice_email", '') && !get_role('user')) {
                    $subject = $check_item->subject;
                    $ticket_number = $check_item->id;
                    $subject = get_option("website_name", "") . " - #Ticket" . "$ticket_number - $subject";
                    $check_email_issue = $this->model->send_email($subject, $message, $check_item->uid, false);
                    if ($check_email_issue) {
                        ms(array(
                            "status" => "error",
                            "message" => $check_email_issue,
                        ));
                    }
                }

                if (get_option('is_ticket_notice_email_admin', 0) && get_role('user')) {
                    $ticket_id = $check_item->id;
                    $admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'", "id", "ASC")->id;
                    if ($admin_id == "") {
                        ms(array(
                            'status' => 'error',
                            'message' => lang('There_was_an_error_processing_your_request_Please_try_again_later'),
                        ));
                    }
                    $subject = $check_item->subject;
                    $subject = "{{website_name}}" . " - Relied Ticket #" . $ticket_id . " - [" . $subject . "]";
                    $template = ['subject' => $subject, 'message' => $message, 'type' => 'default'];
                    $user_info = session('user_current_info');
                    $username = $user_info['first_name'] . " " . $user_info['last_name'];
                    $from_email_data = ['from_email' => $user_info['email'], 'from_email_name' => $username];
                    $send_message = $this->model->send_mail_template($template, $admin_id, $from_email_data);
                    if ($send_message) {
                        ms(array(
                            'status' => 'error',
                            'message' => $send_message,
                        ));
                    }
                }

                ms(array(
                    "status" => "success",
                    "message" => lang("your_email_has_been_successfully_sent_to_user"),
                ));
            }
        } else {
            ms(array(
                "status" => "error",
                "message" => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
            ));
        }
    }

    public function ajax_change_status($ids)
    {
        $status = post("status");
        $check_item = $this->model->get("ids,id", $this->tb_tickets, "ids = '{$ids}'");
        if (!empty($check_item)) {
            if ($status == 'closed') {
                $data['admin_read'] = 0;
                $data['user_read'] = 0;
            }
            if ($status == 'unread') {
                $data["admin_read"] = 1;
            } else {
                $data["status"] = $status;
                $data["changed"] = NOW;
            }
            $this->db->update($this->tb_tickets, $data, ["ids" => $ids]);
            if ($this->db->affected_rows() > 0) {
                ms(array(
                    "status" => "success",
                    "message" => lang("Update_successfully"),
                ));
            }
        } else {
            ms(array(
                "status" => "error",
                "message" => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
            ));
        }
    }

    //Search
    public function search()
    {
        $k = get('query');
        $k = htmlspecialchars(trim($k));
        $search_type = (int) get('search_type');
        $data_search = ['k' => $k, 'type' => $search_type];
        $page = (int) get("p");
        $page = ($page > 0) ? ($page - 1) : 0;
        $limit_per_page = get_option("default_limit_per_page", 10);
        $query = ['query' => $k, 'search_type' => $search_type];
        $query_string = "";
        if (!empty($query)) {
            $query_string = "?" . http_build_query($query);
        }
        $config = array(
            'base_url'         => cn(get_class($this) .         "/search" . $query_string),
            'total_rows'       => $this->model->get_count_tickets_by_search($data_search),
            'per_page'         => $limit_per_page,
            'use_page_numbers' => true,
            'prev_link'        => '<i class="fe fe-chevron-left"></i>',
            'first_link'       => '<i class="fe fe-chevrons-left"></i>',
            'next_link'        => '<i class="fe fe-chevron-right"></i>',
            'last_link'        => '<i class="fe fe-chevrons-right"></i>',
        );
        $this->pagination->initialize($config);
        $links = $this->pagination->create_links();

        $tickets = $this->model->search_logs_by_get_method($data_search, $limit_per_page, $page * $limit_per_page);
        $data = array(
            "module" => get_class($this),
            "tickets" => $tickets,
            "links" => $links,
        );

        $this->template->build('index', $data);
    }

    public function ajax_search()
    {
        _is_ajax(get_class($this));
        $k = post("k");
        $tickets = $this->model->get_search_tickets($k);
        $data = array(
            "module" => get_class($this),
            "tickets" => $tickets,
        );
        $this->load->view("ajax_search", $data);
    }

    public function ajax_order_by($status = "")
    {
        if (!empty($status) && $status != "") {
            $tickets = $this->model->get_tickets(false, $status);
            $data = array(
                "module" => get_class($this),
                "tickets" => $tickets,
            );
            $this->load->view("ajax_search", $data);
        }
    }

}
