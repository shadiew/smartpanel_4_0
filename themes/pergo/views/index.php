    <?php 
      include_once 'blocks/head.blade.php';
    ?>
    <header class="header fixed-top" id="headerNav">
      <div class="container">
        <nav class="navbar navbar-expand-lg ">
          <a class="navbar-brand" href="#">
            <img class="site-logo d-none" src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="Webstie logo">
            <img class="site-logo-white" src="<?=get_option('website_logo_white', BASE."assets/images/logo-white.png")?>" alt="Webstie logo">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span><i class="fe fe-menu"></i></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">

              <li class="nav-item active">
                <a class="nav-link js-scroll-trigger" href="#home"><?=lang("Home")?></a>
              </li>

              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#features"><?=lang("What_we_offer")?></a>
              </li>

              <?php
                if (get_option("enable_service_list_no_login") == 1) {
              ?>
              <li class="nav-item">
                <a class="nav-link" href="<?=cn("services")?>"><?=lang("Services")?></a>
              </li>
              <?php }?>

            </ul> 
            <div class="nav-item d-md-flex btn-login-signup">
              <?php 
                if (!session('uid')) {
              ?>
              <a class="link btn-login" href="<?=cn('auth/login')?>"><?=lang("Login")?></a>
              <?php if(!get_option('disable_signup_page')){ ?>
              <a href="<?=cn('auth/signup')?>" class="btn btn-pill btn-outline-primary sign-up"><?=lang("Sign_Up")?></a>
              <?php }; ?>
              <?php }else{?>
              <a href="<?=cn('statistics')?>" class="btn btn-pill btn-outline-primary btn-statistics text-uppercase"><?=lang("statistics")?></a>
              <?php }?>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <section class="banner"  id="home">
      <div class="container">
        <div class="animatation-box-1">
          <img class="animated icon1" src="<?=BASE?>themes/pergo/assets/images/icon_red_circle.png">
          <img class="animated icon2" src="<?=BASE?>themes/pergo/assets/images/icon_yellow_tri.png">
          <img class="animated icon3" src="<?=BASE?>themes/pergo/assets/images/icon_yellow_circle.png">
        </div>
        <div class="row">
          <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
            <div class="contents">
              <h2 class="head-title">
                <?=lang("get_your_social_accounts_followers_and_likes_at_one_place_instantly")?>
              </h2>
              <p>
                <?=lang("save_time_managing_your_social_account_in_one_panel_where_people_buy_smm_services_such_as_facebook_ads_management_instagram_youtube_twitter_soundcloud_website_ads_and_many_more")?>
              </p>
              <div class="head-button m-t-40">
                <a href="<?=cn('auth/signup')?>" class="btn btn-pill btn-outline-primary sign-up btn-lg"><?=lang("get_start_now")?></a>
              </div>
            </div>
          </div>          
          <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 box-image">
            <div class="animation-2">
              <img class="intro-img" src="<?=BASE?>themes/pergo/assets/images/girl_and_desk.png" alt="girl-laptop">
              <img class="animated icon-1" src="<?=BASE?>themes/pergo/assets/images/icon_emoji_smile.png" alt="Emoji Smile">
              <img class="animated icon-2" src="<?=BASE?>themes/pergo/assets/images/icon_white_like.png" alt="Like icon">
              <img class="animated icon-3" src="<?=BASE?>themes/pergo/assets/images/icon_red_heart.png" alt="Red Heart Fill">
              <img class="animated icon-4" src="<?=BASE?>themes/pergo/assets/images/purple-like.png" alt="Like Icon">
              <img class="animated icon-5" src="<?=BASE?>themes/pergo/assets/images/icon_instagram.png" alt="Instagram icon">
              <img class="animated icon-6" src="<?=BASE?>themes/pergo/assets/images/icon_facebook_circle.png" alt="Facebook Icon">
              <img class="animated icon-7" src="<?=BASE?>themes/pergo/assets/images/icon_twitter.png" alt="Twitter">
              <img class="animated icon-10" src="<?=BASE?>themes/pergo/assets/images/icon_white_heart.png" alt="White Heart Unfill">
              <img class="animated icon-tree" src="<?=BASE?>themes/pergo/assets/images/tree.png" alt="tree">

            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="core-services">
    </section>

    <section class="about-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12" data-aos="fade-left" data-aos-easing="ease-in" data-aos-delay="200">
            <div class="intro-img">
              <img class="img-fluid" src="<?=BASE?>themes/pergo/assets/images/best_service.png" alt="">
            </div>
          </div>

          <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12" data-aos="fade-right" data-aos-easing="ease-in" data-aos-delay="200">
            <div class="contents">
              <h2 class="head-title">
                <?=lang("best_smm_marketing_services")?>
              </h2>
              <p>
                <?=lang("best_smm_marketing_services_desc")?>
              </p>
              <div class="head-button">
                <a href="<?=cn('auth/signup')?>" class="btn btn-pill btn-signin btn-gradient btn-lg"><?=lang("get_start_now")?></a>
              </div>
            </div>
          </div>          
        </div>
      </div>
    </section>

    <section class="our-services text-center" id="features">
      <div class="container">
        <div class="row" >
          <div class="col-md-12 mx-auto" data-aos="fade-down" data-aos-easing="ease-in" data-aos-delay="200">
            <div class="contents">
              <div class="head-title">
                <?=lang("What_we_offer")?>
              </div>
              <div class="border-line">
                <hr>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-right" data-aos-easing="ease-in" data-aos-delay="400">
            <div class="feature-item">
              <div class="animation-box">
                <i class="fe fe-calendar icon"></i>
              </div>
              <h3><?=lang("Resellers")?></h3>
              <p class="text-muted"><?=lang("you_can_resell_our_services_and_grow_your_profit_easily_resellers_are_important_part_of_smm_panel")?>
              </p>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-right" data-aos-easing="ease-in" data-aos-delay="600">
            <div class="feature-item">
              <div class="animation-box">
                <i class="fe fe-phone-call icon"></i>
              </div>
              <h3><?=lang("Supports")?></h3>
              <p class="text-muted"><?=lang("technical_support_for_all_our_services_247_to_help_you")?></p>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-right" data-aos-easing="ease-in" data-aos-delay="800">
            <div class="feature-item">
              <div class="animation-box">
                <i class="fe fe-star icon"></i>
              </div>
              
              <h3><?=lang("high_quality_services")?></h3>
              <p class="text-muted"><?=lang("get_the_best_high_quality_services_and_in_less_time_here")?></p>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-right" data-aos-easing="ease-in" data-aos-delay="1000">
            <div class="feature-item">
              <div class="animation-box">
                <i class="fe fe-upload-cloud icon"></i>
              </div>
              <h3><?=lang("Updates")?></h3>
              <p class="text-muted"><?=lang("services_are_updated_daily_in_order_to_be_further_improved_and_to_provide_you_with_best_experience")?></p>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-right" data-aos-easing="ease-in" data-aos-delay="1200">
            <div class="feature-item">
              <div class="animation-box">
                <i class="fe fe-share-2 icon"></i>
              </div>
              <h3><?=lang("api_support")?></h3>
              <p class="text-muted"><?=lang("we_have_api_support_for_panel_owners_so_you_can_resell_our_services_easily")?></p>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-right" data-aos-easing="ease-in" data-aos-delay="1400">
            <div class="feature-item">
              <div class="animation-box">
                <i class="fe fe-dollar-sign icon"></i>
              </div>
              <h3><?=lang("secure_payments")?></h3>
              <p class="text-muted"><?=lang("we_have_a_popular_methods_as_paypal_and_many_more_can_be_enabled_upon_request")?></p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section class="reviews text-center">
      <div class="container">
        <div class="row " data-aos="fade-down" data-aos-easing="ease-in" data-aos-delay="200">
          <div class="col-md-12 mx-auto">
            <div class="contents">
              <div class="head-title">
                <?=lang("what_people_say_about_us")?>
              </div>
              <span class="text-muted"><?=lang("our_service_has_an_extensive_customer_roster_built_on_years_worth_of_trust_read_what_our_buyers_think_about_our_range_of_service")?></span>
              <div class="border-line">
                <hr>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card item">
              <div class="person-info">
                <h3 class="name"><?=lang("client_one")?></h3>
                <span class="text-muted"><?=lang("client_one_jobname")?></span>
              </div>
              <div class="card-body">
                <p class="desc">
                  <?=lang('client_one_comment')?>
                </p>
                <div class="star-icon">
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card item">
              <div class="person-info">
                <h3 class="name"><?=lang('client_two')?></h3>
                <span class="text-muted"><?=lang('client_two_jobname')?></span>
              </div>
              <div class="card-body">
                <p class="desc">
                  <?=lang('client_two_comment')?>
                </p>
                <div class="star-icon">
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                </div>
              </div>
            </div>
          </div>          
          <div class="col-md-4">
            <div class="card item">
              <div class="person-info">
                <h3 class="name"><?=lang('client_three')?></h3>
                <span class="text-muted"><?=lang('client_three_jobname')?></span>
              </div>
              <div class="card-body">
                <p class="desc">
                  <?=lang('client_three_comment')?>
                  
                </p>
                <div class="star-icon">
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section class="section-3 subscribe-form">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <form class="form actionFormWithoutToast" action="<?php echo cn("client/subscriber"); ?>" data-redirect="<?php echo cn(); ?>" method="POST">
              <div class="content text-center">
                <h1 class="title"><?php echo lang("newsletter"); ?></h1>
                <p><?php echo lang("fill_in_the_ridiculously_small_form_below_to_receive_our_ridiculously_cool_newsletter"); ?></p>
              </div>
              <div class="input-group">
                <input type="email" name="email" class="form-control email" placeholder="Enter Your email" required>
                <button class="input-group-append btn btn-pill btn-gradient btn-signin btn-submit" type="submit">
                  <?php echo lang("subscribe_now"); ?>
                </button>
              </div>
              <div class="form-group m-t-20">
                <div id="alert-message" class="alert-message-reponse"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

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
              <select class="footer-lang-selector ajaxChangeLanguage" name="ids" data-url="<?=cn('set-language')?>" data-redirect="<?=$redirect?>">
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
          <div class="col-lg-4 m-t-30 mt-lg-0">
            <h4 class="title"><?=lang("contact_informations")?></h4>
            <ul class="list-unstyled">
              <li><?=lang("Tel")?>: <?=get_option('contact_tel',"+12345678")?> </li>
              <li><?=lang("Email")?>: <?=get_option('contact_email',"do-not-reply@smartpanel.com")?> </li>
              <li><?=lang("working_hour")?>: <?=get_option('contact_work_hour',"Mon - Sat 09 am - 10 pm")?> </li>
            </ul>
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
            <?=get_option('copy_right_content',"Copyright &copy; 2020 - SmartPanel"); ?> <?=(get_role("admin")) ? $version : "" ?>
          </div>
        </div>
      </div>
    </footer>

    <?php 
      include_once 'blocks/script.blade.php';
    ?>