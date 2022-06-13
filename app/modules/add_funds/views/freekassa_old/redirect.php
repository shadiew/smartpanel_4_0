<div class="dimmer active" style="min-height: 400px;">
  <div class="loader"></div>
  <div class="dimmer-content">
    <center><h2><?php echo lang('please_do_not_refresh_this_page'); ?></h2></center>
    <form method="get" action="<?php echo $action_url ?>" id="redirection_form">
      <?php
      foreach($pm_params as $name => $value) {
        echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
      }
      ?>
      <script type="text/javascript">
        document.getElementById("redirection_form").submit();
      </script>
    </form>
  </div>
</div>
