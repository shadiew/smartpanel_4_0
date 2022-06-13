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
                    <label class="form-label">Instructions</label>
                    <textarea rows="3" name="payment_params[option][instruction]" id="paytm_QR_instruction" class="form-control plugin_editor"><?php echo (isset($option->instruction)) ? $option->instruction : ''; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label class="form-label"> Paytm QR code image</label>
                    <input class="form-control" name="payment_params[option][qr_code]" value="<?php echo (isset($option->qr_code)) ? $option->qr_code : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label"> Paytm email (your gmail id registered on paytm)</label>
                    <input class="form-control" name="payment_params[option][gmail]" value="<?php echo (isset($option->gmail)) ? $option->gmail : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label">Paytm Email password</label>
                    <input class="form-control" name="payment_params[option][gmail_password]" type="password" value="<?php echo (isset($option->gmail_password)) ? $option->gmail_password : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label"><?=lang("currency_rate")?></label>
                    <div class="input-group">
                      <span class="input-group-prepend">
                        <span class="input-group-text">1USD =</span>
                      </span>
                      <input type="text" class="form-control text-right" name="payment_params[option][rate_to_usd]" value="<?php echo (isset($option->rate_to_usd)) ? $option->rate_to_usd : 76; ?>">
                      <span class="input-group-append">
                        <span class="input-group-text">INR</span>
                      </span>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="form-group">
                      <span class="text-danger"><strong><?=lang('note')?></strong></span>
                      <ul class="small">
                        <li> Enable access to less secure apps and unlock captcha for your Google account using:
                            <ol>
                              <li><a href="https://www.google.com/settings/security/lesssecureapps">https://www.google.com/settings/security/lesssecureapps</a></li>
                              <li><a href="https://accounts.google.com/b/0/DisplayUnlockCaptcha.">https://accounts.google.com/b/0/DisplayUnlockCaptcha.</a></li>
                            </ol>
                        </li>
                      </ul>
                    </div>
                  </div>

                </div>

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
