<?php
  $form_payment_curreyncy_codes = [
    'USD' => "USD - US Dollar",
    'RUB' => "RUB",
    'EUR' => "EUR",
    'UAH' => "UAH",
  ];

  $payment_elements = [
    [
      'label'      => form_label('Merchant ID'),
      'element'    => form_input(['name' => "payment_params[option][merchant_id]", 'value' => @$payment_option->merchant_id, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secret Word'),
      'element'    => form_input(['name' => "payment_params[option][secret_word]", 'value' => @$payment_option->secret_word, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secret Word 2'),
      'element'    => form_input(['name' => "payment_params[option][secret_word2]", 'value' => @$payment_option->secret_word2, 'type' => 'text', 'class' => $class_element]),
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
  ];
  echo render_elements_form($payment_elements);
?>

<div class="form-group">
  <span class="text-danger"><strong><?=lang('note')?></strong></span>
  <ul class="small">
    <li>Log in to your <a href="https://enot.io/" target="_blank">Ehot account</a></li>
    <li>Copy <strong>Merchant ID</strong> value</li>
    <li>Copy <strong>SECRET Word</strong> value</li>
    <li>Copy <strong>SECRET Word2</strong> value</li>
    <li>Go to the settings page and Set Webhook URL: <code class="text-info"><?php echo cn('ehot_ipn'); ?></code></code></li>
    <li>Save your project settings</li>
  </ul>
</div>