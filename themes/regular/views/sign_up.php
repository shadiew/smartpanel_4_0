<?php 
  include_once 'blocks/head.blade.php';
?>

<div class="login-bg-image"></div>
<div class="page auth-login-form">
  <div class="container h-100">
    <div class="row">
      <div class="col-md-6 col-login mx-auto auth-form">
        <form class="card actionForm" action="<?=cn("auth/ajax_sign_up")?>" data-redirect="<?=cn('statistics')?>" method="POST">
          <div class="card-body p-t-10">
            <div class="card-title text-center">
              <div class="site-logo mb-3">
                <a href="<?=cn()?>">
                  <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="website-logo" class="website-logo">
                </a>
              </div>
              <h5><?=lang("register_now")?></h5>
            </div>
            <div class="form-group">
              <div class="row">

                <div class="col-md-6">
                  <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                      <i class="fe fe-user"></i>
                    </span>
                    <input type="text" class="form-control" name="first_name" placeholder="<?=lang("first_name")?>"  required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                      <i class="fe fe-user"></i>
                    </span>
                    <input type="text" class="form-control" name="last_name" placeholder="<?=lang("last_name")?>" required>
                  </div>  
                </div>
              </div>

              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <i class="fe fe-mail"></i>
                </span>
                <input type="email" class="form-control" name="email" placeholder="<?=lang("Email")?>" required>
              </div>  
              
              <?php
                if (get_option('enable_signup_skype_field')) {
              ?>
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <i class="fa fa-skype"></i>
                </span>
                <input type="text" class="form-control" name="skype_id" placeholder="<?=lang("Skype_id")?>" required>
              </div>    
              <?php } ?>      
              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <i class="fa fa-key"></i>
                </span>
                <input type="password" class="form-control" name="password" placeholder="<?=lang("Password")?>" required>
              </div>    

              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <i class="fa fa-key"></i>
                </span>
                <input type="password" class="form-control" name="re_password" placeholder="<?=lang("Confirm_password")?>" required>
              </div>

              <div class="input-icon mb-3">
                <span class="input-icon-addon">
                  <i class="fe fe-clock"></i>
                </span>
                <select  name="timezone" class="form-control square">
                  <?php $time_zones = tz_list();
                    if (!empty($time_zones)) {
                      $location = get_location_info_by_ip(get_client_ip());
                      $user_timezone = $location->timezone;
                      if ($user_timezone == "" || $user_timezone == 'Unknow') {
                        $user_timezone = get_option("default_timezone", 'UTC');
                      }
                      foreach ($time_zones as $key => $time_zone) {
                  ?>
                  <option value="<?=$time_zone['zone']?>" <?=($user_timezone == $time_zone["zone"])? 'selected': ''?>><?=$time_zone['time']?></option>
                  <?php }}?>
                </select>
              </div>
            </div>
            
            <?php
              if (get_option('enable_goolge_recapcha') &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
            ?>
            <div class="form-group">
              <div class="g-recaptcha" data-sitekey="<?=get_option('google_capcha_site_key')?>"></div>
            </div>
            <?php } ?> 

            <div class="form-group">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" name="terms" class="custom-control-input" />
                <span class="custom-control-label"><?=lang("i_agree_the")?> <a href="<?=cn('terms')?>"><?=lang("terms__policy")?></a></span>
              </label>
            </div>
            <div class="">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <button type="submit" class="btn btn-primary btn-block"><?=lang("create_new_account")?></button>
            </div>
          </div>
        </form>
        <div class="text-center text-muted">
          <?=lang("already_have_account")?> <a href="<?=cn('auth/login')?>"><?=lang("Login")?></a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
  include_once 'blocks/script.blade.php';
?>


