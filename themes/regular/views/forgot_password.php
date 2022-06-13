<?php 
  include_once 'blocks/head.blade.php';
?>

<div class="login-bg-image"></div>
<div class="page auth-login-form">
  <div class="container h-100">
    <div class="row">
      <div class="col-md-6 col-login mx-auto auth-form">
        <form class="card actionForm" action="<?=cn("auth/ajax_forgot_password")?>" data-redirect="<?=cn("auth/login")?>" method="POST">
          <div class="card-body p-t-10">
            <div class="card-title text-center">
              <div class="site-logo mb-2">
                <a href="<?=cn()?>">
                  <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="website-logo" class="website-logo">
                </a>
              </div>
              <h4><?=lang("forgot_password")?></h4>
            </div>
            <p class="text-muted"><?=lang("enter_your_registration_email_address_to_receive_password_reset_instructions")?></p>
            <div class="form-group">
              <div class="input-icon mb-5">
                <span class="input-icon-addon">
                  <i class="fe fe-mail"></i>
                </span>
                <input type="email" class="form-control" name="email" placeholder="<?=lang("Email")?>" required>
              </div>    
            </div>

            <?php
              if (get_option('enable_goolge_recapcha') &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
            ?>
            <div class="form-group">
              <div class="g-recaptcha" data-sitekey="<?=get_option('google_capcha_site_key')?>"></div>
            </div>
            <?php } ?> 
            
            <div class="form-footer">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <button type="submit" class="btn btn-primary btn-block"><?=lang("Submit")?></button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

<?php 
  include_once 'blocks/script.blade.php';
?>


