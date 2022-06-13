<?php 
  include_once 'blocks/head.blade.php';
?>

<div class="login-bg-image"></div>
<div class="page auth-login-form">
  <div class="container h-100">
    <div class="row h-100 align-items-center auth-form">
      <div class="col-md-5 mx-auto ">
        <form class="card actionForm" action="<?=cn("auth/ajax_sign_in")?>" data-redirect="<?=cn()?>" method="POST">
          <div class="card-body text-center">
            <div class="card-title">
              <div class="site-logo mb-2">
                <a href="<?=cn()?>">
                  <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="website-logo" class="website-logo">
                </a>
              </div>
              
            </div>
            <div class="form-group">
              <h1 class="text-pink"><?=lang('congratulations_your_registration_is_now_complete')?></h1>
              <p><?=lang('congratulations_desc')?></p>
            </div>

            <div class="form-footer">
              <a href="<?=cn("auth/login")?>" class="btn btn-primary round btn-pill"><?=lang("get_start_now")?></a>
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


