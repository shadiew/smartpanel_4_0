<section class="add-funds m-t-30">   
  <div class="container-fluid">
    <div class="row justify-content-md-center" id="result_ajaxSearch">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title"> <?=lang("paytm_confirmation")?></h3>
          </div>
          <div class="card-body">
            <div class="tab-content" id="result_notification">
              <form  id="paymentFrm" method="post" action="<?=cn($module."/paytm/create_payment")?>">
                <div class="form-group">
                  <label class="form-label"><?=sprintf(lang("total_amount_XX_includes_fee"), 'INR')?></label>
                  <input type="text" class="form-control" value="<?=$amount?>" disabled>
                </div>

                <div class="form-group">
                  <span class="small"><?=lang("note")?> <?=lang("the_system_will_convert_automatically_from_INR_to_USD_and_add_funds_to_your_blance_when_payment_is_made")?></span>
                </div>

                <input title="TXN_AMOUNT" tabindex="10" type="hidden" name="TXN_AMOUNT" value="<?=$amount?>">
                <input type="hidden" class="form-control" name="payment_type" value="paytm">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                <!-- submit button -->
                <input type="submit" class="btn btn-primary btn-lg btn-block"value="<?=lang("Submit")?>">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
