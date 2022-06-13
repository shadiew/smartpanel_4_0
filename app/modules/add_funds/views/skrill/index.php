<?php

  $option           = get_value($payment_params, 'option');

  $min_amount       = get_value($payment_params, 'min');

  $max_amount       = get_value($payment_params, 'max');

  $type             = get_value($payment_params, 'type');

  $tnx_fee          = get_value($option, 'tnx_fee');

?>



<div class="add-funds-form-content">

  <form class="form actionAddFundsForm" action="#" method="POST">

    <div class="row">

      <div class="col-md-12">

        <div class="for-group text-center">

          <img src="<?=BASE?>/assets/images/skrill-logo.png" alt="Paypay icon" style="height:90px;">

          <p class="p-t-10"><small>Your payment will be reviewed and credited from 0 to 12 hours later</small></p>


          
        </div>
        
        <div class="form-group">

          <label>Instrucciones skrill Pago minimo $5 y pago maximo $100</label>
          <ul>
            <li>1. Inicia en tu cuenta Skrill</li>   
            <li> 2. Envia el pago a nuestro Skrill Correo: landaetta@live.com, Envía en la nota o referencia de pago tu email registrado en 1popularity.</li>
            <li> 3. Agrega la información de pago aquí en este formulario.</li>
            <li> 4. Su pago se revisara y acreditara de 0 a 12 horas mas tardar.</li>   
          </ul>
          <hr style="margin-top: 15px; margin-bottom: 15px;"> 
          <label>Instructions skrill Minimum payment $5 and maximum payment $100</label>
          <ul>
            <li>1. Login to your Skrill account</li>   
            <li>2. Send the payment to our Skrill Mail: landaetta@live.com, Send in the note or payment reference your email registered in 1popularity.</li>
            <li>3. Add your payment information here on this form.</li>
            <li>4. Your payment will be reviewed and credited from 0 to 12 hours later.</li>   
          </ul>
          

          <ul style="display: none;">

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
          <label>Transaction ID</label>
          <input class="form-control square" type="number" name="transaction_id" placeholder="Transaction ID">
        </div>  
        
        <div class="form-group">
          <label><?=sprintf(lang("amount_usd"), $currency_code)?></label>
          <input class="form-control square" type="number" name="amount" placeholder="<?php echo $min_amount; ?>">
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