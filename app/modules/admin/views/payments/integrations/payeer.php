<?php
  $payment_elements = [
    [
      'label'      => form_label('Merchant ID'),
      'element'    => form_input(['name' => "payment_params[option][merchant_id]", 'value' => @$payment_option->merchant_id, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secret key'),
      'element'    => form_input(['name' => "payment_params[option][secret_key]", 'value' => @$payment_option->secret_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  echo render_elements_form($payment_elements);
?>

<div class="form-group">
  <div class="form-group">
    <label class="form-label">Setting:</label>
    <ol>
      <li>Go to Merchant Settings</li>
      <li>Status URL: <code class="text-primary"><?php echo cn('add_funds/payeer/complete'); ?></code></li>
      <li>Success  URL: <code class="text-primary"><?php echo cn('add_funds/payeer/complete'); ?></code></li>
      <li>Fail  URL: <code class="text-primary"><?php echo cn('add_funds/unsuccess'); ?></code></li>
    </ol>
  </div>
</div>