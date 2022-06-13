<?php
$form_url = admin_url($controller_name."/import_services/");
$form_attributes = array('class' => 'form actionForm', 'method' => "POST");
$form_hidden = ['api_id' => @$item['id']];

$class_element = app_config('template')['form']['class_element'];
$class_element_checkbox = app_config('template')['form']['class_element_checkbox'];

array_unshift($items_category, ['id' => 0, 'name' => 'Choose category']);
$form_items_category = array_column($items_category, 'name', 'id');
$hidden_convert_to_new_rate = form_hidden(["convert_to_new_currency" => 0]);

$elements = [
  [
    'label'      => form_label('Choose Category'),
    'element'    => form_dropdown('cate_id', $form_items_category, 0, ['class' => $class_element]),
    'class_main' => "",
  ],
  [
    'label'      => form_label('Price percentage increase (%) (Auto rounding to 2 decimal places)'),
    'element'    => form_dropdown('price_percentage_increase', range(0, 500), get_option("default_price_percentage_increase", 30), ['class' => $class_element]),
    'class_main' => "",
  ],
  [
    'label'      => form_label('Convert to new currency Rate (new currency Rate in Setting page)'),
    'element'    => $hidden_convert_to_new_rate . form_input(['name' => 'convert_to_new_currency', 'value' => 1,  'type' => 'checkbox', 'class' => $class_element_checkbox]),
    'class_main' => "col-md-12",
    'type' => "checkbox",
  ],
];
?>
<div class="col-md-12 col-xl-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Service Lists (<?=$item['name']?>)</h3>
      <div class="card-options">
        <a href="<?php echo admin_url($controller_name."/import_bulk_services/").$item['id']; ?>" class="ajaxModal btn btn-primary">
          <span class="mr-1"><i class="fe fe-plus-square"></i></span>
            Bulk Import Service
        </a>
      </div>
    </div>
    <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <?php
              echo form_fieldset('', ['class' => 'form-fieldset ']);
              echo render_elements_form($elements);
            ?>
              <div class="col-md-4">
                <label>&nbsp;</label>
                <button class="btn btn-primary btn-block">Submit</button>
              </div>
            <?php
              echo form_fieldset_close();
            ?>
          </div>
        </div>
        <div style="width:100%; height:calc(100vh - 350px); overflow:auto;">
          <table class="table table-hover table-bordered table-vcenter card-table" >
            <?php echo render_table_thead($columns, false, false, false); ?>  
            <tbody style="width:100%; height:calc(100vh - 350px); overflow:auto;">
              <?php if (!empty($item_services)) {
                foreach ($item_services as $key => $service) {
                  $item_checkbox      = show_item_check_box('check_item', $service['service']);
              ?>
                <tr class="tr_<?php echo esc($service['service']); ?>">
                  <th class="w-1"><?php echo $item_checkbox; ?></th>
                  <td class=""><?=$service['service'] . ' - ' .$service['name']?></td>
                  <td class="text-muted"><?=$service['category']?></td>
                  <td class="text-muted w-10p"><?=$service['type']?></td>
                  <td class="text-center w-10p"><strong><?=(double)$service['rate']; ?></strong></td>
                </tr>
              <?php }}?>
            </tbody>
          </table>  
        </div>
      </div>
    <?php echo form_close(); ?>
  </div>
</div>