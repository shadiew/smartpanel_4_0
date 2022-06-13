<?php 
  include_once 'blocks/head.blade.php';
?>

<style>
  .auth-login-form .form-login {
    width: 620px;
  }
</style>

<div class="auth-login-form">
  <div class="form-login">
    <div>
      <div class="card-title text-center">
        <div class="site-logo">
          <a href="<?=cn()?>">
            <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="website-logo">
          </a>
        </div>
      </div>
      <div class="form-group text-center">
        <h1 class="text-pink"><?=lang('congratulations_your_registration_is_now_complete')?></h1>
        <p><?=lang('congratulations_desc')?></p>
      </div>

      <div class="form-footer">
        <a href="<?=cn("auth/login")?>" class="btn btn-pill btn-2 btn-block btn-submit btn-gradient"><?=lang("get_start_now")?></a>
      </div>
    </div>
  </div>
</div>

<?php 
  include_once 'blocks/script.blade.php';
?>