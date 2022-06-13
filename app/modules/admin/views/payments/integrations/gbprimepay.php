<?php
  $payment_elements = [
    [
      'label'      => form_label('Evironment'),
      'element'    => form_dropdown('payment_params[option][environment]', $form_environment, @$payment_option->environment, ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Customer key'),
      'element'    => form_input(['name' => "payment_params[option][customer_key]", 'value' => @$payment_option->customer_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Public Key'),
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
      'item2'      => ['name' => 'BATH', 'value' => 49],
    ],
  ];
  echo render_elements_form($payment_elements);
?>

<div class="form-group">
  <div class="form-group">
    <label class="form-label">Setting:</label>
    <ol>
      <li>
        Go to your <a href="https://www.gbprimepay.com/" target="_blank">GB Prime Pay account</a>
      </li>
      <li>
        Select option <strong>Shop type</strong>: <code class="text-danger">Website shop</code>
      </li>
      <li>
        Select options <strong>Bill payment</strong> and <strong>Qrcode payment</strong>: <code class="text-danger">Yes</code>
      </li>
    </ol>
  </div>
</div>
