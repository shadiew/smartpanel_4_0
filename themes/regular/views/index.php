    <?php 
      include_once 'blocks/head.blade.php';
    ?>

    <header class="header fixed-top" id="headerNav">
      <div class="container">
        <nav class="navbar navbar-expand-lg ">
          <a class="navbar-brand" href="<?=cn()?>">
            <img class="site-logo d-none" src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="Webstie logo">
            <img class="site-logo-white" src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="Webstie logo">
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

    <section id="home" class="header-top mheader">
      <div class="intro_wrapper">
          <div class="container">  
              <div class="row">        
                  <div class="col-sm-12 col-md-12 col-lg-6">
                      <div class="intro_text">
                          <h1 class=""><?=lang("resellers_1_destination_for_smm_services")?></h1>
                          <p class=""><?=lang("save_time_managing_your_social_account_in_one_panel_where_people_buy_smm_services_such_as_facebook_ads_management_instagram_youtube_twitter_soundcloud_website_ads_and_many_more")?></p>
                          <?php
                            if (session('uid')) {
                          ?>
                          <div class="btn">
                            <a href="<?=cn('auth/signup')?>" class="btn btn-pill btn-gradient btn-signin btn-submit btn-lg"><?=lang("get_start_now")?></a>
                          </div>
                          <?php }?>
                      </div>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-duration="500">
                    <div class="intro_banner">
                       <img src="<?php echo BASE; ?>themes/regular/assets/images/header-top.png" alt="About us">
                    </div>
                  </div>
              </div>
          </div> 
      </div>  
    </section>

    <section id="services" class="services">
      <div class="container">
          <div class="row justify-content-center m-b-20">
            <div class="col-lg-10">
              <div class="section-title text-center">
                <div class="line m-auto"></div>
                <h3 class="title"><?php echo lang("reasons_why_you_should_try_our_panel"); ?> <span> <?php echo lang("let_us_help_you_build_your_online_presence_quickly_and_efficiently"); ?></span></h3>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
              <div class="col-lg-4 col-md-7 col-sm-8" data-aos="fade-up" data-aos-duration="500">
                  <div class="sigle-service text-center m-t-30 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeIn;">
                      <div class="services-icon">
                        <img class="shape" src="<?php echo BASE; ?>themes/regular/assets/images/services-shape.svg" alt="shape" />
                        <img class="shape-1" src="<?php echo BASE; ?>themes/regular/assets/images/services-shape-1.svg" alt="shape" />
                        <i class="fe fe-award"></i>
                      </div>
                      <div class="services-content m-t-30">
                        <h4 class="services-title"><?php echo lang("best_quality"); ?></h4>
                        <p class="text"><?php echo lang("the_highest_quality_smm_services_to_meet_your_needs"); ?></p>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4 col-md-7 col-sm-8" data-aos="fade-up" data-aos-duration="1000">
                  <div class="sigle-service text-center m-t-30">
                      <div class="services-icon">
                        <img class="shape" src="<?php echo BASE; ?>themes/regular/assets/images/services-shape.svg" alt="shape" />
                        <img class="shape-1" src="<?php echo BASE; ?>themes/regular/assets/images/services-shape-2.svg" alt="shape" />
                        <i class="fe fe-truck"></i>
                      </div>
                      <div class="services-content m-t-30">
                        <h4 class="services-title"><?php echo lang("diverse_payment_options"); ?></h4>
                        <p class="text"><?php echo lang("we_have_a_good_amount_of_different_payment_options"); ?></p>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4 col-md-7 col-sm-8" data-aos="fade-up" data-aos-duration="1500">
                  <div class="sigle-service text-center m-t-30">
                      <div class="services-icon">
                        <img class="shape" src="<?php echo BASE; ?>themes/regular/assets/images/services-shape.svg" alt="shape" />
                        <img class="shape-1" src="<?php echo BASE; ?>themes/regular/assets/images/services-shape-3.svg" alt="shape" />
                        <i class="fe fe-clock"></i>
                      </div>
                      <div class="services-content m-t-30">
                        <h4 class="services-title"><?php echo lang("super_quick_delivery"); ?></h4>
                        <p class="text"><?php echo lang("we_provide_automated_services_with_quick_delivery"); ?></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </section>

    <section class="social-icon-area pt-90" data-aos="fade-up" data-aos-duration="1000">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="brand-logo d-flex align-items-center justify-content-center justify-content-md-between">
              <div class="single-logo m-t-30" data-aos="zoom-in" data-aos-duration="1500">
                <img src="<?php echo BASE; ?>themes/regular/assets/images/fb.png" alt="FB" />
              </div>
              <div class="single-logo m-t-30" data-aos="zoom-in" data-aos-duration="1500">
                <img src="<?php echo BASE; ?>themes/regular/assets/images/ig.png" alt="IG" />
              </div>
              <div class="single-logo m-t-30" data-aos="zoom-in" data-aos-duration="1500">
                <img src="<?php echo BASE; ?>themes/regular/assets/images/yt.png" alt="YT" />
              </div>
              <div class="single-logo m-t-30" data-aos="zoom-in" data-aos-duration="1500">
                <img src="<?php echo BASE; ?>themes/regular/assets/images/tw.png" alt="TW" />
              </div>
              <div class="single-logo m-t-30" data-aos="zoom-in" data-aos-duration="1500">
                <img src="<?php echo BASE; ?>themes/regular/assets/images/sc.png" alt="SC" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="features" class="our-features" data-aos="fade-up" data-aos-duration="300">
      <div class="container custom-container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <div class="section-title pb-20">
              <h1><?php echo lang("What_we_offer"); ?></h1>
              <p><?php echo lang("comes_with_all_the_essential_features_and_elements_you_need_here_are_the_key_features_of_our_services_you_must_know"); ?></p>
            </div>
          </div>
        </div>
        <div class="row features-wrapper">
            <div class="col-lg-4 col-sm-6 features-col" data-aos="fade-up" data-aos-duration="1000">
              <div class="feature-content m-t-30 m-b-30">
                <div class="features-icon">
                  <i class="fe fe-calendar"></i>
                </div>
                <div class="features-content">
                  <h3><?=lang("Resellers")?></h3>
                  <p class="text-muted"><?=lang("you_can_resell_our_services_and_grow_your_profit_easily_resellers_are_important_part_of_smm_panel")?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6 features-col" data-aos="fade-up" data-aos-duration="1000">
              <div class="feature-content m-t-30 m-b-30">
                <div class="features-icon">
                  <i class="fe fe-phone-call"></i>
                </div>
                <div class="features-content">
                  <h3><?=lang("Supports")?></h3>
                  <p class="text-muted"><?=lang("technical_support_for_all_our_services_247_to_help_you")?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6 features-col" data-aos="fade-up" data-aos-duration="1000">
              <div class="feature-content m-t-30 m-b-30">
                <div class="features-icon">
                  <i class="fe fe-star"></i>
                </div>
                <div class="features-content">
                  <h3><?=lang("high_quality_services")?></h3>
                  <p class="text-muted"><?=lang("get_the_best_high_quality_services_and_in_less_time_here")?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6 features-col" data-aos="fade-up" data-aos-duration="1000">
              <div class="feature-content m-t-30 m-b-30">
                <div class="features-icon">
                  <i class="fe fe-upload-cloud"></i>
                </div>
                <div class="features-content">
                  <h3><?=lang("Updates")?></h3>
                  <p class="text-muted"><?=lang("services_are_updated_daily_in_order_to_be_further_improved_and_to_provide_you_with_best_experience")?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6 features-col" data-aos="fade-up" data-aos-duration="1000">
              <div class="feature-content m-t-30 m-b-30">
                <div class="features-icon">
                  <i class="fe fe-share-2"></i>
                </div>
                <div class="features-content">
                  <h3><?=lang("api_support")?></h3>
                  <p class="text-muted"><?=lang("we_have_api_support_for_panel_owners_so_you_can_resell_our_services_easily")?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6 features-col" data-aos="fade-up" data-aos-duration="1000">
              <div class="feature-content m-t-30 m-b-30">
                <div class="features-icon">
                  <i class="fe fe-dollar-sign"></i>
                </div>
                <div class="features-content">
                  <h3><?=lang("secure_payments")?></h3>
                  <p class="text-muted"><?=lang("we_have_a_popular_methods_as_paypal_and_many_more_can_be_enabled_upon_request")?></p>
                </div>
              </div>
            </div>
        </div>
      </div>
    </section>

    <section class="section-1">
      <div class="container">
        <div class="row">
          <div class="col-md-6 p-t-60" data-aos="zoom-in-right" data-aos-duration="1000">
            <div class="content">
              <div class="title p-b-20">
                <?=lang("best_smm_marketing_services")?>
              </div>
              <div class="desc">
                <?=lang("best_smm_marketing_services_desc")?>
              </div>
            </div>
          </div>
          <div class="col-md-6"  data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="intro-img">
              <img class="img-fluid" src="<?=BASE?>themes/regular/assets/images/about.png" alt="About us">
            </div>
          </div>
        </div>
      </div>
    </section> 

    <section class="how-it-works">
      <div class="container">
        <div class="row text-center" data-aos="fade-up" data-aos-delay="700">
          <div class="col-md-12 mx-auto">
            <div class="header-top">
              <div class="title">
                <?php echo lang("how_it_works"); ?>
              </div>
              <span class=""><?php echo lang("by_following_the_processes_below_you_can_make_any_order_you_want"); ?> </span>
            </div>
            <div class="col-md-12">
              <div class="row step-lists">

                <div class="col-sm-6 col-lg-3 step text-left">
                  <div class="header-name">
                    <h3><?php echo lang("register_and_log_in"); ?></h3>
                    <p class="desc"><?php echo lang("creating_an_account_is_the_first_step_then_you_need_to_log_in"); ?></p>
                  </div>
                  <div class="bg-number">1</div>
                </div>

                <div class="col-sm-6 col-lg-3 step text-left">
                  <div class="header-name">
                    <h3><?php echo lang("add_funds"); ?></h3>
                    <p class="desc"><?php echo lang("next_pick_a_payment_method_and_add_funds_to_your_account"); ?></p>
                  </div>
                  <div class="bg-number">2</div>
                </div>

                <div class="col-sm-6 col-lg-3 step text-left">
                  <div class="header-name">
                    <h3><?php echo lang("select_a_service"); ?></h3>
                    <p class="desc"><?php echo lang("select_the_services_you_want_and_get_ready_to_receive_more_publicity"); ?></p>
                  </div>
                  <div class="bg-number">3</div>
                </div>

                <div class="col-sm-6 col-lg-3 step text-left">
                  <div class="header-name">
                    <h3><?php echo lang("enjoy_superb_results"); ?></h3>
                    <p class="desc"><?php echo lang("you_can_enjoy_incredible_results_when_your_order_is_complete"); ?></p>
                  </div>
                  <div class="bg-number">4</div>
                </div>

              </div>
            </div>
          </div>
        </div>

        <!-- FAQ -->
        <div class="row package-faq" data-aos="fade-up" data-aos-delay="1000">
          <div class="col-md-12">
            <div class="header-top text-center">
              <div class="title">
                F.A.Q
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="item">
                  <div class="title">
                    <i class="fe fe-plus plus-icon"></i>
                    <h5><?php echo lang("smm_panels__what_are_they"); ?></h5>
                  </div>
                  <div class="body"><?php echo lang("an_smm_panel_is_an_online_shop_that_you_can_visit_to_puchase_smm_services_at_great_prices"); ?>
                  </div>
                </div>

                <div class="item">
                  <div class="title">
                    <i class="fe fe-plus plus-icon"></i>
                    <h5><?php echo lang("what_smm_services_can_i_find_on_this_panel"); ?></h5>
                  </div>
                  <div class="body"><?php echo lang("we_sell_different_types_of_smm_services__likes_followers_views_etc"); ?>
                  </div>
                </div>

                <div class="item">
                  <div class="title">
                    <i class="fe fe-plus plus-icon"></i>
                    <h5><?php echo lang("are_smm_services_on_your_panel_safe_to_buy"); ?></h5>
                  </div>
                  <div class="body"><?php echo lang("sure_your_accounts_wont_get_banned"); ?>
                  </div>
                </div>

              </div>

              <div class="col-md-6">
                <div class="item">
                  <div class="title">
                    <i class="fe fe-plus plus-icon"></i>
                    <h5><?php echo lang("how_does_a_mass_order_work"); ?></h5>
                  </div>
                  <div class="body"><?php echo lang("its_possible_to_place_multiple_orders_with_different_links_at_once_with_the_help_of_the_mass_order_feature"); ?> </div>
                </div>

                <div class="item">
                  <div class="title">
                    <i class="fe fe-plus plus-icon"></i>
                    <h5><?php echo lang("what_does_dripfeed_mean"); ?></h5>
                  </div>
                  <div class="body"><?php echo lang("grow_your_accounts_as_fast_as_you_want_with_the_help_of_dripfeed_how_it_works_lets_say_you_want_2000_likes_on_your_post_instead_of_getting_all_2000_at_once_you_can_get_200_each_day_for_10_days"); ?></div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </section>

    <script>
      $(document).ready(function(){
        $(".package-faq .item").click(function(){
          $(this).toggleClass("active");
        });
      });
    </script>

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

    <?php 
      include_once 'blocks/script.blade.php';
    ?>
    