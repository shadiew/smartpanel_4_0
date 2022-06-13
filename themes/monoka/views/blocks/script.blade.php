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