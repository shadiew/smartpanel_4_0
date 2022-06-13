    <?php if($display_html){?>
    <div class="footer footer_top dark">
      <div class="container m-t-60 m-b-50">
        <div class="row">
          <div class="col-lg-12">
            <div class="site-logo m-b-30">
              <a href="<?=cn()?>" class="m-r-20">
                <img src="<?=get_option('website_logo_white', BASE."assets/images/logo-white.png")?>" alt="Website logo">
              </a>
              <?php
                $redirect = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
              ?>
              <?php 
                if (!empty($languages)) {
              ?>
              <select class="footer-lang-selector ajaxChangeLanguage" name="ids" data-url="<?=cn('language/set_language/')?>" data-redirect="<?=$redirect?>">
                <?php 
                  foreach ($languages as $key => $row) {
                ?>
                <option value="<?=$row->ids?>" <?=(!empty($lang_current) && $lang_current->code == $row->code) ? 'selected' : '' ?> ><?=language_codes($row->code)?></option>
                <?php }?>
              </select>
              <?php }?>
            </div>
          </div>
          <div class="col-lg-8 m-t-30  mt-lg-0">
            <h4 class="title"><?=lang("Quick_links")?></h4>
            <div class="row">
              <div class="col-6 col-md-3  mt-lg-0">
                <ul class="list-unstyled quick-link mb-0">
                  <li><a href="<?=cn()?>"><?=lang("Home")?></a></li>
                  <?php 
                    if (!session('uid')) {
                  ?>
                  <li><a href="<?=cn('auth/login')?>"><?=lang("Login")?></a></li>
                  <li><a href="<?=cn('auth/signup')?>"><?=lang("Sign_Up")?></a></li>
                  <?php }else{?>
                  <li><a href="<?=cn('services')?>"><?=lang("Services")?></a></li>
                  <li><a href="<?=cn('tickets')?>"><?=lang("Tickets")?></a></li>  
                  <?php }?>
                </ul>
              </div>
              <div class="col-6 col-md-3">
                <ul class="list-unstyled quick-link mb-0">
                  <li><a href="<?=cn('terms')?>"><?=lang("terms__conditions")?></a></li>
                  <?php 
                    if (get_option('is_cookie_policy_page')) {
                  ?>
                  <li><a href="<?=cn('cookie-policy')?>"><?=lang("Cookie_Policy")?></a></li>
                  <?php }?>
                  <?php 
                    if (get_option('enable_api_tab')) {
                  ?>
                  <li><a href="<?=cn('api/docs')?>"><?=lang("api_documentation")?></a></li>
                  <?php }?>
                  <li><a href="<?=cn('faq')?>"><?=lang("FAQs")?></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-4 m-t-30 mt-lg-0 subscribe-form">
            <h4 class="title"><?=lang("subscribe_us")?></h4>
            <form class="form actionFormWithoutToast" action="<?php echo cn("client/subscriber"); ?>" data-redirect="<?php echo cn(); ?>" method="POST">
              <div class="form-group">
                <input type="email" name="email" class="form-control email" placeholder="Enter Your email" required>
              </div>
              <button class="form-control btn btn-pill btn-gradient btn-signin btn-submit" type="submit">
                <?php echo lang("subscribe_now"); ?>
              </button>
              <div class="form-group m-t-20">
                <div id="alert-message" class="alert-message-reponse"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer footer_bottom dark">
      <div class="container">
        <div class="row align-items-center flex-row-reverse">
          <div class="col-auto ml-lg-auto">
            <div class="row align-items-center">
              <div class="col-auto">
                <ul class="list-inline mb-0">
                  <?php 
                    if (get_option('social_facebook_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?=get_option('social_facebook_link','')?>" target="_blank" class="btn btn-icon btn-facebook"><i class="fa fa-facebook"></i></a></li>
                  <?php }?>
                  <?php 
                    if (get_option('social_twitter_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?=get_option('social_twitter_link','')?>" target="_blank" class="btn btn-icon btn-twitter"><i class="fa fa-twitter"></i></a></li>
                  <?php }?>
                  <?php 
                    if (get_option('social_instagram_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?=get_option('social_instagram_link','')?>" target="_blank" class="btn btn-icon btn-instagram"><i class="fa fa-instagram"></i></a></li>
                  <?php }?>

                  <?php 
                    if (get_option('social_pinterest_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?=get_option('social_pinterest_link','')?>" target="_blank" class="btn btn-icon btn-pinterest"><i class="fa fa-pinterest"></i></a></li>
                  <?php }?>

                  <?php 
                    if (get_option('social_tumblr_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?=get_option('social_tumblr_link','')?>" target="_blank" class="btn btn-icon btn-vk"><i class="fa fa-tumblr"></i></a></li>
                  <?php }?>

                  <?php 
                    if (get_option('social_youtube_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?=get_option('social_youtube_link','')?>" target="_blank" class="btn btn-icon btn-youtube"><i class="fa fa-youtube"></i></a></li>
                  <?php }?>

                </ul>
              </div>
            </div>
          </div>
          
          <?php
            $version = get_field(PURCHASE, ['pid' => 23595718], 'version');
            $version = 'Ver'.$version;
          ?>
          <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
            <?=get_option('copy_right_content',"Copyright &copy; 2020 - SmartPanel");?> <?=(get_role("admin")) ? $version : "" ?>
          </div>
        </div>
      </div>
    </footer>
    <?php }?>
    
    <script src="<?=BASE?>assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="<?=BASE?>assets/js/vendors/jquery.sparkline.min.js"></script>
    <script src="<?=BASE?>assets/js/core.js"></script>
    <!-- toast -->
    <script type="text/javascript" src="<?=BASE?>assets/plugins/jquery-toast/js/jquery.toast.js"></script>

    <?php
      if (segment(1) != 'auth') {
    ?>
    <script src="<?=BASE?>themes/regular/assets/js/theme.js"></script>
    <?php }?>
    <script src="<?php echo BASE; ?>assets/plugins/aos/dist/aos.js"></script>

    <script>
      AOS.init();
    </script>

    <script src="<?=BASE?>assets/js/process.js"></script>
    <script src="<?=BASE?>assets/js/general.js"></script>
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
