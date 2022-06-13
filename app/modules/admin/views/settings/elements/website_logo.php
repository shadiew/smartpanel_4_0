<?php
  $form_url = admin_url($controller_name."/store/");
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => get_current_url(), 'method' => "POST");
?>
<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-life-buoy"></i> <?=lang("website_logo")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="form-group">
            <label class="form-label"><?=lang("website_favicon")?></label>
            <div class="input-group">
              <input type="text" name="website_favicon" class="form-control" value="<?=get_option('website_favicon', BASE."assets/images/favicon.png")?>">
              <span class="input-group-append">
                <button class="btn btn-info" type="button">
                  <i class="fe fe-image">
                    <input class="settings_fileupload" type="file" name="files[]" multiple="">
                  </i>
                </button>
              </span>
            </div>
          </div>  
          <div class="form-group">
            <label class="form-label"><?=lang("website_logo")?></label>
            <div class="input-group">
              <input type="text" name="website_logo" class="form-control" value="<?=get_option('website_logo', BASE."assets/images/logo.png")?>">
              <span class="input-group-append">
                <button class="btn btn-info" type="button">
                  <i class="fe fe-image">
                    <input class="settings_fileupload" type="file" name="files[]" multiple="">
                  </i>
                </button>
              </span>
            </div>
          </div> 
          <div class="form-group">
            <label class="form-label">Website mark logo</label>
            <div class="input-group">
              <input type="text" name="website_logo_mark" class="form-control" value="<?=get_option('website_logo_mark', BASE."assets/images/logo-mark.png")?>">
              <span class="input-group-append">
                <button class="btn btn-info" type="button">
                  <i class="fe fe-image">
                    <input class="settings_fileupload" type="file" name="files[]" multiple="">
                  </i>
                </button>
              </span>
            </div>
          </div> 
          <div class="form-group">
            <label class="form-label"><?=lang("website_logo_white")?></label>
            <div class="input-group">
              <input type="text" name="website_logo_white" class="form-control" value="<?=get_option('website_logo_white', BASE."assets/images/logo-white.png")?>">
              <span class="input-group-append">
                <button class="btn btn-info" type="button">
                  <i class="fe fe-image">
                    <input class="settings_fileupload" type="file" name="files[]" multiple="">
                  </i>
                </button>
              </span>
            </div>
          </div> 
        </div>
      </div>
    </div>
    <div class="card-footer text-end">
      <button class="btn btn-primary btn-min-width text-uppercase"><?=lang("Save")?></button>
    </div>
  <?php echo form_close(); ?>
</div>
