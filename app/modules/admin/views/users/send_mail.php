<?php
  $class_element = app_config('template')['form']['class_element'];
  $class_element_editor     = app_config('template')['form']['class_element_editor'];
  $elements = [
    [
      'label'      => form_label('To'),
      'element'    => form_input(['name' => 'balance', 'value' => $item['email'], 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Subject'),
      'element'    => form_input(['name' => 'subject', 'value' => '', 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Message'),
      'element'    => form_textarea(['name' => 'message', 'value' => '', 'class' => $class_element_editor]),
      'class_main' => "col-md-12",
    ],
    
  ];
  if (!empty($item['ids'])) {
    $ids = $item['ids'];
    $modal_title = 'Send Mail (' . $item['email'] . ')';
  }
  $form_url = admin_url($controller_name."/mail/");
  $redirect_url = admin_url($controller_name) . '?' . http_build_query(['field' => 'email','query' => $item['email']]);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = [
    'ids'      => @$item['ids'],
    'email_to' => @$item['email'],
  ];
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
          <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1">Submit</button>
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 300});
  });
</script>
