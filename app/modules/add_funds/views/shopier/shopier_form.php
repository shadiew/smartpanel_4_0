<div class="checkout-left-content">
    <form class="actionCheckoutForm" method="POST" action="<?php echo cn("checkout/shopier/create_payment_step2"); ?>" id="form">
        <fieldset class="form-fieldset m-t-20">
            <div class="form-group text-center">
                <img src="<?=BASE?>assets/images/payments/shopier1.png" alt="Shopier icon" style="max-height: 90px;">
            </div>
            <div class="form-group text-center" id="credit_cards">
              <img src="<?php echo BASE; ?>assets/images/payments/visa.jpg" id="visa">
              <img src="<?php echo BASE; ?>assets/images/payments/mastercard.jpg" id="mastercard">
              <img src="<?php echo BASE; ?>assets/images/payments/amex.jpg" id="amex">
            </div>
            <!-- get alert html -->
            <div id="alert-message"></div>
            <div class="form-group">
                <label class="form-label"><?php echo lang('first_name'); ?> <span class="form-required">*</span></label>
                <input type="text" name="order[first_name]" class="form-control" required="true">
            </div>

            <div class="form-group">
                <label class="form-label"><?php echo lang('last_name'); ?> <span class="form-required">*</span></label>
                <input type="text" name="order[last_name]" class="form-control" required="true">
            </div>

            <div class="form-group">
                <label class="form-label"><?php echo lang('phone'); ?> <span class="form-required">*</span></label>
                <input type="text" name="order[phone]" class="form-control" required="true">
            </div>

            <input type="hidden" name="order[item_ids]" value="<?php echo strip_tags($item_ids); ?>">
            <input type="hidden" name="order[email]" value="<?php echo strip_tags($email); ?>">
            <input type="hidden" name="order[link]" value="<?php echo strip_tags($link); ?>">
            <input type="hidden" name="order[price]" value="<?php echo strip_tags($price); ?>">
            <input type="hidden" name="<?php echo strip_tags($this->security->get_csrf_token_name()); ?>" value="<?php echo strip_tags($this->security->get_csrf_hash()); ?>">
            <div class="card-footer text-left">
                <button type="submit" class="btn btn-pill btn-submit btn-gradient btn-block mr-1 mb-1">Submit</button>
            </div>
        </fieldset>
    </form>
</div>
