<?php
  $class_element = app_config('template')['form']['class_element'];
  $config_status = app_config('config')['status'];
  $form_status        = order_status_update_form($controller_name, $item['status']);
  $form_charge        = (!empty($item['charge']))         ? $item['charge']   : '';
  $form_quantity      = (!empty($item['quantity']))       ? $item['quantity'] : '';
  $form_remains       = (!empty($item['remains']))        ? $item['remains']  : '';
  $form_start_counter = (!empty($item['start_counter']))  ? $item['start_counter'] : '';
  $form_link          = (!empty($item['link']))           ? esc($item['link']) : '';
  $elements = [
    [
      'label'      => form_label('Quantity'),
      'element'    => form_input(['name' => 'quantity', 'value' => $form_quantity, 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Charge'),
      'element'    => form_input(['name' => 'charge', 'value' => $form_charge, 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Start Counter'),
      'element'    => form_input(['name' => 'start_counter', 'value' => $form_start_counter, 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Remains'),
      'element'    => form_input(['name' => 'remains', 'value' => $form_remains, 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, $item['status'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Link'),
      'element'    => form_input(['name' => 'link', 'value' => $form_link, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
  ];
  if (!empty($item['id'])) {
    $ids = $item['id'];
    $modal_title = 'Edit Order (' . $item['id'] . ')';
  }
  $form_url     = admin_url($controller_name."/store/");
  $redirect_url = admin_url($controller_name) . '?' . http_build_query(['field' => 'id','query' => $item['id']]);
  $form_attributes = ['class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST"];
  $form_hidden = ['id' => @$item['id']];
?>
<div id="main-modal-content">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-pantone">
          <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $modal_title; ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
        <div class="modal-body">
          <div class="row">
            <?php echo render_elements_form($elements); ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1">Save</button>
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>
