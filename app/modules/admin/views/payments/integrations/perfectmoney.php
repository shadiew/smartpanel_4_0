<?php
  $payment_elements = [
    [
      'label'      => form_label('USD wallets (USD)'),
      'element'    => form_input(['name' => "payment_params[option][usd_wallet]", 'value' => @$payment_option->usd_wallet, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Alternate Passphrase'),
      'element'    => form_input(['name' => "payment_params[option][alternate_pass]", 'value' => @$payment_option->alternate_pass, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  echo render_elements_form($payment_elements);
?>

<div class="form-group">
  <div class="form-group">
    <label class="form-label">Config:</label>
    <ul class="small">
      <li> Login to Perfect Money Account </li>
      <li> Go to <strong>My Account</strong> → <strong>Modify settings</strong> </li>
      <li> Get <strong>Alternate Passphrase</strong>
          <ol>
            <li>Generate Alternate Passphrase</li>
            <li>Apply Changes</li>
          </ol>
      </li>
      <li>Copy Alternate Passphrase and save it</li>
    </ul>
  </div>
</div>