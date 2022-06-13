<?php
  $form_url = admin_url($controller_name."/store/");
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => get_current_url(), 'method' => "POST");
?>
<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-globe"></i> <?=lang("website_setting")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="form-group">
            <div class="form-label"><?=lang("Maintenance_mode")?></div>
            <label class="custom-switch">
              <input type="hidden" name="is_maintenance_mode" value="0">
              <input type="checkbox" name="is_maintenance_mode" class="custom-switch-input" <?=(get_option("is_maintenance_mode", 0) == 1) ? "checked" : ""?> value="1">
              <span class="custom-switch-indicator"></span>
              <span class="custom-switch-description"><?=lang("Active")?></span>
            </label>
            <br>
            <small class="text-danger"><strong><?=lang("note")?></strong> <?=lang("link_to_access_the_maintenance_mode")?></small> <br>
            <a href="<?=cn('maintenance/access')?>"><span class="text-link"><?=PATH?>maintenance/access</span></a>
          </div>
          
          <div class="form-group">
            <label class="form-label"><?=lang("website_name")?></label>
            <input class="form-control" name="website_name" value="<?=get_option('website_name', "SmartPanel")?>">
          </div>  

          <div class="form-group">
            <label class="form-label"><?=lang("website_description")?></label>
            <textarea rows="3" name="website_desc" class="form-control"><?=get_option('website_desc', "SmartPanel - #1 SMM Reseller Panel - Best SMM Panel for Resellers. Also well known for SmartPanel and Cheap SMM Panel for all kind of Social Media Marketing Services. SMM Panel for Facebook, Instagram, YouTube and more services!")?>
            </textarea>
          </div>

          <div class="form-group">
            <label class="form-label"><?=lang("website_keywords")?></label>
            <textarea rows="3" name="website_keywords" class="form-control"><?=get_option('website_keywords', "smm panel, SmartPanel, smm reseller panel, smm provider panel, reseller panel, instagram panel, resellerpanel, social media reseller panel, smmpanel, panelsmm, smm, panel, socialmedia, instagram reseller panel")?>
            </textarea>
          </div>
          <div class="form-group">
            <label class="form-label"><?=lang("website_title")?></label>
            <input class="form-control" name="website_title" value="<?=get_option('website_title', "SmartPanel - SMM Panel Reseller Tool")?>">
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-end">
      <button class="btn btn-primary btn-min-width text-uppercase"><?=lang("Save")?></button>
    </div>
  <?php echo form_close(); ?>
</div>
