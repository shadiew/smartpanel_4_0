<?php
  $form_url = admin_url($controller_name."/store/");
  $form_redirect_url = get_current_url();
  $card_tile = 'Add New';
  if (!empty($item['id'])) {
    $card_tile = 'Edit '. $item['code'];
  };

  
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $form_redirect_url, 'method' => "POST");
  $form_hidden = ['id' => @$item['id']];

  $class_element            = app_config('template')['form']['class_element'];
  $config_status            = app_config('config')['status'];
  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status); 
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name')); 

  $language_codes = language_codes();
  $form_language_codes = [];
  foreach ($language_codes as $key => $value) {
    $form_language_codes[$key] = strtoupper($key) . ' - ' .$value;
  } 
  $form_country_codes = country_codes();
  $form_language_default = [
    '0' => 'No',
    '1' => 'Yes',
  ];
  $elements = [
    [
      'label'      => form_label('Language Code'),
      'element'    => form_dropdown('language_code', $form_language_codes, @$item['code'], ['class' => $class_element]),
      'class_main' => "col-md-3",
    ],
    [
      'label'      => form_label('Location'),
      'element'    => form_dropdown('country_code', $form_country_codes, @$item['country_code'], ['class' => $class_element]),
      'class_main' => "col-md-3",
    ],
    [
      'label'      => form_label('Default'),
      'element'    => form_dropdown('default', $form_language_default, @$item['is_default'], ['class' => $class_element]),
      'class_main' => "col-md-3",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-3",
    ],
  ];
?>

<div class="row">
  <div class="col-md-12">
    <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
      <div class="card">
          <div class="card-header">
              <h3 class="card-title"><?=$card_tile?></h3>
              <div class="card-options">
                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
              </div>
          </div>
          <div class="card-body">
              <div class="form-body">
                  <div class="row">
                    <?php echo render_elements_form($elements); ?>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="title">
                              <h3 class="card-title mb-3">Translation editor</h3>
                          </div>
                          <table class="table table-hover table-bordered table-vcenter text-nowrap card-table">
                              <thead>
                                <tr>
                                  <th class="table-plus datatable-nosort">Url</th>
                                  <th class="datatable-nosort">Value</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  if(!empty($default_lang)){
                                    foreach ($default_lang as $slug => $slug_value) {
                                      $item_slug = (strlen($slug) >= 20)? truncate_string($slug, 20) : $slug;
                                      $item_value = (isset($lang_db->$slug)) ? trim(stripslashes($lang_db->$slug)) : trim(stripslashes($slug_value));
                                      
                                      $xhmtl_value = '';
                                      if (strlen($slug_value) >= 64) {
                                        $xhmtl_value = sprintf(
                                          '<div class="form-group">
                                            <textarea class="form-control" name="lang[%s]" style="max-height: 55px;">%s</textarea>
                                          </div>', $slug, $item_value
                                        );
                                      } else {
                                        $xhmtl_value = sprintf(
                                          '<div class="form-group">
                                            <input class="form-control" type="text" name="lang[%s]" value="%s">
                                          </div>', $slug, $item_value
                                        );
                                      }
                                ?>
                                <tr>
                                  <td class="table-plus" style="width: 40%"><?=$item_slug?></td>
                                  <td style="width: 60%;"><?=$xhmtl_value?></td>
                                </tr>
                                <?php }} ?>
                              </tbody>
                          </table>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
                        <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1">Save</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    <?php echo form_close(); ?>
  </div> 
</div>
  
