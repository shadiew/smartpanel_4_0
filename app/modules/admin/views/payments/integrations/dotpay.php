<?php
  $payment_elements = [
    [
      'label'      => form_label('Evironment'),
      'element'    => form_dropdown('payment_params[option][environment]', $form_environment, @$payment_option->environment, ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Merchant ID'),
      'element'    => form_input(['name' => "payment_params[option][merchant_id]", 'value' => @$payment_option->merchant_id, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Account ID'),
      'element'    => form_input(['name' => "payment_params[option][account_id]", 'value' => @$payment_option->account_id, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('API Login'),
      'element'    => form_input(['name' => "payment_params[option][api_login]", 'value' => @$payment_option->api_login, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('API Key'),
      'element'    => form_input(['name' => "payment_params[option][api_key]", 'value' => @$payment_option->api_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Currency rate'),
      'element'    => form_input(['name' => "payment_params[option][rate_to_usd]", 'value' => @$payment_option->rate_to_usd, 'type' => 'text', 'class' => $class_element . ' text-right']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type'       => "exchange_option",
      'item1'      => ['name' => get_option('currecy_code', 'USD'), 'value' => 1],
      'item2'      => ['name' => 'NGN', 'value' => 76],
    ],
  ];
  echo render_elements_form($payment_elements);
?>

<div class="form-group">
  <label for="">Config:</label>
  <ul>
    <li>Paystack Callback URL (Overrides the callback URL set on Paystack dashboard): <code><?=cn('add_funds/paystack/complete')?></code></li>
  </ul>
</div>