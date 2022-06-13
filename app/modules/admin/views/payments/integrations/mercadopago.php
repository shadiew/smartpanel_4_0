<?php
  $form_payment_curreyncy_codes = [
    'USD' => "USD - US Dollar",
    'ARS' => "ARS",
    'CLF' => "CLF",
    'CLP' => "CLP",
    'BRL' => "BRL",
    'COP' => "COP",
    'MXN' => "MXN",
  ];
  $payment_elements = [
    [
      'label'      => form_label('Evironment'),
      'element'    => form_dropdown('payment_params[option][environment]', $form_environment, @$payment_option->environment, ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Public Key'),
      'element'    => form_input(['name' => "payment_params[option][public_key]", 'value' => @$payment_option->public_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Access Token'),
      'element'    => form_input(['name' => "payment_params[option][access_token]", 'value' => @$payment_option->access_token, 'type' => 'text', 'class' => $class_element]),
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
    <li> Cron URL: <small><code  class="text-primary">* * * * * wget --spider -O - <?php echo cn('mercadopago/cron'); ?> &gt;/dev/null 2&gt;&amp;1 </code></small></li>
    <li> Currently, Mercado Pago only allows payments in the local currency. That is, the account created in Colombia only accepts payments in Colombian pesos (COP) and from clients that have an account in the same country.</li>
  </ul>
</div>