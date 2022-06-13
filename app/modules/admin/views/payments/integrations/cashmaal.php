<?php
  $form_payment_curreyncy_codes = [
    'USD' => "USD - US Dollar",
    'PKR' => "PKR - Pakistan Rupee",
  ];
  $payment_elements = [
    [
      'label'      => form_label('Cashmaal Web ID'),
      'element'    => form_input(['name' => "payment_params[option][merchant_key]", 'value' => @$payment_option->merchant_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Cashmaal IPN KEY'),
      'element'    => form_input(['name' => "payment_params[option][ipn_key]", 'value' => @$payment_option->ipn_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Currency code'),
      'element'    => form_dropdown('payment_params[option][currency_code]', $form_payment_curreyncy_codes, @$payment_option->currency_code, ['class' => $class_element . ' ajaxChangeCurrencyCode']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('currency_rate'),
      'element'    => form_input(['name' => "payment_params[option][rate_to_usd]", 'value' => @$payment_option->rate_to_usd, 'type' => 'text', 'class' => $class_element . ' text-right']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type'       => "exchange_option",
      'item1'      => ['name' => get_option('currecy_code', 'USD'), 'value' => 1],
      'item2'      => ['name' => @$payment_option->currency_code, 'value' => 168],
    ],
  ];
  echo render_elements_form($payment_elements);
?>

<div class="form-group">
  <label class="form-label text-danger">Note:</label>
  <ul>
    <li>Login to: <a href="https://cashmaal.com/" target="_blank">https://cashmaal.com/</a>.</li>
    <li>Go to Business Account Settings &#8594; Merchant Settings &#8594; Your store &#8594; IPN Settings</li>
    <li>Fill <strong>Website</strong> by <code class="text-info"><?php echo cn(); ?></code></li>
    <li>Fill <strong>IPN URL</strong> by <code class="text-info"><?php echo cn('cashmaal_ipn'); ?></code></li>
    <li>Copy <strong>IPN Key</strong> and <strong>Web ID</strong> and Save</li>
  </ul>
</div>
