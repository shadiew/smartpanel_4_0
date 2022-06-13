<?php
  $option                 = get_value($payment_params, 'option');
  $min_amount             = get_value($payment_params, 'min');
  $max_amount             = get_value($payment_params, 'max');
  $type                   = get_value($payment_params, 'type');
  $tnx_fee                = get_value($option, 'tnx_fee');
  $currency_rate_to_usd   = get_value($option, 'rate_to_usd');
?>
<div class="add-funds-form-content">
  <form class="form actionAddFundsForm" action method="POST">
    <div class="row">
      <div class="col-md-12">
        
        <div class="for-group text-center">
            <img src="<?=BASE?>/assets/images/payments/shopier.png" style="max-width: 250px;" alt="Shopier icon">
            <div class="form-group text-center p-t-10">
                <img src="<?php echo BASE; ?>assets/images/payments/visa.jpg" id="visa">
                <img src="<?php echo BASE; ?>assets/images/payments/mastercard.jpg" id="mastercard">
                <img src="<?php echo BASE; ?>assets/images/payments/amex.jpg" id="amex">
            </div>
            <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Shopier')?></small></p>
        </div>
        
        <div class="form-group">
          <label><?=sprintf(lang("amount_usd"), 'TL')?></label>
          <input class="form-control square" type="number" name="amount" placeholder="<?php echo $min_amount; ?>">
        </div>
        
        <div class="form-group">
            <label class="form-label"><?php echo lang('first_name'); ?> <span class="form-required">*</span></label>
            <input type="text" name="buyer[first_name]" value="<?php echo $_SESSION['user_current_info']['first_name']; ?>" class="form-control" required="true">
        </div>

        <div class="form-group">
            <label class="form-label"><?php echo lang('last_name'); ?> <span class="form-required">*</span></label>
            <input type="text" name="buyer[last_name]" class="form-control" value="<?php echo $_SESSION['user_current_info']['last_name']; ?>" required="true">
        </div>

        <div class="form-group">
            <label class="form-label"><?php echo lang('phone'); ?> <span class="form-required">*</span></label>
            <input type="text" name="buyer[phone]" class="form-control" required="true">
        </div>

        <div class="form-group">
          <label><?php echo lang("note"); ?></label>
          <ul>
            <?php
              if ($tnx_fee > 0) {
            ?>
            <li><?=lang("transaction_fee")?>: <strong><?php echo $tnx_fee; ?>%</strong></li>
            <?php } ?>
            <li><?=lang("Minimal_payment")?>: <strong><?php echo $currency_symbol.$min_amount; ?></strong></li>
            <?php
              if ($max_amount > 0) {
            ?>
            <li><?=lang("Maximal_payment")?>: <strong><?php echo $currency_symbol.$max_amount; ?></strong></li>
            <?php } ?>
            <?php
              if ( $currency_rate_to_usd  > 1) {
            ?>
            <li><?=lang("currency_rate")?>: 1USD = <strong><?php echo $currency_rate_to_usd; ?></strong>TL</li>
            <?php }?>
            <li><?php echo lang("clicking_return_to_shop_merchant_after_payment_successfully_completed"); ?></li>
          </ul>
        </div>

        <div class="form-group">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="agree" value="1">
            <span class="custom-control-label"><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></span>
          </label>
        </div>
        <div class="form-actions left">
          <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
          <input type="hidden" name="payment_method" value="<?php echo $type; ?>">
          <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
            <?=lang("Pay")?>
          </button>
        </div>

      
      </div>  
    </div>
  </form>
</div>
