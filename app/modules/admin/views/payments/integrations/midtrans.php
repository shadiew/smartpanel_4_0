<?php
  $payment_elements = [
    [
      'label'      => form_label('Evironment'),
      'element'    => form_dropdown('payment_params[option][environment]', $form_environment, @$payment_option->environment, ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Public key'),
      'element'    => form_input(['name' => "payment_params[option][public_key]", 'value' => @$payment_option->public_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secret key'),
      'element'    => form_input(['name' => "payment_params[option][secret_key]", 'value' => @$payment_option->secret_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Currency rate'),
      'element'    => form_input(['name' => "payment_params[option][rate_to_usd]", 'value' => @$payment_option->rate_to_usd, 'type' => 'text', 'class' => $class_element . ' text-right']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type'       => "exchange_option",
      'item1'      => ['name' => get_option('currecy_code', 'USD'), 'value' => 1],
      'item2'      => ['name' => 'IDR', 'value' => 14000],
    ],
    [
      'label'      => form_label('Payment Channels'),
      'element'    => '',
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  
  $items_coin = midtrans_payment_setting();
  $items_coins_elements = [];
  if (!empty($items_coin)) {
    foreach ($items_coin as $key => $item) {
      $payment_check = (in_array($key, $payment_option->midtrans_payment_channels)) ? TRUE : FALSE;
      $hidden_value = form_hidden(["payment_params[option][midtrans_payment_channels][]" => 0]);
      $items_coins_elements[] = [
        'label'      => $item,
        'element'    => $hidden_value . form_checkbox(['name' => "payment_params[option][midtrans_payment_channels][]", 'value' => $key, 'checked' => $payment_check, 'class' => 'custom-switch-input']),
        'class_main' => "col-md-6 col-sm-6 col-xs-6",
        'type'       => "switch",
      ];
    }
  }

  echo render_elements_form($payment_elements);
  //echo render_elements_form($items_coins_elements);
?>

<div class="form-group">
  <label class="form-label">Config:</label>
  <ol>
    <li>Midtrans Callback URL (Login to Midtrans account, Go to Setting -> Configurations)</li>
    <li><strong>Finish Redirect URL</strong>: <span class="text-info"><?php echo cn('checkout'); ?></span></li>
    <li><strong>Unfinish & Error Redirect URL</strong>: <span class="text-info"><?php echo cn('checkout/unsuccess'); ?></span></li>
    <li><strong>Payment Notification URL</strong>: <span class="text-info"><?php echo cn('midtrans_ipn'); ?></span></li>
  </ol>
</div>