<?php
  $option           = get_value($payment_params, 'option');
  $min_amount       = get_value($payment_params, 'min');
  $max_amount       = get_value($payment_params, 'max');
  $type             = get_value($payment_params, 'type');
  $tnx_fee          = get_value($option, 'tnx_fee');
?>

<div class="add-funds-form-content">
  <form class="form actionForm2" action="<?=cn($module."/pix/ajax_new_payment")?>" method="POST">
    <div class="row">
      <div class="col-md-12">
        <div class="for-group text-center">
          <img src="<?=BASE?>/assets/images/pix.png" alt="PIX icon" style="max-width:250px;">
          <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Paypal')?></small></p>
        </div>
        
         <div class="form-group">
            <label><?= lang("CPF / CNPJ") ?></label>
            <input class="form-control square" type="text" name="cpfcnpj" placeholder="Digite seu CPF ou CNPJ sem pontuação" minlength="11" maxlength="14" onkeypress="return somenteNumeros(event)"  onchange="somenteNumerosDgt(this)">
    
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
<script>
    $(document).on("submit", ".actionForm2", function(){
        pageOverlay.show();
        event.preventDefault();
        _that       = $(this);
        _action     = _that.attr("action");
    
        _data       = _that.serialize();
        _data       = _data + '&' + $.param({token:token});
    
        $.post(_action, _data, function(_result){
    
    
          setTimeout(function(){
              pageOverlay.hide();
          },500)
          try {
            _result = $.parseJSON(_result);
            if(_result.status == 'error'){
              notify(_result.message, _result.status)
              return;
            }
          } catch(ex) {
              // trate o erro aqui
          }
    
    
          $("#pixModal").modal('show');
          $("#pixModal .modal-body").html(_result)
        })
        return false;
    })
    function somenteNumeros(e) {
        var charCode = e.charCode ? e.charCode : e.keyCode;
        // charCode 8 = backspace   
        // charCode 9 = tab
        if (charCode != 8 && charCode != 9) {
            // charCode 48 equivale a 0   
            // charCode 57 equivale a 9
            if (charCode < 48 || charCode > 57) {
                return false;
            }
        }
      }
      function somenteNumerosDgt(e) {
        e.value = e.value.replace(/\D/g, '');
      } 
</script>
