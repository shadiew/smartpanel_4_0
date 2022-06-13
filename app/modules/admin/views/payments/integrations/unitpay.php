<?php
  $form_payment_curreyncy_codes = [
    'USD' => "USD - US Dollar",
    'EUR' => "EUR",
    'RUB' => "RUB",
    'UAH' => "UAH",
    'BYN' => "BYN",
  ];
  $payment_elements = [
    [
      'label'      => form_label('Public Key'),
      'element'    => form_input(['name' => "payment_params[option][public_key]", 'value' => @$payment_option->public_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secret Key'),
      'element'    => form_input(['name' => "payment_params[option][secret_key]", 'value' => @$payment_option->secret_key, 'type' => 'text', 'class' => $class_element]),
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
  <label class="form-label"><strong>Note</strong></label>
  <ul>
    <li>Log in to your <a href="https://unitpay.ru/partner/signin" target="_blank">Unitpay account</a></li>
    <li>If your account is not verified, <strong>verify it by adding a meta tag</strong> to the Custom header code in Settings &gt; General </li>
    <li>Go to <strong>Current projects list</strong> section</li>
    <li>Сhoose your project</li>
    <li>Fill in <strong>Payment processor</strong> field <code class="text-info"><?php echo cn('unitpay_ipn'); ?></code></code></li>
    <li>Check <strong>Direct client to special project pages</strong> checkbox</li>
    <li>Fill in <strong>Fail url</strong> field <code class="text-info"><?php echo cn('add_funds/unsuccess'); ?></code></li>
    <li>Fill in <strong>Success url</strong> field <code class="text-info"><?php echo cn('add_funds'); ?></code></li>
    <li>Select a type of your Unitpay account</li>
    <li>Copy <strong>PUBLIC KEY</strong> value</li>
    <li>Copy <strong>SECRET KEY</strong> value</li>
    <li>Save your project settings</li>
  </ul>
</div>