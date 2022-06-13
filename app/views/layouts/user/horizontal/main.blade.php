<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta name="description" content="<?=get_option('website_desc', "SmartPanel - #1 SMM Reseller Panel - Best SMM Panel for Resellers. Also well known for TOP SMM Panel and Cheap SMM Panel for all kind of Social Media Marketing Services. SMM Panel for Facebook, Instagram, YouTube and more services!")?>">
    <meta name="keywords" content="<?=get_option('website_keywords', "smm panel, SmartPanel, smm reseller panel, smm provider panel, reseller panel, instagram panel, resellerpanel, social media reseller panel, smmpanel, panelsmm, smm, panel, socialmedia, instagram reseller panel")?>">
    <title><?=get_option('website_title', "SmartPanel - SMM Panel Reseller Tool")?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?=get_option('website_favicon', BASE."assets/images/favicon.png")?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    
    <script src="<?php echo BASE; ?>assets/js/vendors/jquery-3.2.1.min.js"></script>

    <!-- flag icon -->
    <?php if (segment('1') == 'language') {
    ?>
    <link href="<?php echo BASE; ?>assets/plugins/flags/css/flag-icon.css" rel="stylesheet">
    <?php }?>
    <!-- Core -->
    <link href="<?php echo BASE; ?>assets/css/core.css" rel="stylesheet">
      
    <!-- c3.js Charts Plugin -->
    <?php if(segment('1') == 'statistics'){ ?>
    <link href="<?php echo BASE; ?>assets/plugins/charts-c3/c3.css" rel="stylesheet">
    <script src="<?php echo BASE; ?>assets/plugins/charts-c3/d3.v3.min.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/charts-c3/c3.min.js"></script>
    <?php }?>
    <!-- toast -->
    
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/plugins/jquery-toast/css/jquery.toast.css">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/boostrap/colors.css" id="theme-stylesheet">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" id="theme-stylesheet">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/boostrap-datetimepicket/bootstrap-datetimepicker.min.css" id="theme-stylesheet">
    <!-- <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/datetimepicker/jquery-ui/jquery-ui.min.css" id="theme-stylesheet">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/datetimepicker/jquery-ui-timepicker-addon.min.css" id="theme-stylesheet"> -->
    
    <link href="<?php echo BASE; ?>assets/plugins/emoji-picker/lib/css/emoji.css" rel="stylesheet">
    <link href="<?php echo BASE; ?>assets/css/util.css" rel="stylesheet">
    <link href="<?php echo BASE; ?>assets/css/layout.css" rel="stylesheet">
    <link href="<?php echo BASE; ?>assets/css/footer.css" rel="stylesheet">

    <script type="text/javascript">
      var token = '<?php echo $this->security->get_csrf_hash(); ?>',
          PATH  = '<?php echo PATH; ?>',
          BASE  = '<?php echo BASE; ?>';
    </script>
    <?=htmlspecialchars_decode(get_option('embed_head_javascript', ''), ENT_QUOTES)?>
  </head>
  <?php
    $theme_name = get_option('default_header_skin', 'default');
    if ($theme_name == "") {
      $theme_name = 'default';
    }
  ?>
  <body class="theme-<?php echo $theme_name; ?>">
    <div id="page-overlay" class="visible incoming">
      <div class="loader-wrapper-outer">
        <div class="loader-wrapper-inner">
          <div class="lds-double-ring">
            <div></div>
            <div></div>
            <div>
              <div></div>
            </div>
            <div>
              <div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="page">
      <div class="page-main">
        <!-- header -->
        <?php 
          include_once 'blocks/header.php';
        ?>
        <div class="my-3 my-md-5">
          <div class="container">
            <div class="d-md-none">
              <?php
                if ( allowed_search_bar(segment(1)) || allowed_search_bar(segment(2)) ) {
                  echo Modules::run("blocks/search_box");
                }
              ?>
            </div>

            <?=$template['body']?>
          </div>
        </div>
        
      </div>
      <!-- modal -->
      <div id="modal-ajax" class="modal fade" tabindex="-1"></div>
      <div id="modal-ajax-notification" class="modal fade" tabindex="-1"></div>
    </div>
    <?php 
      include_once 'blocks/footer.php';
    ?>
    
    <script src="<?php echo BASE; ?>assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE; ?>assets/js/vendors/jquery.sparkline.min.js"></script>
    <script src="<?php echo BASE; ?>assets/js/vendors/selectize.min.js"></script>
    <script src="<?php echo BASE; ?>assets/js/vendors/jquery.tablesorter.min.js"></script>
    <script src="<?php echo BASE; ?>assets/js/vendors/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="<?php echo BASE; ?>assets/js/vendors/jquery-jvectormap-de-merc.js"></script>
    <script src="<?php echo BASE; ?>assets/js/vendors/jquery-jvectormap-world-mill.js"></script>
    <script src="<?php echo BASE; ?>assets/js/vendors/circle-progress.min.js"></script>

    <script src="<?php echo BASE; ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    
    <!-- Datetime picker -->
    <script src="<?php echo BASE; ?>assets/plugins/boostrap-datetimepicket/moment.min.js" type="text/javascript"></script>
    <script src="<?php echo BASE; ?>assets/plugins/boostrap-datetimepicket/bootstrap-datetimepicker.min.js"></script>

    <script src="<?php echo BASE; ?>assets/js/core.js"></script>
    <!-- toast -->
    <script type="text/javascript" src="<?php echo BASE; ?>assets/plugins/jquery-toast/js/jquery.toast.js"></script>

    <!-- emoji picker -->
    <script src="<?php echo BASE; ?>assets/plugins/emoji-picker/lib/js/config.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/emoji-picker/lib/js/util.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/emoji-picker/lib/js/jquery.emojiarea.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/emoji-picker/lib/js/emoji-picker.js"></script>
    <!-- flags icon -->
    <script src="<?php echo BASE; ?>assets/plugins/flags/js/docs.js"></script>

    <?php if(segment('1') == 'statistics'){ ?>
    <script src="<?php echo BASE; ?>assets/js/chart_template.js"></script>
    <?php }?>
    
    <!-- general JS -->
    <script src="<?php echo BASE; ?>assets/js/process.js"></script>
    <script src="<?php echo BASE; ?>assets/js/general.js"></script>
    <?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
  </body>
</html>
