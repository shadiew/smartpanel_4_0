<?php 
  include_once 'blocks/head.blade.php';
?>

<div class="login-bg-image"></div>
<div class="page auth-login-form">
  <div class="container h-100">
    <div class="row">
      <div class="col-md-6 col-login mx-auto auth-form">
        <form class="card actionForm" action="<?=cn("auth/ajax_reset_password/".$reset_key)?>" data-redirect="<?=cn("auth/login")?>" method="POST">
          <div class="card-body p-t-10">
            <div class="card-title text-center">
              <div class="site-logo mb-2">
                <a href="<?=cn()?>">
                  <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="website-logo" class="website-logo">
                </a>
              </div>
              <h5><?=lang("new_password")?></h5>
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

