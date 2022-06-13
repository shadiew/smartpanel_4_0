
<div id="main-modal-content">
  <div class="modal-right">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <?php
          $id = (!empty($payment->id))? $payment->id: '';
          if ($id != "") {
            $url = cn($module."/ajax_update/$id");
          }else{
            $url = cn($module."/ajax_update");
          }
        ?>
        <form class="form actionForm" action="<?php echo $url?>" data-redirect="<?php echo cn($module); ?>" method="POST">
          <div class="modal-header bg-pantone">
            <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $payment->name; ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <div class="form-body">
              <div class="row justify-content-md-center">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label class="form-label" ><?php echo lang("method_name"); ?></label>
                    <input type="hidden" class="form-control square" name="payment_params[type]" value="<?php echo $payment->type; ?>">
                    <input type="text" class="form-control square" name="payment_params[name]" value="<?php echo (!empty($payment->name))? $payment->name : '' ; ?>">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" ><?php echo lang("Minimal_payment"); ?></label>
                    <input type="number" class="form-control square" name="payment_params[min]" value="<?php echo (!empty($payment->min))? $payment->min : '' ; ?>">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" ><?php echo lang("Maximal_payment"); ?></label>
                    <input type="number" class="form-control square" name="payment_params[max]" value="<?php echo (!empty($payment->max))? $payment->max : '' ; ?>">
                  </div>
                </div>
               
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" ><?php echo lang("new_users"); ?></label>
                    <select name="payment_params[new_users]" class="form-control square">
                      <option value="1" <?php echo (!empty($payment->new_users) && $payment->new_users == 1)? 'selected' : '' ; ?>><?php echo lang("allowed"); ?></option>
                      <option value="0" <?php echo (isset($payment->new_users) && $payment->new_users != 1)? 'selected' : '' ; ?>><?php echo lang("not_allowed"); ?></option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label"><?php echo lang("Status"); ?></label>
                    <select name="payment_params[status]" class="form-control square">
                      <option value="1" <?php echo (!empty($payment->status) && $payment->status == 1) ? 'selected' : '' ; ?>><?php echo lang("Active")?></option>
                      <option value="0" <?php echo (isset($payment->status) && $payment->status != 1) ? 'selected' : '' ; ?>><?php echo lang("Deactive")?></option>
                    </select>
                  </div>
                </div>
                <?php
                  $payment_params = json_decode($payment->params);
                  $option = $payment_params->option;
                ?>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label"><?=lang("transaction_fee")?></label>
                    <select name="payment_params[option][tnx_fee]" class="form-control square">
                      <?php
                        for ($i = 0; $i <= 30; $i++) {
                      ?>
                      <option value="<?=$i?>" <?=(isset($option->tnx_fee) && $option->tnx_fee == $i)? "selected" : ''?>><?php echo $i; ?>%</option>
                      <?php } ?>
                    </select>
                  </div>
                </div> 
                 
                <div class="col-md-12">
                  <hr>
                  <div class="form-group">
                    <label class="form-label">Merchant ID<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="payment_params[option][merchant_id]" value="<?php echo (isset($option->merchant_id)) ? $option->merchant_id : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label">Secret Word<span class="form-required">*</span></label>
                    <input type="text" class="form-control"  name="payment_params[option][secret_key]" value="<?php echo (isset($option->secret_key)) ? $option->secret_key : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label">Secret Word 2<span class="form-required">*</span></label>
                    <input type="text" class="form-control"  name="payment_params[option][secret_key_2]" value="<?php echo (isset($option->secret_key_2)) ? $option->secret_key_2 : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label">Curency Code</label>
                    <select name="payment_params[option][currency_code]" class="form-control square ajaxChangeCurrencyCode">
                      <option value="USD" <?=(isset($option->currency_code) && $option->currency_code == 'USD')? "selected" : ''?>>USD - US Dollar</option>
                      <option value="RUB" <?=(isset($option->currency_code) && $option->currency_code == 'RUB')? "selected" : ''?>>RUB</option>
                      <option value="EUR" <?=(isset($option->currency_code) && $option->currency_code == 'EUR')? "selected" : ''?>>EUR</option>
                      <option value="UAH" <?=(isset($option->currency_code) && $option->currency_code == 'UAH')? "selected" : ''?>>UAH</option>
                      <option value="KZT" <?=(isset($option->currency_code) && $option->currency_code == 'RUB')? "selected" : ''?>>KZT</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="form-label">Currency rate (Input new rate)</label>
                    <div class="input-group">
                      <span class="input-group-prepend">
                        <span class="input-group-text">1<?php echo get_option('currency_code'); ?> =</span>
                      </span>
                      <input type="text" class="form-control text-right currency-rate-value" name="payment_params[option][rate_to_usd]" value="<?php echo (isset($option->rate_to_usd)) ? $option->rate_to_usd : 409; ?>">
                      <span class="input-group-append">
                        <span class="input-group-text new-currency-code"><?php echo (isset($option->currency_code)) ? $option->currency_code : 'RUB'; ?></span>
                      </span>
                    </div>
                  </div>


                </div>
                <?php
                  $payments_code = array(
                    '1'     => 'FK WALLET RUB',
                    '2'     => 'FK WALLET USD',
                    '3'     => 'FK WALLET EUR',
                    '4'     => 'VISA RUB',
                    '6'     => 'Yoomoney',
                    '7'     => 'VISA UAH',
                    '8'     => 'MasterCard RUB',
                    '9'     => 'MasterCard UAH',
                    '10'     => 'Qiwi',
                    '11'    => 'VISA EUR',
                    '12'    => 'МИР',
                  );
                ?>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">Payment Method Acceptance Settings:</label>
                    <span class="text-danger"><strong><?=lang('note')?></strong></span>
                    <ul class="small">
                      <li> Go to the Free Kassa settings page </li>
                      <li> Select the notification method <code class="text-primary">POST</code> </li>
                      <li> Select the integration mode <code class="text-primary">NO</code></li>
                      <li> Site URL: <code class="text-primary"><?=cn()?></code> </li>
                      <li> Notification URL: <code class="text-primary"><?=cn('add_funds/freekassa/complete')?></code></li>
                      <li> Success URL: <code class="text-primary"><?=cn('add_funds/freekassa/complete')?></code></li>
                      <li> Unsuccess URL: <code class="text-primary"><?=cn('add_funds/unsuccess')?></code>
                      <li>Please enable all Payment methods which support Curency Code at the same time. <br>For example: if you enable Curency Code - USD, you must be choose all payment support USD and set rate in currency rate fields</li>
                      </li>
                    </ul>
                  </div>
                </div>
                <?php
                  $freekassa_acceptance = isset($option->freekassa_acceptance) ? $option->freekassa_acceptance : ["70","123","64"];
                  $i = 0;
                  foreach ($payments_code as $key => $row) {
                    $i++;
                ?>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="custom-controls-stacked">
                      <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="payment_params[option][freekassa_acceptance][]" value="<?=$key?>" <?=(in_array($key, $freekassa_acceptance)) ? "checked" : ''?>>
                        <span class="custom-control-label"><?=$row?></span>
                      </label>
                    </div>
                  </div>
                </div>
                <?php }?>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?php echo lang("Submit")?></button>
            <button type="button" class="btn round btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?php echo lang("Cancel")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on("change",".ajaxChangeCurrencyCode", function(){
    var _that = $(this),
        _type = _that.val();
    $(".new-currency-code").html(_type);
    $(".currency-rate-value").val('1');

  });
</script>