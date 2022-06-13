<section class="add-funds m-t-30">   
  <div class="container-fluid">
    <div class="row justify-content-md-center" id="result_ajaxSearch">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title"> Paystack Integration</h3>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <form id="paymentFrm" method="post" action="<?=cn($module."/paystack/create_payment")?>">

                <div class="form-group">
                  <label class="form-label"><?=sprintf(lang("total_amount_XX_includes_fee"), 'NGN')?></label>
                  <input type="text" class="form-control" value="<?=$amount?>" readonly>
                </div>

                <div class="form-group">
                  <span class="small"><?=lang("note")?> The system will convert automatically from NGN to USD and add funds to your blance when payment is made</span>
                </div>
                <input type="hidden" name="amount" value="<?=$amount?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                <!-- submit button -->
                <input type="submit" class="btn btn-primary btn-lg btn-block" name="PAYMENT_METHOD" value="<?=lang("Submit")?>">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
