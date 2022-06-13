
<div class="row">
  <div class="col col-login mx-auto">
    <form class="card actionForm" action="<?=cn("maintenance/ajax_get_access")?>" data-redirect="<?=cn()?>" method="POST">
      <div class="card-body p-6">
        <div class="card-title text-center">
          <div class="site-logo mb-2">
            <a href="<?=cn()?>">
              <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="website-logo" style="max-height: 50px;">
            </a>
          </div>
          <h5><?=lang("login_to_maintenace_mode")?></h5>
          <small><?=lang("use_admin_account")?></small>
        </div>
        <div class="form-group">
          <div class="input-icon mb-5">
            <span class="input-icon-addon">
              <i class="fe fe-user"></i>
            </span>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
          </div>    
                
          <div class="input-icon mb-5">
            <span class="input-icon-addon">
              <i class="fa fa-key"></i>
            </span>
            <input type="password" class="form-control" name="password" placeholder="<?=lang("Password")?>"required>
          </div>  
        </div>
        
        <div class="form-footer">
          <button type="submit" class="btn btn-primary btn-block"><?=lang("Login")?></button>
        </div>
      </div>
    </form>
  </div>
</div>
