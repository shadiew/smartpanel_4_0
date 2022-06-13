<?php 
  include_once 'blocks/head.blade.php';
?>
<div class="auth-login-form">
  <div class="form-login">
    <form class="actionForm" action="<?=cn("auth/ajax_reset_password/".$reset_key)?>" data-redirect="<?=cn("auth/login")?>" method="POST">
      <div>
        <div class="card-title text-center">
          <div class="site-logo">
            <a href="<?=cn()?>">
              <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="website-logo">
            </a>
          </div>
          <h4><?=lang("new_password")?></h4>
        </div>
        <div class="form-group">
          <div class="input-icon mb-5">
            <span class="input-icon-addon">
              <i class="fa fa-key"></i>
            </span>
            <input type="password" class="form-control" name="password" placeholder="<?=lang("new_password")?>" required>
          </div>    
          <div class="input-icon mb-5">
            <span class="input-icon-addon">
              <i class="fa fa-key"></i>
            </span>
            <input type="password" class="form-control" name="re_password" placeholder="<?=lang("Confirm_password")?>" required>
          </div>
        </div>

        <div class="form-footer">
          <button type="submit" class="btn btn-pill btn-2 btn-block btn-submit btn-gradient"><?=lang("Submit")?></button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php 
  include_once 'blocks/script.blade.php';
?>
