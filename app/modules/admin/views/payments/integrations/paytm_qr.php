<?php
  $payment_elements = [
    [
      'label'      => form_label('Instructions'),
      'element'    => form_textarea(['name' => 'payment_params[option][instruction]', 'value' => @$payment_option->instruction, 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Paytm QR code image'),
      'element'    => form_input(['name' => "payment_params[option][qr_code]", 'value' => @$payment_option->qr_code, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Paytm Merchant ID'),
      'element'    => form_input(['name' => "payment_params[option][paytm_mid]", 'value' => @$payment_option->paytm_mid, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Currency rate'),
      'element'    => form_input(['name' => "payment_params[option][rate_to_usd]", 'value' => @$payment_option->rate_to_usd, 'type' => 'text', 'class' => $class_element . ' text-right']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type'       => "exchange_option",
      'item1'      => ['name' => get_option('currecy_code', 'USD'), 'value' => 1],
      'item2'      => ['name' => 'INR', 'value' => 76],
    ],
  ];
  echo render_elements_form($payment_elements);
?>
