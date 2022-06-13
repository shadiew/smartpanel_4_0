<?php
  $option           = get_value($payment_params, 'option');
  $min_amount       = get_value($payment_params, 'min');
  $max_amount       = get_value($payment_params, 'max');
  $type             = get_value($payment_params, 'type');
  $tnx_fee          = get_value($option, 'tnx_fee');
  $public_key       = get_value($option,'public_key');
  $secret_key       = get_value($option,'secret_key');

  $currency_code    = get_option("currency_code",'USD');
  $currency_symbol  = get_option("currency_symbol",'$');
?>

<div class="add-funds-form-content">
  <form class="form actionAddFundsStripe3DSForm" action="" method="POST">
    <div class="row">
      <div class="col-md-12">
        
        <div class="for-group text-center">
          <img width="300px" src="<?=BASE?>/assets/images/payments/stripe3ds.png" alt="Stripe icon">
          <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Stripe 3DS')?></small></p>
        </div>

        <div class="form-group">
          <label><?=sprintf(lang("amount_usd"), $currency_code)?></label>
          <input class="form-control square" type="number" name="amount" placeholder="<?php echo $min_amount; ?>">
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
            <li><?php echo lang("clicking_return_to_shop_merchant_after_payment_successfully_completed"); ?></li>
          </ul>
        </div>

        <div class="form-group">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="agree" value="1">
            <span class="custom-control-label text-uppercase"><strong><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></strong></span>
          </label>
        </div>

        <div id="lwValidationMessage" class="lw-validation-message"></div>

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

<?php
  $stripe_configure = [
    'gateway'                   => 'Stripe', //payment gateway name
    'locale'                    => 'local', //set local as auto
    'allowRememberMe'           => false, //set remember me ( true or false)
    'currency'                  => 'USD', //currency
    'currencySymbol'            => '$',
    'stripePublishKey'          => $public_key,
  ];

?>

<script type="text/javascript">
  //config data
  var configItem  = <?php echo json_encode($stripe_configure); ?>,
      stripePublishKey  = '';
  $(".lw-show-till-loading").show();
  
  //check stripe test or production mode
  stripePublishKey = configItem['stripePublishKey'];

  $(document).on("submit", ".actionAddFundsStripe3DSForm", function(){
    // pageOverlay.show();
    event.preventDefault();
    var _that         = $(this),
    _action       = PATH + 'add_funds/process',
    _redirect     = _that.data("redirect"),
    _data         = _that.serialize();
    _data         = _data + '&' + $.param({token:token});
    $.post(_action, _data, function(_result){
        var stripe = Stripe(stripePublishKey);
        if (is_json(_result)) {
          _result = JSON.parse(_result);
          console.log(_result.id);
          if (typeof _result.id !== "undefined") {
            stripe.redirectToCheckout({
                sessionId: _result.id,
            }).then(function (result) {
                var string = '';                                
                string += '<div class="alert alert-danger" role="alert">'+ _result.message +'</div>';
                $('#lwValidationMessage').html(string);
            });
          }else{
            var string = '';                                
            string += '<div class="alert alert-danger" role="alert">'+ _result.message +'</div>';
            $('#lwValidationMessage').html(string);
          }

        }else{
          setTimeout(function(){
            $(".actionAddFundsForm").html(_result);
          }, 1500)
        }
    })
  })
</script>
<script src="https://js.stripe.com/v3"></script>
