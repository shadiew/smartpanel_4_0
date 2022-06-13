
<div class="row h-100 align-items-center auth-form">
  <div class="col-md-6 col-login mx-auto ">
    <form class="card actionForm" action="<?=cn("auth/ajax_sign_in")?>" data-redirect="<?=cn('statistics')?>" method="POST">
      <div class="card-body ">
        <div class="card-title text-center">
          <div class="site-logo mb-2">
            <a href="<?=cn()?>">
              <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="website-logo" style="max-height: 50px;">
            </a>
          </div>
          <h5><?=lang("login_to_your_account")?></h5>
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
          <button type="submit" class="btn btn-primary btn-block"><?=lang("Login")?></button>
        </div>
      </div>
    </form>
    <div class="text-center text-muted">
      <?=lang("dont_have_account_yet")?> <a href="<?=cn('auth/signup')?>"><?=lang("Sign_Up")?></a>
    </div>
  </div>
</div>
