<?php  
  if (!empty($error_details)) {
?>
<div class="form-section content-header-title">
  <h4 class="text-danger"><i class="fa fa-exclamation-triangle"></i> <?=lang("failed")?></h4>
</div>
<div class="alert alert-warning">
  <p class="p-b-10"><?=lang("there_was_some_issues_with_your_mass_order")?></p>
  <table class="table table-hover table-bordered">
    <thead>
    <tr>
      <th width="55%"><?=lang("order_content")?></th>
      <th><?=lang("error_message")?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($error_details as $key => $value) {
      ?>
      <tr>
        <td title="<?=$key?>"><?=$key?></td>
        <td><?=$value?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php }?>