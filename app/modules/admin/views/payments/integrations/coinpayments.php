
<?php
  $payment_elements = [
    [
      'label'      => form_label('Public key'),
      'element'    => form_input(['name' => "payment_params[option][public_key]", 'value' => @$payment_option->public_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Private key'),
      'element'    => form_input(['name' => "payment_params[option][secret_key]", 'value' => @$payment_option->secret_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Allowed Coins acceptance'),
      'element'    => '',
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  
  $items_coin = coinpayments_coin_setting();
  $items_coins_elements = [];
  if (!empty($items_coin)) {
    foreach ($items_coin as $key => $item) {
      $payment_check = (in_array($key, $payment_option->coinpayments_acceptance)) ? TRUE : FALSE;
      $hidden_value = form_hidden(["payment_params[option][coinpayments_acceptance][]" => 0]);
      $items_coins_elements[] = [
        'label'      => $item,
        'element'    => $hidden_value . form_checkbox(['name' => "payment_params[option][coinpayments_acceptance][]", 'value' => $key, 'checked' => $payment_check, 'class' => 'custom-switch-input']),
        'class_main' => "col-md-6 col-sm-6 col-xs-6",
        'type'       => "switch",
      ];
    }
  }

  echo render_elements_form($payment_elements);
  echo render_elements_form($items_coins_elements);
?>

<div class="form-group">
  <label><span class="text-danger">Notes: </label>
  <div class="description-content">
    <ol>
      <li>To insert new coin, edit <span class="text-info">currency_helper.php</span> file in this path: app/helpers/ </li>
      <li>Find <span class="text-info">coinpayments_coin_setting</span> function and insert new coin</li>
    </ol>
  </div>
</div>