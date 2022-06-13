<?php
  $payment_elements = [
    [
      'label'      => form_label('Evironment'),
      'element'    => form_dropdown('payment_params[option][environment]', $form_environment, @$payment_option->environment, ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secrect Key'),
      'element'    => form_input(['name' => "payment_params[option][secret_key]", 'value' => @$payment_option->secret_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Category ID'),
      'element'    => form_input(['name' => "payment_params[option][category_id]", 'value' => @$payment_option->category_id, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Bill Name'),
      'element'    => form_input(['name' => "payment_params[option][bill_name]", 'value' => @$payment_option->bill_name, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Bill Description'),
      'element'    => form_input(['name' => "payment_params[option][bill_description]", 'value' => @$payment_option->bill_description, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Currency rate'),
      'element'    => form_input(['name' => "payment_params[option][rate_to_usd]", 'value' => @$payment_option->rate_to_usd, 'type' => 'text', 'class' => $class_element . ' text-right']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type'       => "exchange_option",
      'item1'      => ['name' => get_option('currecy_code', 'USD'), 'value' => 1],
      'item2'      => ['name' => 'RM', 'value' => 76],
    ],
  ];
  echo render_elements_form($payment_elements);
?>

<div class="form-group">
  <label for="">Note:</label>
  <ul>
    <li><strong>Secret Key</strong>: Login to Toyyibpay Dashboard account and get it</li>
    <li><strong>Category ID</strong>: Create new Category and copy category id and paste to your system</li>
    <li><strong>Bill Name & Bill Description</strong>: * Max 30 alphanumeric characters, space and '_' only</li>
  </ul>
</div>