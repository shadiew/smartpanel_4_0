<?php
  $class_element = app_config('template')['form']['class_element'];
  $class_element_text_emoji = app_config('template')['form']['class_element_text_emoji'];
  $config_status = app_config('config')['status'];
  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status); 
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name')); 

  $form_item_category = array_column($items_category, 'name', 'id');

  $form_service_mode = [
    'manual' => 'Manual',
    'api'    => 'API',
  ];
  $elements_header = [
    [
      'label'      => form_label('Service name'),
      'element'    => form_input(['name' => 'name', 'value' => @$item['name'], 'type' => 'text', 'class' => $class_element, 'data-emojiable' => 'true']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 emoji-picker-container",
    ],
    [
      'label'      => form_label('Category'),
      'element'    => form_dropdown('category', $form_item_category, @$item['cate_id'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Mode'),
      'element'    => form_dropdown('add_type', $form_service_mode, @$item['add_type'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  
  $form_service_type = app_config('template')['service_type'];

  $form_dripfeed = $form_status;
  ksort($form_dripfeed);
  $elements_manual_mode = [
    [
      'label'      => form_label('Service Type'),
      'element'    => form_dropdown('service_type', $form_service_type, @$item['type'], ['class' => $class_element]),
      'class_main' => "",
    ],
    [
      'label'      => form_label('Dripdfeed'),
      'element'    => form_dropdown('dripfeed', $form_dripfeed, @$item['dripfeed'], ['class' => $class_element]),
      'class_main' => "",
    ],
  ];
  array_unshift($items_provider, ['id' => 0, 'name' => 'Choose Provider']);
  $form_providers = array_column($items_provider, 'name', 'id');

  $items_provider_service = [];
  array_unshift($items_provider_service, ['id' => 0, 'name' => 'Choose Service']);
  $items_provider_service = array_column($items_provider_service, 'name', 'id');
  $elements_api_mode = [
    [
      'label'      => form_label('Provider'),
      'element'    => form_dropdown('api_provider_id', $form_providers, @$item['api_provider_id'], ['class' => 'ajaxGetServicesFromAPI ' . $class_element]),
      'class_main' => "",
    ],
    [
      'label'        => form_label('Service'),
      'element'      => form_dropdown('api_service_id', $items_provider_service, @$item['api_service_id'], ['class' => $class_element . ' ajaxGetServiceDetail']),
      'class_main'   => "form-group provider-services-list",
      'type'         => "admin-change-provider-service-list",
    ],
    [
      'label'      => form_label('Original Rate per 1000'),
      'element'    => form_input(['name' => 'original_price', 'value' => @$item['original_price'], 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
      'class_main' => "",
    ],
  ];

  $form_min = (isset($item['min'])) ? $item['min'] : get_option('default_min_order', "");
  $form_max = (isset($item['max'])) ? $item['max'] : get_option('default_max_order', "");
  $form_price = (isset($item['price'])) ? $item['price'] : get_option('default_price_per_1k', "");
  $elements_item_detail = [
    [
      'label'      => form_label('Min order'),
      'element'    => form_input(['name' => 'min', 'value' => $form_min, 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-4 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Max order'),
      'element'    => form_input(['name' => 'max', 'value' => $form_max, 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-4 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Rate per 1000'),
      'element'    => form_input(['name' => 'price', 'value' => (double)$form_price, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-4 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Description'),
      'element'    => form_textarea(['name' => 'desc', 'value' => htmlspecialchars_decode(@$item['desc'], ENT_QUOTES), 'class' => $class_element_text_emoji]),
      'class_main' => "col-md-12",
    ],
  ];
  
  if (!empty($item['id'])) {
    $ids = $item['id'];
    $modal_title = 'Edit Service (ID: ' . $item['id'] . ')';
  } else {
    $modal_title = 'Add new';
  }
  $form_url = admin_url($controller_name."/store/");
  $redirect_url = '';
  $form_attributes = array('class' => 'form actionForm', 'method' => "POST");
  $form_hidden = [
    'id'                   => @$item['id'],
    'api_service_id'       => @$item['api_service_id'],
    'api_service_type'     => @$item['type'],
    'api_service_dripfeed' => @$item['dripfeed'],
    'api_service_refill'   => @$item['refill'],
  ];
?>
<div id="main-modal-content" class="crud-service-form">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-pantone">
          <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $modal_title; ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <?php echo render_elements_form($elements_header); ?>
            <div class="col-md-12">
              <?php
                if (isset($item['add_type']) && $item['add_type'] == 'api') {
                  $class_api_fieldset = '';
                  $class_manual_fieldset = 'd-none';
                } else {
                  $class_api_fieldset = 'd-none';
                  $class_manual_fieldset = '';
                }

              ?>
              <?php
                echo form_fieldset('', ['class' => 'form-fieldset api-mode ' . $class_api_fieldset]);
                echo render_elements_form($elements_api_mode);
                echo form_fieldset_close();
              
                echo form_fieldset('', ['class' => 'form-fieldset manual-mode ' . $class_manual_fieldset]);
                echo render_elements_form($elements_manual_mode);
                echo form_fieldset_close();
              ?>
            </div>
            <?php echo render_elements_form($elements_item_detail); ?>
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
  $(function() {
    window.emojiPicker = new EmojiPicker({
      emojiable_selector: '[data-emojiable=true]',
      assetsPath: "<?=BASE?>assets/plugins/emoji-picker/lib/img/",
      popupButtonClasses: 'fa fa-smile-o'
    });
    window.emojiPicker.discover();
  });

  $(document).ready(function() {
    $(".text-emoji").emojioneArea({
      pickerPosition: "top",
      tonesStyle: "bullet"
    });
  });
</script>

<script>
  var _token  = '<?php echo strip_tags($this->security->get_csrf_hash()); ?>';
  var pathGetProviderServicesURL  = '<?php echo admin_url($controller_name . '/provider_services/'); ?>';
  // Check post type
  $(document).on("change", "select[name=add_type]", function(){
    var element = $(this),
        mode    = element.val();
    if(mode == 'api'){
      $('.api-mode').removeClass('d-none');
      $('.manual-mode').addClass('d-none');
    }else{
      $('.manual-mode').removeClass('d-none');
      $('.api-mode').addClass('d-none');
    }
  });
  /*----------  Get Services list from API  ----------*/
  $(document).on("change", ".ajaxGetServicesFromAPI" , function(){
    event.preventDefault();
    $('.provider-services-list').removeClass('d-none');
    $('.provider-services-list .dimmer').addClass('active');
    var element  = $(this),
        id       = element.val();
    if (id == "" || id == 0) return;
    var data       = $.param({token:_token, provider_id:id});
    $.post(pathGetProviderServicesURL, data, function(_result){
      setTimeout(function () {
        $(".crud-service-form input[name=original_price]").val('');
        $(".crud-service-form input[name=api_service_type]").val('');
        $(".crud-service-form input[name=api_service_dripfeed]").val('');
        $(".crud-service-form input[name=api_service_refill]").val('');
        $(".crud-service-form input[name=api_service_id]").val('');

        $('.provider-services-list .dimmer').removeClass('active');
        $(".provider-services-list select").html(_result);
      }, 100);
    });
  }) 

  /*----------  Load default service with API  ----------*/
  $( document ).ready(function() {
    if ($('select[name=add_type]').val() == "api") {
      console.log('sss');
      $('.provider-services-list').removeClass('d-none');
      $('.provider-services-list .dimmer').addClass('active');

      var id = $('select[name=api_provider_id]').val();
      if (id == "" || id == 0) return;

      var _api_service_id = $('input[name=api_service_id]').val();
      var data        = $.param({token:_token, provider_id:id, provider_service_id:_api_service_id});
      $.post(pathGetProviderServicesURL, data, function(_result){
        setTimeout(function () {
          $('.provider-services-list .dimmer').removeClass('active');
          $(".provider-services-list select").html(_result);
          var _that = $( ".ajaxGetServiceDetail option:selected"),
              _rate = _that.attr("data-rate");
              console.log(_rate);
          $(".crud-service-form input[name=original_price]").val(_rate);
        }, 100);
      });
      return false;
    }
  });

  // Select Provider Service
  $(document).on("change", ".ajaxGetServiceDetail", function(){
    $(".crud-service-form input[name=original_price]").val('');
    $(".crud-service-form input[name=min]").val('');
    $(".crud-service-form input[name=max]").val('');
    var element    = $('option:selected', this),
        _name      = element.attr('data-name'),
        _min       = element.attr('data-min'),
        _max       = element.attr("data-max"),
        _rate      = element.attr("data-rate"),
        _type      = element.attr("data-type"),
        _dripfeed  = element.attr("data-dripfeed"),
        _refill    = element.attr("data-refill");
    $(".crud-service-form input[name=original_price]").val(_rate);
    $(".crud-service-form input[name=api_service_type]").val(_type);
    $(".crud-service-form input[name=api_service_dripfeed]").val(_dripfeed);
    $(".crud-service-form input[name=api_service_refill]").val(_refill);

    $(".crud-service-form input[name=min]").val(_min);
    $(".crud-service-form input[name=max]").val(_max);
    $(".crud-service-form input[name=price]").val(_rate);
  })
</script>
