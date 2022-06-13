<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" >
    <meta name="description" content="<?=get_option('website_desc', "SmartPanel - #1 SMM Reseller Panel - Best SMM Panel for Resellers. Also well known for TOP SMM Panel and Cheap SMM Panel for all kind of Social Media Marketing Services. SMM Panel for Facebook, Instagram, YouTube and more services!")?>">
    <meta name="keywords" content="<?=get_option('website_keywords', "smm panel, SmartPanel, smm reseller panel, smm provider panel, reseller panel, instagram panel, resellerpanel, social media reseller panel, smmpanel, panelsmm, smm, panel, socialmedia, instagram reseller panel")?>">
    <title><?=get_option('website_title', "SmartPanel - SMM Panel Reseller Tool")?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?=get_option('website_favicon', BASE."assets/images/favicon.png")?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    
    <script src="<?=BASE?>assets/js/vendors/jquery-3.2.1.min.js"></script>

    <!-- Core -->
    <link href="<?=BASE?>assets/css/core.css" rel="stylesheet">
      
    <!-- toast -->
    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/jquery-toast/css/jquery.toast.css">
    <link rel="stylesheet" href="<?=BASE?>assets/plugins/boostrap/colors.css" id="theme-stylesheet">
    <link href="<?=BASE?>assets/css/util.css" rel="stylesheet">
    <link href="<?=BASE?>assets/css/landing_page.css" rel="stylesheet">
    <link href="<?=BASE?>assets/css/footer.css" rel="stylesheet">

    <script type="text/javascript">
      var token = '<?=$this->security->get_csrf_hash()?>',
          PATH  = '<?=PATH?>',
          BASE  = '<?=BASE?>';
      var    deleteItem = '<?=lang("Are_you_sure_you_want_to_delete_this_item")?>';
      var    deleteItems = '<?=lang("Are_you_sure_you_want_to_delete_all_items")?>';
    </script>

  </head>
  <body class="">
    <div id="particles-js"></div>
    <nav class="header-top navbar navbar-expand-lg navbar-light static-top fixed-top" id="headerNav">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img class="site-logo d-none" src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="Webstie logo">
          <img class="site-logo-white" src="<?=get_option('website_logo_white', BASE."assets/images/logo-white.png")?>" alt="Webstie logo">
        </a>
        <div class="d-flex order-lg-2 ml-auto">
          <ul class="navbar-nav list-inline ml-auto">

            <li class="nav-item list-inline-item">
              <a class="nav-link js-scroll-trigger" href="#home"><?=lang("Home")?></a>
            </li>

            <li class="nav-item list-inline-item">
              <a class="nav-link js-scroll-trigger" href="#features"><?=lang("What_we_offer")?></a>
            </li>

            <?php
              if (get_option("enable_service_list_no_login") == 1) {
            ?>
            <li class="nav-item list-inline-item">
              <a class="nav-link js-scroll-trigger" href="<?=cn("services")?>"><?=lang("Services")?></a>
            </li>
            <?php }?>
            
          </ul>
          <div class="nav-item d-md-flex btn-login">
            <a class="link" href="<?=cn('auth/login')?>"><?=lang("Login")?></a>
            <a href="<?=cn('auth/signup')?>" class="btn btn-pill btn-outline-primary sign-up"><?=lang("Sign_Up")?></a>
          </div>
        </div>
      </div>
    </nav>
    
    <section class="banner"  id="home">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto">
            <div class="content">
              <h1 class="m-b-50 m-t-50">
                <?=lang("resellers_1_destination_for_smm_services")?>
              </h1>
              <div class="desc">
                <?=lang("save_time_managing_your_social_account_in_one_panel_where_people_buy_smm_services_such_as_facebook_ads_management_instagram_youtube_twitter_soundcloud_website_ads_and_many_more")?>
              </div>
              <div class="btn m-t-50">
                <a href="<?=cn('auth/signup')?>" class="btn btn-pill btn-outline-primary sign-up btn-lg"><?=lang("get_start_now")?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  
    <section class="section-1 text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-8 mx-auto">
            <div class="content">
              <div class="title p-b-30">
                <?=lang("best_smm_marketing_services")?>
              </div>
              <div class="desc">
                <?=lang("best_smm_marketing_services_desc")?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>  

    <section class="section-2 text-center" id="features">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mx-auto">
            <div class="content">
              <div class="title">
                <?=lang("What_we_offer")?>
              </div>
              <div class="border-line">
                <hr>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="feature-item">
              <i class="fe fe-calendar text-primary"></i>
              <h3><?=lang("Resellers")?></h3>
              <p class="text-muted"><?=lang("you_can_resell_our_services_and_grow_your_profit_easily_resellers_are_important_part_of_smm_panel")?></p>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="feature-item">
              <i class="fe fe-phone-call text-primary"></i>
              <h3><?=lang("Supports")?></h3>
              <p class="text-muted"><?=lang("technical_support_for_all_our_services_247_to_help_you")?></p>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="feature-item">
              <i class="fe fe-star text-primary"></i>
              <h3><?=lang("high_quality_services")?></h3>
              <p class="text-muted"><?=lang("get_the_best_high_quality_services_and_in_less_time_here")?></p>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="feature-item">
              <i class="fe fe-upload-cloud text-primary"></i>
              <h3><?=lang("Updates")?></h3>
              <p class="text-muted"><?=lang("services_are_updated_daily_in_order_to_be_further_improved_and_to_provide_you_with_best_experience")?></p>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="feature-item">
              <i class="fe fe-share-2 text-primary"></i>
              <h3><?=lang("api_support")?></h3>
              <p class="text-muted"><?=lang("we_have_api_support_for_panel_owners_so_you_can_resell_our_services_easily")?></p>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="feature-item">
              <i class="fe fe-dollar-sign text-primary"></i>
              <h3><?=lang("secure_payments")?></h3>
              <p class="text-muted"><?=lang("we_have_a_popular_methods_as_paypal_and_many_more_can_be_enabled_upon_request")?></p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section class="section-3">
      <div class="container my-auto">
        <div class="row">
          <div class="col-md-10 mx-auto">
            <div class="row">
              <div class="col-md-8 ">
                <div class="content">
                  <h1 class="title"><?=lang("ready_to_start_with_us")?></h1>
                </div>
              </div>
              <div class="col-md-4">
                <a href="<?=cn("auth/signup")?>" class="btn btn-primary btn-pill btn-lg"><?=lang("get_start_now")?></a>
              </div>
            </div>
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

    <?=Modules::run("blocks/footer");?>
    <script src="<?=BASE?>assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="<?=BASE?>assets/js/vendors/jquery.sparkline.min.js"></script>
    <script src="<?=BASE?>assets/js/core.js"></script>
    <script src="<?=BASE?>assets/plugins/particles-js/particles.js"></script>
    <script src="<?=BASE?>assets/plugins/particles-js/app.js"></script>
    <script src="<?=BASE?>assets/plugins/particles-js/stats.js"></script>

    <script src="<?=BASE?>assets/js/landing_page.js"></script>
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
  </body>
</html>

