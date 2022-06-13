<?php
  $form_url = admin_url($controller_name."/store/");
  $modal_title = 'Edit ' . ucfirst($item['type']);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => admin_url($controller_name), 'method' => "POST");
  $form_hidden = [
    'id'    => @$item['id'],
    'type'  => @$item['type'],
    'payment_params[type]'  => @$item['type']
  ];
  $class_element = app_config('template')['form']['class_element'];
  $config_status = app_config('config')['status'];
  $payment_params = json_decode($item['params']);
  $payment_option = $payment_params->option;

  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status); 
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name')); 
  $form_new_users = [
    0 => "Not Allowed",
    1 => "Allowed",
  ];
  $form_environment = [
    'live'    => "Live (Product)",
    'sandbox' => "Sandbox (Test)",
  ];
  $general_elements = [
    [
      'label'      => form_label('Method name'),
      'element'    => form_input(['name' => "payment_params[name]", 'value' => @$item['name'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Sort'),
      'element'    => form_input(['name' => 'sort', 'value' => @$item['sort'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Minimum payment'),
      'element'    => form_input(['name' => "payment_params[min]", 'value' => @$item['min'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Maximum payment'),
      'element'    => form_input(['name' => "payment_params[max]", 'value' => @$item['max'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('New Users'),
      'element'    => form_dropdown('payment_params[new_users]', $form_new_users, @$item['new_users'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('payment_params[status]', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Transaction Fee (%)'),
      'element'    => form_input(['name' => 'payment_params[option][tnx_fee]', 'value' => @$payment_option->tnx_fee, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ]
  ];
  if (@$item['type'] == 'paypal') {
    array_pop($general_elements);
  }
?>
<div id="main-modal-content" class="payment-method-update-form">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-pantone">
          <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $modal_title; ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <?php echo render_elements_form($general_elements); ?>
          </div>
          <fieldset class="form-fieldset row">
            <?php
              include 'integrations/'. $item['type'] . '.php';
            ?>
          </fieldset>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1">Save</button>
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>

