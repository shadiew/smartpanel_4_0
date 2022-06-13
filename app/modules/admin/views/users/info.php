<?php
  $class_element = app_config('template')['form']['class_element'];
  $elements = [
    [
      'label'      => form_label('Last History'),
      'element'    => form_input(['name' => 'history_ip', 'value' => @$item['history_ip'], 'type' => 'text', 'readonly'=>'true', 'class' => $class_element]),
      'class_main' => "col-md-12",
    ],
    [
      'label'      => form_label('Skype ID'),
      'element'    => form_input(['name' => 'skype_id', 'value' => @get_value($item_infor, 'skype_id'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6",
    ],
    [
      'label'      => form_label('Phone'),
      'element'    => form_input(['name' => 'phone', 'value' => @get_value($item_infor, 'phone'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6",
    ],
    [
      'label'      => form_label('WhatsApp Number'),
      'element'    => form_input(['name' => 'what_asap', 'value' => @get_value($item_infor, 'what_asap'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6",
    ],
    [
      'label'      => form_label('Website'),
      'element'    => form_input(['name' => 'website', 'value' => @get_value($item_infor, 'website'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6",
      'type'       => 'password',
    ],
  ];
  if (!empty($item['ids'])) {
    $ids = $item['ids'];
    $modal_title = 'More Informations (' . $item['email'] . ')';
  }
  $form_url = admin_url($controller_name."/store/");
  $redirect_url = admin_url($controller_name) . '?' . http_build_query(['field' => 'email','query' => $item['email']]);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = ['ids' => @$item['ids'], 'store_type' => 'user_information'];
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
