
<div class="dimmer active" style="min-height: 300px;">
  <div class="loader"></div>
  <div class="dimmer-content">
    <center><h2><?php echo lang('please_do_not_refresh_this_page'); ?></h2></center>
      <form method="post" action="<?php echo $webmoney->action_url; ?>" id="payment_method_form" accept-charset="utf-8">
      <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php echo $webmoney->LMI_PAYMENT_AMOUNT; ?>">
      <input type="hidden" name="LMI_PAYMENT_DESC" value="<?php echo $webmoney->LMI_PAYMENT_DESC; ?>">
      <input type="hidden" name="LMI_PAYMENT_NO" value="<?php echo $webmoney->LMI_PAYMENT_NO; ?>">
      <input type="hidden" name="LMI_PAYEE_PURSE" value="<?php echo $webmoney->LMI_PAYEE_PURSE; ?>">
      <input type="hidden" name="LMI_SIM_MODE" value="<?php echo $webmoney->LMI_SIM_MODE; ?>">
      <input type="hidden" name="AMOUNT" value="<?php echo $webmoney->LMI_PAYMENT_AMOUNT; ?>">
      <input type="hidden" name="ORDER_ID" value="<?php echo $webmoney->ORDER_ID; ?>">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <script>
        $(function() {
          document.getElementById("payment_method_form").submit();
        });
      </script>
    </form>
  </div>
</div>