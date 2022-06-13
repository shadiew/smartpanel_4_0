<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <label><?=lang("service_name")?></label>
    <input class="form-control square" name="service_name" type="text" value="<?=$service['name']?>" disabled>
  </div>
</div>   

<div class="col-md-4  col-sm-12 col-xs-12">
  <div class="form-group">
    <label><?=lang("minimum_amount")?></label>
    <input class="form-control square" type="text" name="service_min" value="<?=$service['min']?>"  readonly>
  </div>
</div>

<div class="col-md-4  col-sm-12 col-xs-12">
  <div class="form-group">
    <label><?=lang("maximum_amount")?></label>
    <input class="form-control square"  type="text" name="service_max" value="<?=$service['max']?>" readonly>
  </div>
</div>

<div class="col-md-4  col-sm-12 col-xs-12">
  <div class="form-group">
    <label><?=lang("price_per_1000")?> (<?=get_option("currency_symbol", "")?>)</label>
    <?php
      $user_price = get_user_price(session('uid'), (object)$service);
    ?>
    <input class="form-control square" type="text" name="service_price" value="<?=show_price_format($user_price);?>" readonly>
  </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="form-group">
    <label for="userinput8"><?=lang("Description")?></label>
    <?php
      if (!empty($service['desc'])) { ?>
      <div class="card border">
        <div style="padding: 10px; min-height: 200px; background: #f8f9fa;">
          <?php
            $desc = html_entity_decode($service['desc'], ENT_QUOTES);
            $desc = str_replace("\n", "<br>", $desc);
            echo strip_tags($desc, "<br>");
          ?>
        </div>
      </div>
      <?php }else{ ?>
      <textarea rows="10" class="form-control square" name="service_desc" id="service_desc" class="form-control square" disabled>
      </textarea>
    <?php }?>  
    
  </div>
</div>
