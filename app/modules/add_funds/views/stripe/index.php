
<style>
    /**
   * The CSS shown here will not be introduced in the Quickstart guide, but shows
   * how you can use CSS to style your Element's container.
   */
  .StripeElement {
    box-sizing: border-box;
    width: 100%;
    height: 40px;
    margin: 10px;
    padding: 10px 12px;
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
  }

  .StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
  }

  .StripeElement--invalid {
    border-color: #fa755a;
  }

  .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
  }
</style>

<style>
  .creditCardForm .form-control {
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .creditCardForm .form-group .transparent {
    opacity: 0.1;
  }
</style>
<script src="https://js.stripe.com/v3/"></script>
<?php
  $option           = get_value($payment_params, 'option');
  $min_amount       = get_value($payment_params, 'min');
  $max_amount       = get_value($payment_params, 'max');
  $type             = get_value($payment_params, 'type');
  $tnx_fee          = get_value($option, 'tnx_fee');
  $currency_code    = get_option("currency_code",'USD');
  $currency_symbol  = get_option("currency_symbol",'$');
?>

<form class="creditCardForm actionAddFundsStripeCheckoutForm" action="#" method="post" id="payment-form">
  <div class="for-group text-center">
    <img src="<?=BASE?>/assets/images/payments/stripe-dark.svg" alt="Stripe icon">
    <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Stripe')?></small></p>
  </div>
  <fieldset class="form-fieldset m-t-10">
    <div class="form-group">
      <label class="form-label"><?=sprintf(lang("amount_usd"), get_option("currency_code",'USD'))?></label>
      <input type="text" name="amount" class="form-control">
    </div>
    <div class="form-row mt15">
      <div id="card-element"></div>
      <div id="card-errors" role="alert" class="text-danger"></div>
    </div>
    <div class="form-group text-center m-t-10" id="credit_cards">
      <img src="<?php echo BASE; ?>assets/images/payments/visa.jpg" id="visa">
      <img src="<?php echo BASE; ?>assets/images/payments/mastercard.jpg" id="mastercard">
      <img src="<?php echo BASE; ?>assets/images/payments/amex.jpg" id="amex">
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
      </ul>
    </div>

    <div class="form-group">
      <label class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" name="agree" value="1">
        <span class="custom-control-label text-uppercase"><strong><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></strong></span>
      </label>
    </div>
    <div class="form-group">
      <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
      <input type="hidden" name="payment_method" value="<?php echo $type; ?>">
      <button type="submit" class="btn btn-dark btn-lg btn-block m-t-15"><?=lang('Submit')?></button>
    </div>
  </fieldset>
</form>   


<script type="text/javascript">
setTimeout(function(){
  // Create a Stripe client
  var stripe = Stripe('<?php echo get_value($option, 'public_key'); ?>');

  // Create an instance of Elements
  var elements = stripe.elements();

  // Custom styling can be passed to options when creating an Element.
  // (Note that this demo uses a wider set of styles than the guide below.)
  var style = {
      base: {
      color: '#32325d',
      lineHeight: '18px',
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: 'antialiased',
      fontSize: '16px',
      '::placeholder': {
        color: '#aab7c4'
      }
      },
      invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
      }
  };

  // Create an instance of the card Element
  var card = elements.create('card', {hidePostalCode: true, style: style});

  // Add an instance of the card Element into the `card-element` <div>
  card.mount('#card-element');

  // Handle real-time validation errors from the card Element.
  card.addEventListener('change', function(event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
  });

  // Handle form submission
  var form = document.getElementById('payment-form');
  form.addEventListener('submit', function(event) {
      event.preventDefault();
      var _that = $(this);
      
      stripe.createToken(card).then(function(result) {
        if (result.error) {
        // Inform the user if there was an error
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server
            stripeTokenHandler(result.token, _that);
        }
      });
  });
}, 1000);

function stripeTokenHandler(stripe_token, _that) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', stripe_token.id);
  form.appendChild(hiddenInput);

  // var hiddenToken = document.createElement('input');
  // hiddenToken.setAttribute('type', 'hidden');
  // hiddenToken.setAttribute('name', 'token');
  // hiddenToken.setAttribute('value', token);
  // form.appendChild(hiddenToken);

  // Submit the form
  pageOverlay.show();
  event.preventDefault();
  var  _action   = PATH + 'add_funds/process',
    _form   = _that.closest('form'),
    _data   = _form.serialize(),
    _data   = _data + '&' + $.param({token:token});
  $.post(_action, _data, function(_result){
    console.log(_data);
    setTimeout(function(){
      pageOverlay.hide();
    },1500)
    if (is_json(_result)) {
      _result = JSON.parse(_result);
      setTimeout(function(){
        notify(_result.message, _result.status);
      },1500)
    }else{
      setTimeout(function(){
        $(".actionAddFundsStripeCheckoutForm").html(_result);
      }, 1500)
    }
  })
  return false;
}
</script>
