<section class="add-funds m-t-30">   
  <div class="container-fluid">
    <div class="row justify-content-md-center" id="result_ajaxSearch">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title text-uppercase"><?=lang("coinpayments_confirm_form")?></h3>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <form class="actionForm" method="post" action="<?=cn($module."/coinpayments/create_payment")?>" data-redirect="<?=cn($module."/coinpayments/payment_url")?>" >
                <div class="form-group">
                  <label class="form-label"><?=lang("total_amount_usd_includes_fee")?></label>
                  <input type="number" class="form-control" value="<?=$amount?>" disabled>
                </div>

                <div class="form-group">
                  <label class="form-label"><?=lang("user_information")?></label>
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fe fe-user"></i>
                    </span>
                    <input type="text" class="form-control" name="name" id="name" placeholder="<?=lang("Your_name")?>"  >
                  </div>    

                  <div class="input-icon m-t-20">
                    <span class="input-icon-addon">
                      <i class="fe fe-mail"></i>
                    </span>
                    <input type="text" class="form-control" name="email" id="email" placeholder="<?=lang("Email")?>" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label"  for="installments"><?=lang("choose_your_coin")?></label>
                  <select class="form-control"  name="currency2">
                  <?php
                    if (!empty($coins) && is_array($coins)) {
                        foreach ($coins as $coin) {
                  ?>
                  <option value="<?=$coin?>"><?=$coin?></option>
                  <?php
                    }}
                  ?>
                  </select>
                </div>

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

