<div class="dimmer active" style="min-height: 400px;">
  <div class="loader"></div>
  <div class="dimmer-content">
    <center><h2><?php echo lang('please_do_not_refresh_this_page'); ?></h2></center>
    <form method="post" action="<?php echo $payulatam->action_url?>" id="redirection_form">
      <input name="merchantId"    type="hidden"  value="<?=$payulatam->merchantId?>">
      <input name="accountId"     type="hidden"  value="<?=$payulatam->accountId?>" >
      <input name="description"   type="hidden"  value="<?=$payulatam->description?>">
      <input name="referenceCode" type="hidden"  value="<?=$payulatam->referenceCode?>">
      <input name="amount"        type="hidden"  value="<?=$payulatam->amount?>">
      <input name="tax"           type="hidden"  value="<?=$payulatam->tax?>">
      <input name="taxReturnBase" type="hidden"  value="<?=$payulatam->taxReturnBase?>">
      <input name="currency"      type="hidden"  value="<?=$payulatam->currency_code?>">
      <input name="signature"     type="hidden"  value="<?=$payulatam->signature?>">
      <input name="test"          type="hidden"  value="<?=$payulatam->test_mode?>">
      <input name="buyerEmail"    type="hidden"  value="<?=$user->email?>">
      <input name="responseUrl"   type="hidden"  value="<?=$payulatam->response_Url?>" >

      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <script type="text/javascript">
        document.getElementById("redirection_form").submit();
      </script>
    </form>
  </div>
</div>
