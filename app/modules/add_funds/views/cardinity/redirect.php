<div class="checkout-left-content">
  <form class="dimmer active" method="POST" action="https://checkout.cardinity.com" id="payment_method_form">  
    <div class="loader"></div>
    <div class="dimmer-content">
    <input type="hidden" name="amount" value="<?php echo $attributes->amount; ?>">
      <input type="hidden" name="cancel_url" value="<?php echo $attributes->cancel_url; ?>">
      <input type="hidden" name="country" value="<?php echo $attributes->country; ?>">
      <input type="hidden" name="currency" value="<?php echo $attributes->currency; ?>">
      <input type="hidden" name="description" value="<?php echo $attributes->description; ?>">
      <input type="hidden" name="order_id" value="<?php echo $attributes->order_id; ?>">
      <input type="hidden" name="project_id" value="<?php echo $attributes->project_id; ?>">
      <input type="hidden" name="return_url" value="<?php echo $attributes->return_url; ?>">
      <input type="hidden" name="signature" value="<?php echo $signature; ?>">
      <input type="hidden" name="<?php echo strip_tags($this->security->get_csrf_token_name());?>" value="<?php echo strip_tags($this->security->get_csrf_hash());?>">
    </div>
    <script type="text/javascript">
      document.getElementById("payment_method_form").submit();
    </script>
  </form>
</div>
