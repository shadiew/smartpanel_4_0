<label><?=lang("order_service")?></label>
<select name="service_id" class="form-control square ajaxChangeService" data-url="<?=cn($module."/order/get_service/")?>">
  <option> <?=lang("choose_a_service")?></option>
    <?php
      if (!empty($items_service)) {
        foreach ($items_service as $key => $item) {
          $service_price = (isset($items_user_price[$item['id']])) ? $items_user_price[$item['id']] : $item['price'];
          $service_title = 'ID'. $item['id'] . ' - '. $item['name']. ' - ' . show_price_format($service_price, true);
    ?>
          <option value="<?=$item['id']?>" data-type="<?=$item['type']?>" data-dripfeed="<?=$item['dripfeed']?>">
            <?php echo $service_title;?>
          </option>
    <?php }}?>
</select>
