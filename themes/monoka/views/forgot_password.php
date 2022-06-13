    <?php 
      include_once 'blocks/head.blade.php';
    ?>
    <section class="sign-up-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                  <h1><?=lang("forgot_password")?></h1>
                  <p class="text-white"><?=lang("enter_your_registration_email_address_to_receive_password_reset_instructions")?></p>
                  <div class="form-container">
                      <form class="actionFormWithoutToast" action="<?=cn("auth/ajax_forgot_password")?>" data-redirect="<?=cn('auth/login')?>" method="POST" id="signUpForm" data-focus="false">
                        <div class="form-group">
                          <input type="email" class="form-control-input" name="email" required>
                          <label class="label-control" for="semail"><?php echo lang("Email"); ?></label>
                        </div>

                        <div class="form-group mt-20">
                            <div id="alert-message" class="alert-message-reponse"></div>
                        </div>

                         <?php
                          if (get_option('enable_goolge_recapcha') &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
                        ?>
                        <div class="form-group">
                          <div class="g-recaptcha" data-sitekey="<?=get_option('google_capcha_site_key')?>"></div>
                        </div>
                        <?php } ?> 

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

