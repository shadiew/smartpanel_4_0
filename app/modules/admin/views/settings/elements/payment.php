<?php
  $form_url = admin_url($controller_name."/store/");
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => get_current_url(), 'method' => "POST");
?>
<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-credit-card"></i> <?=lang("payment_integration")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("manual_payment")?></h5 class="text-info">
          <div class="form-group">
            <div class="form-label"><?=lang("Status")?></div>
            <div class="custom-controls-stacked">
              <label class="custom-control custom-checkbox">
                <input type="hidden" name="is_active_manual" value="0">
                <input type="checkbox" class="custom-control-input" name="is_active_manual" value="1" <?=(get_option('is_active_manual', "") == 1)? "checked" : ''?>>
                <span class="custom-control-label"><?=lang("Active")?></span>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label"><?=lang("Content")?></label>
            <textarea rows="3" name="manual_payment_content" id="manual_payment_content" class="form-control plugin_editor"><?=get_option('manual_payment_content', lang("you_can_make_a_manual_payment_to_cover_an_outstanding_balance_you_can_use_any_payment_method_in_your_billing_account_for_manual_once_done_open_a_ticket_and_contact_with_administrator"))?>
            </textarea>
          </div>

        </div> 
      </div>
    </div>
    <div class="card-footer text-end">
      <button class="btn btn-primary btn-min-width text-uppercase"><?=lang("Save")?></button>
    </div>
  <?php echo form_close(); ?>
</div>
<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 200, toolbar: 'code'});
  });
</script>
