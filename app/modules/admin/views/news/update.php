<?php
  $ids = (!empty($item['id'])) ? $item['id']: '';
  $form_url = admin_url($controller_name."/store/");
  if ($ids != "") $form_url .= $ids;
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => admin_url($controller_name), 'method' => "POST");
  $form_hidden = ['id' => @$item['id']];
  
  $class_element            = app_config('template')['form']['class_element'];
  $class_element_editor     = app_config('template')['form']['class_element_editor'];
  $class_element_datepicker = app_config('template')['form']['class_element_datepicker'];
  $config_status            = app_config('config')['status'];

  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status); 
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name')); 

  $form_item_types = array_combine(array_keys(app_config('template')['news']), array_column(app_config('template')['news'], 'name')); 

  $elements = [
    [
      'label'      => form_label('Type'),
      'element'    => form_dropdown('type', $form_item_types, @$item['type'], ['class' => $class_element]),
      'class_main' => "col-md-12",
    ],
    [
      'label'      => form_label('Start'),
      'element'    => form_input(['name' => 'start', 'value' => date("d/m/Y",  strtotime(@$item['created'])), 'type' => 'text', 'onkeydown' => 'return false', 'class' => $class_element_datepicker]),
      'class_main' => "col-md-6",
    ],
    [
      'label'      => form_label('Expiry'),
      'element'    => form_input(['name' => 'expiry', 'value' => date("d/m/Y",  strtotime(@$item['expiry'])), 'type' => 'text', 'onkeydown' => 'return false', 'class' => $class_element_datepicker]),
      'class_main' => "col-md-6",
    ],
    [
      'label'      => form_label('Description'),
      'element'    => form_textarea(['name' => 'description', 'value' => htmlspecialchars_decode(@$item['description'], ENT_QUOTES), 'class' => $class_element_editor]),
      'class_main' => "col-md-12",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-12",
    ],
  ];

?>
<div id="main-modal-content">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-pantone">
          <h4 class="modal-title"><i class="fa fa-edit"></i> Edit</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
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

<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 300});
  });
</script>

<script>
  $(function(){
    $('.datepicker').datepicker({
      format: "dd/mm/yyyy",
      orientation: 'bottom',
      autoclose: true,
    });
    <?php if (!isset($item['created']) && !isset($item['expiry'])) {?>
     $(".datepicker").datepicker().datepicker("setDate", new Date());
    <?php }?>
    function truncateDate(date) {
      return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }
  });
</script>
