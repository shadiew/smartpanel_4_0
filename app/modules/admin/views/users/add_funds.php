<?php
  $class_element = app_config('template')['form']['class_element'];
  $form_items_payment = [
    'manual' => 'Manual (Bank/Other)',
    'bonus'  => 'Bonus',
  ];
  if ($items_payment) {
    $form_items_payment = array_merge($form_items_payment, array_combine(array_column($items_payment, 'type'), array_column($items_payment, 'name')));
  }
  $elements = [
    [
      'label'      => form_label('Payment Method'),
      'element'    => form_dropdown('payment_method', $form_items_payment, '', ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Amount'),
      'element'    => form_input(['name' => 'amount', 'value' => '', 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secret Key (Use Admin password)'),
      'element'    => form_input(['name' => 'secret_key', 'value' => '', 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Transaction ID'),
      'element'    => form_input(['name' => 'transaction_id', 'value' => '', 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Note'),
      'element'    => form_input(['name' => 'tnx_note', 'value' => '', 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  if (!empty($item['ids'])) {
    $ids = $item['ids'];
    $modal_title = 'Add funds (' . $item['email'] . ')';
  }
  $form_url = admin_url($controller_name."/add_funds/");
  $redirect_url = admin_url($controller_name) . '?' . http_build_query(['field' => 'email','query' => $item['email']]);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = ['ids' => @$item['ids']];

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
