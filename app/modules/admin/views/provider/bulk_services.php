<?php
    $class_element = app_config('template')['form']['class_element'];
    $class_element_checkbox = app_config('template')['form']['class_element_checkbox'];
    
    for ($i=0; $i <= 1000; $i++) { 
        if ($i > 0 && $i % 25 == 0) {
            $form_limit[$i] = $i;
        }
    }
    $form_limit['all'] = 'All';
    $hidden_convert_to_new_rate = form_hidden(["convert_to_new_rate" => 0]);
    $elements = [
        [
            'label'      => form_label('Price percentage increase (%) (Auto rounding to 2 decimal places)'),
            'element'    => form_dropdown('price_percentage_increase', range(0, 500), get_option("default_price_percentage_increase", 30), ['class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label'      => form_label('Limit'),
            'element'    => form_dropdown('limit', $form_limit, '25', ['class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label'      => form_label('Convert to new currency Rate (new currency Rate in Setting page)'),
            'element'    => $hidden_convert_to_new_rate . form_input(['name' => 'convert_to_new_currency', 'value' => 1, 'type' => 'checkbox', 'class' => $class_element_checkbox]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox",
        ],
    ];

    if (!empty($item['id'])) {
        $modal_title = 'Bulk Import Service (' . $item['name'] . ')';
    }
    $form_url = admin_url($controller_name."/import_bulk_services/");
    $form_attributes = array('class' => 'form actionForm', 'method' => "POST");
    $form_hidden = ['api_id' => @$item['id']];
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
          <div class="row justify-content-md-center">
            <?php echo render_elements_form($elements); ?>

            <div class="col-md-12">
                <span class="text-danger">Note:</span>
                <ul class="text-muted">
                  <li> When you use this feature, the system will bulk import services, categories from API provider and set price percentage increase</li>
                </ul>
            </div>
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
