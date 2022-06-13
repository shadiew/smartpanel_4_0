<?php
  $form_url = admin_url($controller_name."/store/");
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => get_current_url(), 'method' => "POST");
?>
<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-sliders"></i> <?=lang("other_settings")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 col-lg-12">

          <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("enable_https")?></h5>
          <div class="form-group">
            <div class="form-label"><?=lang("Status")?></div>
            <label class="custom-switch">
              <input type="hidden" name="enable_https" value="0">
              <input type="checkbox" name="enable_https" class="custom-switch-input" <?=(get_option("enable_https", 0) == 1) ? "checked" : ""?> value="1">
              <span class="custom-switch-indicator"></span>
              <span class="custom-switch-description"><?=lang("Active")?></span>
            </label>
            <br>
            <small class="text-danger"><strong><?=lang("note")?></strong> <?=lang("note_please_make_sure_the_ssl_certificate_has_the_active_status_in_your_hosting_before__you_activate")?></small>
          </div>
          
          <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("emded_code")?> </h5>
          <small class="text-danger">Put in the <strong> &#60;head&#62;</strong> tag of the page. Using for Google Analytics, Facebook pixel code etc</small>
          <div class="form-group">
            <textarea rows="5" name="embed_head_javascript" id="embed_head_javascript"><?=get_option('embed_head_javascript', '')?></textarea>
            <small class="text-danger"><?=lang("note_only_supports_javascript_code")?></small>
          </div>

          <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("emded_code")?></h5>
          <small class="text-danger">Be placed immediately before the closing <strong> &#60;/body&#62;</strong> tag of the page. Using for Chat plugin etc</small>
          <div class="form-group">
            <textarea rows="5" name="embed_javascript" id="embed_javascript"><?=get_option('embed_javascript', '')?></textarea>
            <small class="text-danger"><?=lang("note_only_supports_javascript_code")?></small>
          </div>

          <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("social_media_links")?></h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?=lang("Facebook")?></label>
                <input class="form-control" name="social_facebook_link" value="<?=get_option('social_facebook_link',"https://www.facebook.com/")?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?=lang("Instagram")?></label>
                <input class="form-control" name="social_instagram_link" value="<?=get_option('social_instagram_link',"https://www.instagram.com/")?>">
              </div> 
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?=lang("Pinterest")?></label>
                <input class="form-control" name="social_pinterest_link" value="<?=get_option('social_pinterest_link',"https://www.pinterest.com/")?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?=lang("Twitter")?></label>
                <input class="form-control" name="social_twitter_link" value="<?=get_option('social_twitter_link',"https://twitter.com/")?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Tumblr</label>
                <input class="form-control" name="social_tumblr_link" value="<?=get_option('social_tumblr_link',"https://tumblr.com/")?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Youtube</label>
                <input class="form-control" name="social_youtube_link" value="<?=get_option('social_youtube_link',"https://youtube.com/")?>">
              </div>
            </div>

          </div>

          <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("contact_informations")?></h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?=lang("Tel")?></label>
                <input class="form-control" name="contact_tel" value="<?=get_option('contact_tel',"+12345678")?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?=lang("Email")?></label>
                <input class="form-control" name="contact_email" value="<?=get_option('contact_email',"do-not-reply@smartpanel.com")?>">
              </div> 
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?=lang("working_hour")?></label>
                <input class="form-control" name="contact_work_hour" value="<?=get_option('contact_work_hour',"Mon - Sat 09 am - 10 pm")?>">
              </div>
            </div>
          </div>
          <h5 class="text-info"><i class="fe fe-link"></i> CopyRight </h5>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">Content</label>
                <input class="form-control" name="copy_right_content" value="<?=get_option('copy_right_content',"Copyright &copy; 2020 - SmartPanel")?>">
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

<!-- codemirror -->
<link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/plugins/codemirror/lib/codemirror.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/plugins/codemirror/theme/monokai.css">
<script src="<?php echo BASE; ?>assets/plugins/codemirror/lib/codemirror.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo BASE; ?>assets/plugins/codemirror/mode/css/css.js" type="text/javascript" charset="utf-8"></script>
<script>
  setTimeout(function(){

    var editor = CodeMirror.fromTextArea(document.getElementById("embed_head_javascript"), {
      lineNumbers: true,
      theme: "monokai",
    });

    var editor = CodeMirror.fromTextArea(document.getElementById("embed_javascript"), {
      lineNumbers: true,
      theme: "monokai",
    });

  }, 200);
</script>