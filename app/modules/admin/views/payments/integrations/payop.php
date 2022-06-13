<?php
  $payment_elements = [
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
      'label'      => form_label('PayOP JWT token'),
      'element'    => form_input(['name' => "payment_params[option][jwt_token]", 'value' => @$payment_option->jwt_token, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  echo render_elements_form($payment_elements);
?>

<div class="form-group">
  <div class="form-group">
    <label class="form-label">Setting:</label>
    <ol>
    <li>Login to: <a href="https://payop.com/" target="_blank">https://payop.com/</a>, create project, verify and get Public Key, Secret key, JWT token</li>
    <li>Cronjob For PayOp: <br><code>* * * * * wget --spider -O - <?php echo BASE; ?>payop/cron &gt;/dev/null 2&gt;&amp;1 </code>
    </li>
    </ol>
  </div>
</div>