<?php

  $option           = get_value($payment_params, 'option');

  $min_amount       = get_value($payment_params, 'min');

  $max_amount       = get_value($payment_params, 'max');

  $type             = get_value($payment_params, 'type');

  $tnx_fee          = get_value($option, 'tnx_fee');

  $public_key       = get_value($option, 'public_key');

  $currency_code    = get_option("currency_code",'USD');

  $currency_symbol  = get_option("currency_symbol",'$');

?>

<style>

    

    .container_payment-wall{

        display: none;

    }

</style>

<div class="errors error">



</div>

<form id="brick-creditcard-form" class="actionAddFundsWallCheckoutForm" action="add_funds/process" method="POST">

<input type="hidden"  name="<?php echo $this->security->get_csrf_token_name();?>"  value="<?php echo $this->security->get_csrf_hash();?>">

<div class="form-group text-center">

          <img src="<?=BASE?>/assets/images/payments/paymentwall-logo.png" style="max-width: 250px;" alt="coinbase icon">

          <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Payment Wall')?></small></p>

        </div>

    <div class="form-group">

      <label class="form-label"><?=sprintf(lang("amount_usd"), get_option("currency_code",'USD'))?></label>

      <input type="text" name="amount" class="wall-amount form-control" placeholder="<?php echo $min_amount; ?>">

    </div>

    <!--<div class="form-group">-->

    <!--  <label class="form-label">Card number</label>-->

    <!--    <input class="form-control" placeholder="Card Number" data-brick="card-number" type="text" id="card-number"/>-->

    <!--</div>-->

    <!--<div class="form-group">-->

    <!--  <label class="form-label">Card expiration</label>-->

    <!--    <input class="form-control" data-brick="card-expiration-month" type="text" size="2" placeholder="MM" id="card-exp-month"/> /-->

    <!--    <input class="form-control" data-brick="card-expiration-year" type="text" size="4" placeholder="YYYY" id="card-exp-year"/>-->

    <!--</div>-->

    <!--<div class="form-group">-->

    <!--  <label class="form-label">Card CVV</label>-->

    <!--    <input class="form-control" placeholder="CVV" data-brick="card-cvv" type="text" id="card-cvv"/>-->

    <!--</div>-->

    <div class="form-group">

      <label class="form-label"><?php echo lang("note"); ?></label>

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

    <div id="brick-token"></div>

    <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">

    <input type="hidden" name="payment_method" value="<?php echo $type; ?>">

    <button class="btn round btn-primary btn-min-width mr-1 mb-1" type="submit"><?=lang("Pay")?></button>

  </form>

    <section class="payment-form dark">

    <div class="container_payment-wall">

      <div class="block-heading">

        <h2>Checkout Payment</h2>

      </div>

      <div class="form-payment">

        <div class="products">

          <h2 class="title">Add Funds</h3>

          <div class="total">Amount<span class="price" id="summary-total-wall"></span></div>

        </div>

        <div class="payment-details">

          <div class="form-group col-sm-12">

            <br>      

            <div id="button-checkout" class="cho-container-wall">

                

            </div>                 

            <br>

            <a id="go-back">

              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 10 10" class="chevron-left">

                <path fill="#009EE3" fill-rule="nonzero"id="chevron_left" d="M7.05 1.4L6.2.552 1.756 4.997l4.449 4.448.849-.848-3.6-3.6z"></path>

              </svg>

              Go back to Shopping Cart

            </a>

          </div>

        </div>

      </div>

    </div>

</section>

<!--<script type="text/javascript" src="https://api.paymentwall.com/brick/brick.1.4.js"></script>-->



<script>

    var $form = $('#brick-creditcard-form');

    // var brick = new Brick({

    //     public_key: '<?php echo $public_key; ?>', // please update it to Brick live key before launch your project

    //     form: { formatter: true }

    // }, 'custom');

    

    $form.submit(function(e) {

        e.preventDefault();

    

        pageOverlay.show();

        event.preventDefault();

        var  _action   = PATH + 'add_funds/process',

        _form   = $('#brick-creditcard-form'),

        _data   = _form.serialize();

        $.post(_action, _data, function(res){

            console.log(res);

            let _result = JSON.parse(res);

            if(_result.hasOwnProperty('html')){

                $('.cho-container-wall').html('');

                $('.cho-container-wall').html(_result.html);

                

                $("#brick-creditcard-form").fadeOut(500);

                $("#summary-total-wall").text($('.wall-amount').val())

                setTimeout(() => {

                    $(".container_payment-wall").show(500).fadeIn();

                }, 500);

                //window.open(_result.html);

            }else{

                _result = JSON.parse(res);

                setTimeout(function(){

                    notify(_result.message, _result.status);

                },1500)

            }

            

            setTimeout(function(){

                pageOverlay.hide();

            },1500)

        });

        // brick.tokenizeCard({

        //   card_number: $('#card-number').val(),

        //   card_expiration_month: $('#card-exp-month').val(),

        //   card_expiration_year: $('#card-exp-year').val(),

        //   card_cvv: $('#card-cvv').val()

        // }, function(response) {

          

        //   $form.find('button').prop('disabled', true);

        //   if (response.type == 'Error') {

        //     let errors = response.error;

        //     let html = "";

        //     if(errors.length > 0 && Array.isArray(errors)){

        //       let errors = response.error;

        //       errors.forEach(function(item){

        //         html += '<div class="alert alert-danger" role="alert">'+item+ '</div>';

        //       });

             

        //     }else{

        //       html += '<div class="alert alert-danger" role="alert">'+errors+ '</div>';

        //     }

        //     $form.find('button').prop('disabled', false);

        //     $(".errors").html(html);

        //   } else {

        //     $(".errors").html('');

        //     $form.find('button').prop('disabled', false);

    

        //     var string = '<input type="hidden" name="brick_token" value="'+response.token+'" />';

        //     string += '<input type="hidden" name="brick_fingerprint" value="'+Brick.getFingerprint()+'" />';

        //     $("#brick-token").html(string);

    

        //     var  _action   = PATH + 'add_funds/process' ,

        //     _data   = $form.serialize();

        //     $.post(_action, _data, function(_result){

        //       console.log(_data);

        //       if (is_json(_result)) {

        //         _result = JSON.parse(_result);

        //         setTimeout(function(){

        //           notify(_result.message, _result.status);

        //         },1500);

        //         $form.find('button').prop('disabled', false);

        //       }else{

        //         setTimeout(function(){

        //           $(".actionAddFundsWallCheckoutForm").html(_result);

        //         }, 1500)

        //       }

        //     })

        //   }

        // });

    

        // return false;

    });





    document.getElementById("go-back").addEventListener("click", function() {

      $(".container_payment-wall").fadeOut(500);

      setTimeout(() => {

          $("#brick-creditcard-form").show(500).fadeIn();

      }, 500);  

    });



</script>