<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="Content-Language" content="en">
<meta name="description" content="<?=get_option('website_desc', "SmartPanel - #1 SMM Reseller Panel - Best SMM Panel for Resellers. Also well known for TOP SMM Panel and Cheap SMM Panel for all kind of Social Media Marketing Services. SMM Panel for Facebook, Instagram, YouTube and more services!")?>">
<meta name="keywords" content="<?=get_option('website_keywords', "smm panel, SmartPanel, smm reseller panel, smm provider panel, reseller panel, instagram panel, resellerpanel, social media reseller panel, smmpanel, panelsmm, smm, panel, socialmedia, instagram reseller panel")?>">
<title><?=get_option('website_title', "SmartPanel - SMM Panel Reseller Tool")?></title>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_option('website_favicon', BASE."assets/images/favicon.png"); ?>">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">

<script src="<?php echo BASE; ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/font-awesome/css/font-awesome.min.css">
<?php if(segment('2') == 'settings'){ ?>
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/jquery-upload/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/jquery-upload/css/jquery.fileupload.css">
<?php }?>

<link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/emoji/emojionearea.min.css" media="screen">
<script type="text/javascript" src="<?=BASE?>assets/plugins/emoji/emojionearea.min.js"></script>
 
<!-- c3.js Charts Plugin -->
<?php if(segment('2') == 'statistics'){ ?>
<link href="<?php echo BASE; ?>assets/plugins/charts-c3/c3.css" rel="stylesheet">
<script src="<?php echo BASE; ?>assets/plugins/charts-c3/d3.v3.min.js"></script>
<script src="<?php echo BASE; ?>assets/plugins/charts-c3/c3.min.js"></script>
<?php }?>
<link href="<?php echo BASE; ?>assets/plugins/flags/css/flag-icon.css" rel="stylesheet">
<!-- vendor -->
<link href="<?php echo BASE; ?>assets/admin/vendors/css/vendor.css" rel="stylesheet">
<link href="<?php echo BASE; ?>assets/admin/dist/css/admin-core.css" rel="stylesheet" />
<link href="<?php echo BASE; ?>assets/admin/dist/css/layout.css" rel="stylesheet">
<script type="text/javascript">
    var token = '<?php echo strip_tags($this->security->get_csrf_hash()); ?>',
        PATH  = '<?php echo PATH; ?>',
        BASE  = '<?php echo BASE; ?>';
    var    deleteItem = "<?php echo lang('Are_you_sure_you_want_to_delete_this_item'); ?>";
    var    deleteItems = "<?php echo lang('Are_you_sure_you_want_to_delete_all_items'); ?>";
</script>