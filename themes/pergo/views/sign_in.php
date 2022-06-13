<?php 
  include_once 'blocks/head.blade.php';
?>
<div class="auth-login-form">
  <div class="form-login">
    <form class="actionForm" action="<?=cn("auth/ajax_sign_in")?>" data-redirect="<?=cn('home')?>" method="POST">
      <div>
        <div class="card-title text-center">
          <div class="site-logo">
            <a href="<?=cn()?>">
              <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="website-logo">
            </a>
          </div>
        </div>
        <div class="form-group">
          <?php

            if (isset($_COOKIE["cookie_email"])) {
              $cookie_email = encrypt_decode($_COOKIE["cookie_email"]);
            }

            if (isset($_COOKIE["cookie_pass"])) {
              $cookie_pass = encrypt_decode($_COOKIE["cookie_pass"]);
            }

          ?>
          <div class="input-icon mb-5">
            <span class="input-icon-addon">
              <i class="fe fe-mail"></i>
            </span>
            <input type="email" class="form-control" name="email" placeholder="<?=lang("Email")?>" value="<?=(isset($cookie_email) && $cookie_email != "") ? $cookie_email : ""?>" required>
          </div>    
                
          <div class="input-icon mb-5">
            <span class="input-icon-addon">
              <i class="fa fa-key"></i>
            </span>
            <input type="password" class="form-control" name="password" placeholder="<?=lang("Password")?>" value="<?=(isset($cookie_pass) && $cookie_pass != "") ? $cookie_pass : ""?>" required>
          </div>  

        </div>

        <div class="form-group">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" name="remember" class="custom-control-input" <?=(isset($cookie_email) && $cookie_email != "") ? "checked" : ""?>>
            <span class="custom-control-label"><?=lang("remember_me")?></span>
            <a href="<?=cn("auth/forgot_password")?>" class="float-right small"><?=lang("forgot_password")?></a>
          </label>
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-pill btn-2 btn-block btn-submit btn-gradient"><?=lang("Login")?></button>
        </div>
      </div>
    </form>
    <?php if(!get_option('disable_signup_page')){ ?>
    <div class="text-center text-muted m-t-20">
      <?=lang("dont_have_account_yet")?> <a href="<?=cn('auth/signup')?>"><?=lang("Sign_Up")?></a>
    </div>
    <?php }; ?>
  </div>
</div>

<?php 
  include_once 'blocks/script.blade.php';
?>