<?php
    $form_url = admin_url($controller_name."/store/");
    $form_attributes = array('class' => 'form actionForm', 'data-redirect' => get_current_url(), 'method' => "POST");
    $form_header_colors = [
        'default'            => 'Default',
        'purple'             => 'Purple',
        'light-blue'         => 'Light Blue',
        'lawrencium'         => 'Lawrencium',
        'cool-sky'           => 'Cool Sky',
        'dark-ocean'         => 'Dark Ocean',
        'cosmic-fusion'      => 'Cosmic Fusion',
        'royal'              => 'Royal',
        'twitch'             => 'Twitch',
        'bluelagoo'          => 'Bluelagoo',
        'dimigo'             => 'Dimigo',
    ];
    $class_element = app_config('template')['form']['class_element'];
    $elements_layout = [
        [
            'label'      => form_label('Header Menu Skin and Button Colors'),
            'element'    => form_dropdown('default_header_skin', $form_header_colors, get_option('default_header_skin', 'default'), ['class' => $class_element]),
            'class_main' => "col-md-6",
        ],
    ];
?>
<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-layout"></i> Template</h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h5 class="text-info"><i class="fe fe-link"></i> <?=lang('Default_Homepage')?></h5>
                    <select  name="default_home_page" class="form-control square">
                    <?php
                        $current_theme = get_option('default_home_page', 'regular');
                        $themes_arr = get_name_folder_from_dir();
                        if (!$themes_arr) {
                            $themes_arr = ['regular', 'pergo'];
                        }
                        foreach ($themes_arr as $key => $theme) {
                    ?>
                        <option value="<?php echo $theme; ?>" <?=( strtolower($current_theme) == $theme) ? 'selected': ''?>> <?php echo ucfirst($theme); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-info"><i class="fe fe-link"></i> User Layout</h5>
                <div class="form-group">
                    <div class="custom-switches-stacked">
                        <label class="custom-switch">
                            <input type="radio" name="user_layout" class="custom-switch-input" value="vertical" <?=(get_option('user_layout', "horizontal") == 'vertical')? "checked" : ''?>>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Vertical</span>
                        </label>
                        <label class="custom-switch">
                            <input type="radio" name="user_layout" value="horizontal" class="custom-switch-input" <?=(get_option('user_layout', "horizontal") == 'horizontal')? "checked" : ''?>> 
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Horizontal</span>
                        </label>
                    </div>
                </div>  
                <div class="row smtp-configure <?=(get_option('user_layout', "") == 'horizontal')? "" : 'd-none'?>">
                    <?php echo render_elements_form($elements_layout); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
      <button class="btn btn-primary btn-min-width text-uppercase"><?=lang("Save")?></button>
    </div>
  <?php echo form_close(); ?>
</div>

<script>
  // Check post type
  $(document).on("change","input[type=radio][name=user_layout]", function(){
    var _that = $(this);
    var _type = _that.val();
    if(_type == 'horizontal'){
      $('.smtp-configure').removeClass('d-none');
    }else{
      $('.smtp-configure').addClass('d-none');
    }
  });
</script>