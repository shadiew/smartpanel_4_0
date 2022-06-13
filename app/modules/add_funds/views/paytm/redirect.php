<div class="dimmer active" style="min-height: 400px;">
  <div class="loader"></div>
  <div class="dimmer-content">
    <center><h2><?php echo lang('please_do_not_refresh_this_page'); ?></h2></center>
    <form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1" id="payment_method_form">
      <?php
      foreach($paramList as $name => $value) {
        echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
      }
      ?>
      <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
      <script type="text/javascript">
        $(function() {
          document.getElementById("payment_method_form").submit();
        });
      </script>
    </form>
  </div>
</div>
