    <?php if($display_html){?>
    
    
    <style>
        .footer-lang-selector{
            min-width: 130px;
        }
    </style>

    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-col first">
                        <h4><?php echo get_option('website_name'); ?></h4>
                        <p class="p-small"><?php echo lang("all_user_information_is_kept_100_private_and_will_not_be_shared_with_anyone_always_remember_you_are_protected_with_our_panel__most_trusted_smm_panel"); ?></p>

                        <?php
                            $redirect = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        ?>
                        <?php 
                            if (!empty($languages)) {
                        ?>
                        <select class="form-custom footer-lang-selector ajaxChangeLanguage" name="ids" data-url="<?=cn('language/set_language/')?>" data-redirect="<?php echo $redirect; ?>">
                            <?php 
                              foreach ($languages as $key => $row) {
                            ?>
                            <option value="<?=$row->ids?>" <?=(!empty($lang_current) && $lang_current->code == $row->code) ? 'selected' : '' ?> ><?=language_codes($row->code)?></option>
                            <?php }?>
                        </select>
                        <?php }?>
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="footer-col middle">
                        <h4><?=lang("Quick_links")?></h4>
                        <ul class="list-unstyled li-space-lg p-small">
                            <?php 
                                if (!session('uid')) {
                            ?>
                            <li class="media">
                                <i class="fas fa-chevron-right"></i>
                                <div class="media-body"> <a class="white" href="<?php echo cn()?>"><?php echo lang("Login"); ?></a></div>
                            </li>
                            <li class="media">
                                <i class="fas fa-chevron-right"></i>
                                <div class="media-body"> <a class="white" href="<?php echo cn('auth/signup'); ?>"><?php echo lang("Sign_Up"); ?></a></div>
                            </li>
                            <?php }?>
                            
                        </ul>
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="footer-col last">
                        <h4>&nbsp;</h4>
                        <ul class="list-unstyled li-space-lg p-small">
                            
                            <li class="media">
                                <i class="fas fa-chevron-right"></i>
                                <div class="media-body"> <a class="white" href="<?php echo cn('terms'); ?>"><?php echo lang("terms__conditions"); ?></a></div>
                            </li>
                            
                            <li class="media">
                                <i class="fas fa-chevron-right"></i>
                                <div class="media-body"> <a class="white" href="<?php echo cn('faq'); ?>"><?php echo lang("FAQs"); ?></a></div>
                            </li>
                            
                            <?php 
                                if (get_option('enable_api_tab')) {
                            ?>
                            <li class="media">
                                <i class="fas fa-chevron-right"></i>
                                <div class="media-body"> <a class="white" href="<?php echo cn('api/docs')?>"><?php echo lang("api_documentation"); ?></a></div>
                            </li>
                            <?php }?>
                            
                        </ul>
                        
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <footer class="footer copyright">
      <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="icon-container">
                        <?php 
                        if (get_option('social_facebook_link')) {
                        ?>
                        <span class="social-icon">
                            <a href="<?php echo get_option('social_facebook_link'); ?>">
                                <i class="fab fa-facebook-square"></i>
                            </a>
                        </span>
                        <?php }?>

                        <?php 
                        if (get_option('social_twitter_link')) {
                        ?>
                        <span class="social-icon">
                            <a href="<?php echo get_option('social_twitter_link'); ?>">
                                <i class="fab fa-twitter-square"></i>
                            </a>
                        </span>
                        <?php }?>

                        <?php 
                        if (get_option('social_pinterest_link')) {
                        ?>
                        <span class="social-icon">
                            <a href="<?php echo get_option('social_pinterest_link'); ?>">
                                <i class="fab fa-pinterest-square"></i>
                            </a>
                        </span>
                        <?php }?> 

                        <?php 
                            if (get_option('social_instagram_link')) {
                        ?>
                        <span class="social-icon">
                            <a href="<?php echo get_option('social_instagram_link'); ?>">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </span>
                        <?php }?>

                        <?php 
                            if (get_option('social_youtube_link')) {
                        ?>
                        <span class="social-icon">
                            <a href="<?php echo get_option('social_youtube_link'); ?>">
                                <i class="fab fa-youtube-square"></i>
                            </a>
                        </span>
                        <?php }?>
                    </div>
                  </div>
                </div>
            </div>
            <?php
                $version = get_field(PURCHASE, ['pid' => 23595718], 'version');
                $version = 'Ver'.$version;
            ?>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center small">
                <?=get_option('copy_right_content',"Copyright &copy; 2020 - SmartPanel");?> <?=(get_role("admin")) ? $version : "" ?> 
            </div>
        </div>
      </div>
    </footer>

    <div class="modal-infor">
      <div class="modal" id="notification">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title"><i class="fe fe-bell"></i> <?=lang("Notification")?></h4>
              <button type="button" class="close" data-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <?=get_option('notification_popup_content')?>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><?=lang("Close")?></button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php } ?>
   
    <script type="text/javascript" src="<?php echo BASE; ?>assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE; ?>assets/js/vendors/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE; ?>assets/js/core.js"></script>
    <script type="text/javascript" src="<?php echo BASE; ?>themes/monoka/assets/js/swiper.min.js"></script> 
    <script type="text/javascript" src="<?php echo BASE; ?>themes/monoka/assets/js/monoka.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/aos/dist/aos.js"></script>

    <script>
      AOS.init();
    </script>

    <!-- Script js -->
    <script src="<?php echo BASE; ?>assets/js/process.js"></script>
    <script src="<?php echo BASE; ?>assets/js/general.js"></script>
    <?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
    <script>
      $(document).ready(function(){
        var is_notification_popup = "<?=get_option('enable_notification_popup', 0)?>"
        setTimeout(function(){
            if (is_notification_popup == 1) {
              $("#notification").modal('show');
            }else{
              $("#notification").modal('hide');
            }
        },500);
     });
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>