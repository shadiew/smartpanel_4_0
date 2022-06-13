<div class="dimmer active" style="min-height: 400px;">
  <div class="loader"></div>
  <div class="dimmer-content">
    <center><h2><?php echo lang('please_do_not_refresh_this_page'); ?></h2></center>
    <form method="post" action="https://perfectmoney.is/api/step1.asp" id="redirection_form">
      <input type="hidden" name="PAYMENT_AMOUNT" value="<?=$amount?>">
      <input type="hidden" name="PAYEE_ACCOUNT" value="<?php echo $perfectmoney->PAYEE_ACCOUNT; ?>">
      <input type="hidden" name="PAYEE_NAME" value="<?php echo $perfectmoney->PAYEE_NAME; ?>">
      <input type="hidden" name="PAYMENT_UNITS" value="<?php echo $perfectmoney->PAYMENT_UNITS; ?>">
      <input type="hidden" name="STATUS_URL" value="<?php echo $perfectmoney->STATUS_URL; ?>">
      <input type="hidden" name="PAYMENT_URL" value="<?php echo $perfectmoney->PAYMENT_URL; ?>">
      <input type="hidden" name="NOPAYMENT_URL" value="<?php echo $perfectmoney->NOPAYMENT_URL; ?>">
      <input type="hidden" name="BAGGAGE_FIELDS" value="<?php echo $perfectmoney->BAGGAGE_FIELDS; ?>">
      <input type="hidden" name="ORDER_NUM" value="<?php echo $perfectmoney->ORDER_NUM; ?>">
      <input type="hidden" name="CUST_NUM" value="<?php echo $perfectmoney->CUST_NUM; ?>">
      <input type="hidden" name="PAYMENT_ID" value="<?php echo $perfectmoney->PAYMENT_ID; ?>">
      <input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
      <input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
      <input type="hidden" name="SUGGESTED_MEMO" value="<?php echo $perfectmoney->memo; ?>">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <script type="text/javascript">
        document.getElementById("redirection_form").submit();
      </script>
    </form>
  </div>
</div>
