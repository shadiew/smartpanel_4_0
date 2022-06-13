<?php
  $form_payment_curreyncy_codes = [
    'USD' => "USD - US Dollar",
    'RUB' => "RUB",
    'EUR' => "EUR",
    'UAH' => "UAH",
    'KZT' => "KZT",
  ];

  $payment_elements = [
    [
      'label'      => form_label('Merchant ID'),
      'element'    => form_input(['name' => "payment_params[option][merchant_id]", 'value' => @$payment_option->merchant_id, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secret Word'),
      'element'    => form_input(['name' => "payment_params[option][secret_key]", 'value' => @$payment_option->secret_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secret Word 2'),
      'element'    => form_input(['name' => "payment_params[option][secret_key_2]", 'value' => @$payment_option->secret_key_2, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Currency code'),
      'element'    => form_dropdown('payment_params[option][currency_code]', $form_payment_curreyncy_codes, @$payment_option->currency_code, ['class' => $class_element . ' ajaxChangeCurrencyCode']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Currency rate'),
      'element'    => form_input(['name' => "payment_params[option][rate_to_usd]", 'value' => @$payment_option->rate_to_usd, 'type' => 'text', 'class' => $class_element . ' text-right']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type'       => "exchange_option",
      'item1'      => ['name' => get_option('currecy_code', 'USD'), 'value' => 1],
      'item2'      => ['name' => @$payment_option->currency_code, 'value' => 168],
    ],
    [
      'label'      => form_label('Payment Method Acceptance Settings:'),
      'element'    => '',
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];

  $items_coin = freekassa_payment_setting();
  $items_coins_elements = [];
  if (!empty($items_coin)) {
    foreach ($items_coin as $key => $item) {
      $payment_check = (in_array($key, $payment_option->freekassa_acceptance)) ? TRUE : FALSE;
      $hidden_value = form_hidden(["payment_params[option][freekassa_acceptance][]" => 0]);
      $items_coins_elements[] = [
        'label'      => $item,
        'element'    => $hidden_value . form_checkbox(['name' => "payment_params[option][freekassa_acceptance][]", 'value' => $key, 'checked' => $payment_check, 'class' => 'custom-switch-input']),
        'class_main' => "col-md-6 col-sm-6 col-xs-6",
        'type'       => "switch",
      ];
    }
  }
  echo render_elements_form($payment_elements);
  echo render_elements_form($items_coins_elements);
?>

<div class="form-group">
  <span class="text-danger"><strong><?=lang('note')?></strong></span>
  <ul class="small">
    <li> Go to the Free Kassa settings page </li>
    <li> Select the notification method <code class="text-primary">POST</code> </li>
    <li> Select the integration mode <code class="text-primary">NO</code></li>
    <li> Site URL: <code class="text-primary"><?=cn()?></code> </li>
    <li> Notification URL: <code class="text-primary"><?=cn('add_funds/freekassa/complete')?></code></li>
    <li> Success URL: <code class="text-primary"><?=cn('add_funds/freekassa/complete')?></code></li>
    <li> Unsuccess URL: <code class="text-primary"><?=cn('add_funds/unsuccess')?></code>
    <li>Please enable all Payment methods which support Curency Code at the same time. <br>For example: if you enable Curency Code - USD, you must be choose all payment support USD and set rate in currency rate fields</li>
    </li>
  </ul>
</div>