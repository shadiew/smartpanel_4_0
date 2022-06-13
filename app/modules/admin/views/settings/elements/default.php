<?php
  $form_url = admin_url($controller_name."/store/");
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => get_current_url(), 'method' => "POST");
?>
<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-settings"></i> Default Setting</h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 col-lg-12">

          <div class="form-group">
            <div class="form-label"><i class="fe fe-link"></i> Admin Account</div>
            <label class="custom-switch">
              <input type="hidden" name="admin_auto_logout_when_change_ip" value="0">
              <input type="checkbox" name="admin_auto_logout_when_change_ip" class="custom-switch-input" <?=(get_option("admin_auto_logout_when_change_ip", 0) == 1) ? "checked" : ""?> value="1">
              <span class="custom-switch-indicator"></span>
              <span class="custom-switch-description">Active</span>
            </label>
            <br>
            <small class="text-danger"><strong><?=lang("note")?></strong> Log admin out when there is a change of IP address</a></small>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("Pagination")?></h5>
              <div class="form-group">
                <label><?=lang("limit_the_maximum_number_of_rows_per_page")?></label>
                <select name="default_limit_per_page" class="form-control square">
                  <?php
                    for ($i = 1; $i <= 100; $i++) {
                      if ($i%5 == 0) {
                  ?>
                  <option value="<?=$i?>" <?=(get_option("default_limit_per_page", 10) == $i)? "selected" : ''?>><?=$i?></option>
                  <?php }} ?>
                </select>
              </div>
            </div> 
                
          </div>
          
          <div class="form-group">
            <div class="form-label"><i class="fe fe-link"></i> Tickets log (Auto clear ticket lists)</div>
            <label class="custom-switch">
              <input type="hidden" name="is_clear_ticket" value="0">
              <input type="checkbox" name="is_clear_ticket" class="custom-switch-input" <?=(get_option("is_clear_ticket", 0) == 1) ? "checked" : ""?> value="1">
              <span class="custom-switch-indicator"></span>
              <span class="custom-switch-description">Active</span>
            </label>
          </div>
          <div class="form-group">
            <label><?=lang("clear_ticket_lists_after_x_days_without_any_response_from_user")?></label>
            <select  name="default_clear_ticket_days" class="form-control square">
              <?php 
                for ($i = 1; $i <= 90; $i++) { 
              ?>
              <option value="<?=$i?>" <?=(get_option('default_clear_ticket_days', 30) == $i)? 'selected': ''?>> <?=$i?></option>
              <?php } ?>
            </select>
          </div>

          <h5><i class="fe fe-link"></i> <?=lang("default_service")?></h5>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label><?=lang("default_min_order")?></label>
                <input class="form-control" name="default_min_order" value="<?=get_option('default_min_order', 300)?>">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label><?=lang("default_max_order")?></label>
                <input class="form-control" name="default_max_order" value="<?=get_option('default_max_order', 5000)?>">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label><?=lang("default_price_per_1000")?></label>
                <input class="form-control" name="default_price_per_1k" value="<?=get_option('default_price_per_1k',"0.80")?>">
              </div>
            </div>
          </div>

          <h5><i class="fe fe-link"></i> <?=lang("dripfeed_option")?></h5>
          <div class="form-group">
            <label class="custom-switch">
              <input type="hidden" name="enable_drip_feed" value="0">
              <input type="checkbox" name="enable_drip_feed" class="custom-switch-input" <?=(get_option("enable_drip_feed", 0) == 1) ? "checked" : ""?> value="1">
              <span class="custom-switch-indicator"></span>
              <span class="custom-switch-description">Active</span>
            </label>
            <br>
            <small class="text-danger"><strong>Note:</strong> Please make sure the Drip-feed feature has the 'Active' status in API provider before you activate.</a></small>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><?=lang("default_runs")?> </label>
                <input class="form-control" name="default_drip_feed_runs" value="<?=get_option('default_drip_feed_runs', 10)?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label><?=lang("default_interval_in_minutes")?></label>
                <select name="default_drip_feed_interval" class="form-control square">
                  <?php
                    for ($i = 1; $i <= 60; $i++) {
                      if ($i%10 == 0) {
                  ?>
                  <option value="<?=$i?>" <?=(get_option("default_drip_feed_interval", 30) == $i)? "selected" : ''?>><?=$i?></option>
                  <?php }} ?>
                </select>
              </div>
            </div>    
          </div>

          <h5><i class="fe fe-link"></i> <?=lang("notification_popup_at_home_page")?></h5>
          <div class="form-group">
            <label class="custom-switch">
              <input type="hidden" name="enable_notification_popup" value="0">
              <input type="checkbox" name="enable_notification_popup" class="custom-switch-input" <?=(get_option("enable_notification_popup", 0) == 1) ? "checked" : ""?> value="1">
              <span class="custom-switch-indicator"></span>
              <span class="custom-switch-description">Active</span>
            </label>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
              <label class="form-label"><?=lang("Content")?></label>
              <textarea rows="3" name="notification_popup_content" id="notification_popup_content" class="form-control plugin_editor"><?=get_option('notification_popup_content', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet, in eam consetetur consectetuer. Vivendo eleifend postulant ut mei, vero maiestatis cu nam. Qui et facer mandamus, nullam regione lucilius eu has. Mei an vidisse facilis posidonium, eros minim deserunt per ne.</p><p>Duo quando tibique intellegam at. Nec error mucius in, ius in error legendos reformidans. Vidisse dolorum vulputate cu ius. Ei qui stet error consulatu.</p><p>Mei habeo prompta te. Ignota commodo nam ei. Te iudico definitionem sed, placerat oporteat tincidunt eu per, stet clita meliore usu ne. Facer debitis ponderum per no, agam corpora recteque at mel.</p>")?>
              </textarea>
            </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-6">
              <h5 class="m-t-10"><i class="fe fe-link"></i> Disable Home page (Langding page)</h5>
              <div class="form-group">
                <label class="custom-switch">
                  <input type="hidden" name="enable_disable_homepage" value="0">
                  <input type="checkbox" name="enable_disable_homepage" class="custom-switch-input" <?=(get_option("enable_disable_homepage", 0) == 1) ? "checked" : ""?> value="1">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>
                </label>
              </div>
            </div>

            <div class="col-md-6">
              <h5 class="m-t-10"><i class="fe fe-link"></i>  Disable Signup Page</h5>
              <div class="form-group">
                <label class="custom-switch">
                  <input type="hidden" name="disable_signup_page" value="0">
                  <input type="checkbox" name="disable_signup_page" class="custom-switch-input" <?=(get_option("disable_signup_page", 0) == 1) ? "checked" : ""?> value="1">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>
                </label>
              </div>
            </div>

            <div class="col-md-6">
              <h5 class="m-t-10"><i class="fe fe-link"></i> Explication of the service symbol</h5>
              <div class="form-group">
                <label class="custom-switch">
                  <input type="hidden" name="enable_explication_service_symbol" value="0">
                  <input type="checkbox" name="enable_explication_service_symbol" class="custom-switch-input" <?=(get_option("enable_explication_service_symbol", 0) == 1) ? "checked" : ""?> value="1">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>
                </label>
              </div>
            </div>
            
            <div class="col-md-6">
              <h5 class="m-t-10"><i class="fe fe-link"></i>  Displays the service lists without login or register</h5>
              <div class="form-group">
                <label class="custom-switch">
                  <input type="hidden" name="enable_service_list_no_login" value="0">
                  <input type="checkbox" name="enable_service_list_no_login" class="custom-switch-input" <?=(get_option("enable_service_list_no_login", 0) == 1) ? "checked" : ""?> value="1">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>
                </label>
              </div>
            </div>

            <div class="col-md-6">
              <h5 class="m-t-10"><i class="fe fe-link"></i> Displays News & Announcement feature</h5>
              <div class="form-group">
                <label class="custom-switch">
                  <input type="hidden" name="enable_news_announcement" value="0">
                  <input type="checkbox" name="enable_news_announcement" class="custom-switch-input" <?=(get_option("enable_news_announcement", 0) == 1) ? "checked" : ""?> value="1">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>
                </label>
              </div>
            </div>

            <div class="col-md-6">
              <h5 class="m-t-10"><i class="fe fe-link"></i> Displays API tab in header</h5>
              <div class="form-group">
                <label class="custom-switch">
                  <input type="hidden" name="enable_api_tab" value="0">
                  <input type="checkbox" name="enable_api_tab" class="custom-switch-input" <?=(get_option("enable_api_tab", 0) == 1) ? "checked" : ""?> value="1">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>
                </label>
              </div>
            </div>

            <div class="col-md-6">
              <h5 class="m-t-10"><i class="fe fe-link"></i> Displays required SkypeID field in signup page</h5>
              <div class="form-group">
                <label class="custom-switch">
                  <input type="hidden" name="enable_signup_skype_field" value="0">
                  <input type="checkbox" name="enable_signup_skype_field" class="custom-switch-input" <?=(get_option("enable_signup_skype_field", 0) == 1) ? "checked" : ""?> value="1">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>
                </label>
              </div>
            </div>
          </div>
          <hr>
          <h5 class="m-t-10"><i class="fe fe-link"></i> Displays Google reCAPTCHA</h5>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="custom-switch">
                  <input type="hidden" name="enable_goolge_recapcha" value="0">
                  <input type="checkbox" name="enable_goolge_recapcha" class="custom-switch-input" <?=(get_option("enable_goolge_recapcha", 0) == 1) ? "checked" : ""?> value="1">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Active</span>
                </label>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Google reCAPTCHA site key</label>
                <input class="form-control" name="google_capcha_site_key" value="<?=get_option('google_capcha_site_key', '')?>">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Google reCAPTCHA serect key</label>
                <input class="form-control" name="google_capcha_secret_key" value="<?=get_option('google_capcha_secret_key', '')?>">
              </div>
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

<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 200});
  });
</script>