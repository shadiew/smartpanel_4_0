<?php
  $payment_elements = [
    [
      'label'      => form_label('Evironment'),
      'element'    => form_dropdown('payment_params[option][environment]', $form_environment, @$payment_option->environment, ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Paytm MID (Merchant ID)'),
      'element'    => form_input(['name' => "payment_params[option][paytm_mid]", 'value' => @$payment_option->paytm_mid, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secrect Key'),
      'element'    => form_input(['name' => "payment_params[option][merchant_key]", 'value' => @$payment_option->merchant_key, 'type' => 'text', 'class' => $class_element]),
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

<div class="form-group">
  <div class="form-group">
    <label class="form-label">Config:</label>
    <ol>
      <li>Callback URL: <code class="text-primary"><?php echo cn('add_funds/shopier/complete'); ?></code></li>
    </ol>
  </div>
</div>