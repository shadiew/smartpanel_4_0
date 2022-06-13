    
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
