<?php
  $class_element = app_config('template')['form']['class_element'];
  $form_subjects = [
    'subject_order'   => lang("Order"),
    'subject_payment' => lang("Payment"),
    'subject_service' => lang("Service"),
    'subject_other'   => lang("Other"),
  ];
  $form_request = [
    'refill'         => lang("Refill"),
    'cancellation'   => lang("Cancellation"),
    'speed_up'       => lang("Speed_Up"),
    'other'          => lang("Other"),
  ];
  $form_payments = [
    'paypal'         => lang("Paypal"),
    'stripe'         => lang("Cancellation"),
    'speed_up'       => lang("Stripe"),
    'other'          => lang("Other"),
  ];

  $elements = [
    [
      'label'      => form_label(lang('Subject')),
      'element'    => form_dropdown('subject', $form_subjects, '', ['class' => $class_element . ' ajaxChangeTicketSubject']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label(lang('Request')),
      'element'    => form_dropdown('request', $form_request, '', ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 subject-order",
    ],
    [
      'label'      => form_label(lang('order_id')),
      'element'    => form_input(['name' => 'orderid', 'value' => '', 'placeholder' => lang("for_multiple_orders_please_separate_them_using_comma_example_123451234512345"),'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 subject-order",
    ],
    [
      'label'      => form_label(lang('Payment')),
      'element'    => form_dropdown('payment', $form_payments, '', ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 subject-payment d-none",
    ],
    [
      'label'      => form_label(lang('Transaction_ID')),
      'element'    => form_input(['name' => 'transaction_id', 'value' => '', 'placeholder' => lang("enter_the_transaction_id"),'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 subject-payment d-none",
    ],
    [
      'label'      => form_label(lang("Description")),
      'element'    => form_textarea(['name' => 'description', 'value' => '', 'class' => $class_element]),
      'class_main' => "col-md-12",
    ],
  ];
  $form_url     = cn($controller_name. "/store/");
  $redirect_url = cn($controller_name) ;
  $form_attributes = ['class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST"];
?>

<div id="main-modal-content">
  <div class="modal-right">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" id="add_new_ticket">
        <?php echo form_open($form_url, $form_attributes); ?>
          <div class="modal-header bg-pantone">
            <h4 class="modal-title"><i class="fe fe-edit"></i> <?=lang("add_new_ticket")?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body" >
            <div class="form-body">
              <div class="row justify-content-md-center">
                <?php echo render_elements_form($elements); ?>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1"><?=lang("Submit")?></button>
            <button type="button" class="btn btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?=lang("Cancel")?></button>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>