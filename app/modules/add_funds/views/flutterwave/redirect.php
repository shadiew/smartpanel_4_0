<div class="dimmer active" style="min-height: 400px;">
  <div class="loader"></div>
  <div class="dimmer-content">
    <center><h2><?php echo lang('please_do_not_refresh_this_page'); ?></h2></center>
    <form method="POST" action="<?php echo $action_url ?>"  name="f1" id="payment_method_form">
      <input type="hidden" name="public_key" value="<?php echo $paramList['public_key'] ?>" />
      <input type="hidden" name="customer[email]" value="<?php echo $paramList['email'] ?>" />
      <input type="hidden" name="customer[phone_number]" value="<?php echo $paramList['phone'] ?>" />
      <input type="hidden" name="customer[name]" value="<?php echo $paramList['name'] ?>" />
      <input type="hidden" name="tx_ref" value="<?php echo $paramList['tx_ref'] ?>" />
      <input type="hidden" name="amount" value="<?php echo $paramList['amount'] ?>" />
      <input type="hidden" name="currency" value="<?php echo $paramList['currency'] ?>" />
      <input type="hidden" name="meta[token]" value="<?php echo $paramList['meta_token'] ?>" />
      <input type="hidden" name="redirect_url" value="<?php echo $paramList['redirect_url'] ?>" />
      <script type="text/javascript">
        $(function() {
          document.getElementById("payment_method_form").submit();
        });
      </script> 
    </form>
  </div>
</div>
