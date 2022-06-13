  <input type="hidden" name="total_charge" value="<?=$total?>">
  <p class="btn btn-info"><?=lang("total_charge")?> $<?=$total?></p>
  <?php if(!empty($message))
    {
  ?>
  <p class="text-danger"><?=$message?></p>
  <?php }?>
