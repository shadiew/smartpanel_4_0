<?php
    $class_element = app_config('template')['form']['class_element'];
    $class_element_checkbox = app_config('template')['form']['class_element_checkbox'];
    $form_sync_request = [
        '0' => 'Only for current services',
        '1' => 'All services'
    ];

    $hidden_new_price           = form_hidden(["sync_request_options[new_price]"           => 0]);
    $hidden_original_price      = form_hidden(["sync_request_options[original_price]"      => 0]);
    $hidden_service_name        = form_hidden(["sync_request_options[service_name]"        => 0]);
    $hidden_old_service_status  = form_hidden(["sync_request_options[old_service_status]"  => 0]);
    $hidden_min_max_dripfeed    = form_hidden(["sync_request_options[min_max_dripfeed]"    => 0]);
    $hidden_service_desc        = form_hidden(["sync_request_options[service_desc]"        => 0]);
    $hidden_convert_to_new_rate = form_hidden(["sync_request_options[convert_to_new_currency]" => 0]);
    $elements = [
        [
            'label'      => form_label('Price percentage increase (%) (Auto rounding to 2 decimal places)'),
            'element'    => form_dropdown('price_percentage_increase', range(0, 500), get_option("default_price_percentage_increase", 30), ['class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label'      => form_label('Synchronous request'),
            'element'    => form_dropdown('sync_request', $form_sync_request, 0, ['class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label'      => form_label('Sync New Price'),
            'element'    => $hidden_new_price . form_input(['name' => 'sync_request_options[new_price]', 'value' => 1,  'type' => 'checkbox', 'class' => $class_element_checkbox]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox",
        ],
        [
            'label'      => form_label('Sync Original Price'),
            'element'    => $hidden_original_price . form_input(['name' => 'sync_request_options[original_price]', 'value' => 1,  'type' => 'checkbox', 'class' => $class_element_checkbox]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox",
        ],
        [
            'label'      => form_label('Service Name'),
            'element'    => $hidden_service_name . form_input(['name' => 'sync_request_options[service_name]', 'value' => 1,  'type' => 'checkbox', 'class' => $class_element_checkbox]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox",
        ],
        [
            'label'      => form_label('Sync Old Service Status'),
            'element'    => $hidden_old_service_status . form_input(['name' => 'sync_request_options[old_service_status]', 'value' => 1,  'type' => 'checkbox', 'class' => $class_element_checkbox]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox",
        ],
        [
            'label'      => form_label('Sync Min | Max | Dripfeed'),
            'element'    => $hidden_min_max_dripfeed . form_input(['name' => 'sync_request_options[min_max_dripfeed]', 'value' => 1,  'type' => 'checkbox', 'class' => $class_element_checkbox]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox",
        ],
        [
            'label'      => form_label('Sync Service Description (Support only HQ SmartPanel)'),
            'element'    => $hidden_service_desc . form_input(['name' => 'sync_request_options[service_desc]', 'value' => 1,  'type' => 'checkbox', 'class' => $class_element_checkbox]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox",
        ],
        [
            'label'      => form_label('Convert to new currency Rate (new currency Rate in Setting page)'),
            'element'    => $hidden_convert_to_new_rate . form_input(['name' => 'sync_request_options[convert_to_new_currency]', 'value' => 1,  'type' => 'checkbox', 'class' => $class_element_checkbox]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox",
        ],
    ];

    if (!empty($item['id'])) {
        $modal_title = 'Sync Services (' . $item['name'] . ')';
    }
    $form_url        = admin_url($controller_name."/sync_services/");
    $form_attributes = array('class' => 'form actionForm', 'method' => "POST");
    $form_hidden     = ['api_id'     => @$item['id']];
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
                    <li> Synchronous request:
                        <ol>
                            <li><strong class="text-success">Current Service</strong>: Syncing all current services available</li>
                            <li><strong class="text-success">All Services</strong>: Syncing all services available and add new service automatically if service doesn't exists</li>
                        </ol>
                    </li>
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
