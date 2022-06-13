<?php 
  include_once 'blocks/head.blade.php';
?>
<section class="sign-up-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><?=lang("new_password")?></h1>
                <div class="form-container">
                    <form class="actionFormWithoutToast" action="<?=cn("auth/ajax_reset_password/".$reset_key)?>" data-redirect="<?=cn('auth/login')?>" method="POST" id="signUpForm" data-focus="false">

                        <div class="form-group">
                          <input type="password" class="form-control-input" name="password" required>
                          <label class="label-control" for="semail"><?php echo lang("new_password"); ?></label>
                        </div>
                        
                        <div class="form-group">
                          <input type="password" class="form-control-input" name="re_password" required>
                          <label class="label-control" for="semail"><?php echo lang("Confirm_password"); ?></label>
                        </div>

                        <div class="form-group mt-20">
                          <div id="alert-message" class="alert-message-reponse"></div>
                        </div>

                        <div class="form-group">
                          <button type="submit" class="form-control-submit-button btn-submit"><?=lang("Submit")?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
  include_once 'blocks/script.blade.php';
?>


