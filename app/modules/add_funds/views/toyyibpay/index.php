<?php
  $option                 = get_value($payment_params, 'option');
  $min_amount             = get_value($payment_params, 'min');
  $max_amount             = get_value($payment_params, 'max');
  $type                   = get_value($payment_params, 'type');
  $tnx_fee                = get_value($option, 'tnx_fee');
  $currency_rate_to_usd   = get_value($option, 'rate_to_usd');
?>

<div class="add-funds-form-content">
  <form class="form actionAddFundsForm" action="#"  method="POST">
    <div class="row">
      <div class="col-md-12">

        <div class="for-group text-center">
          <img src="<?=BASE?>/assets/images/payments/toyyibpay.png" alt="Toyyibpay icon">
          <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Toyyibpay')?></small></p>
        </div>

        <div class="form-group">
          <label><?=sprintf(lang("amount_usd"), 'RM')?></label>
          <input class="form-control square" type="number" name="amount" placeholder="<?php echo $min_amount; ?>">
        </div> 

        <div class="form-group">
          <label>Phone</label>
          <input class="form-control square" type="number" name="phone_number" placeholder="Your phone Number" required>
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
            <li><?=lang("currency_rate")?>: 1USD = <strong><?php echo $currency_rate_to_usd; ?></strong>RM</li>
            <?php }?>
            <li><?php echo lang("clicking_return_to_shop_merchant_after_payment_successfully_completed"); ?></li>
          </ul>
        </div>

        <div class="form-group">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="agree" value="1">
            <span class="custom-control-label text-uppercase"><strong><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></strong></span>
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