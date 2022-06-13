<?php
  $items_category = array_column($items_category, 'id', 'name');
  $items_category = array_flip(array_intersect_key($items_category, array_flip(array_keys($items))));
?>
<section class="page-title">
  <div class="row justify-content-between">
    <div class="col-md-2">
      <h1 class="page-title">
        <i class="fe fe-list" aria-hidden="true"> </i> 
        <?=lang("Services")?>
      </h1>
    </div>
    <div class="col-md-7">
      <?php
        if (get_option("enable_explication_service_symbol")) {
      ?>
      <div class="btn-list">
        <span class="btn round btn-secondary ">⭐ = <?=lang("__good_seller")?></span>
        <span class="btn round btn-secondary ">⚡️ = <?=lang("__speed_level")?></span>
        <span class="btn round btn-secondary ">🔥 = <?=lang("__hot_service")?></span>
        <span class="btn round btn-secondary ">💎 = <?=lang("__best_service")?></span>
        <span class="btn round btn-secondary ">💧 = <?=lang("__drip_feed")?></span>
      </div>
      <?php } ?>
    </div>
    <div class="col-md-3">
      <div class="form-group ">
        <select  name="status" class="form-control order_by ajaxChange" data-url="<?=cn($controller_name. "/sort/")?>">
          <option value="0"> <?=lang("all")?></option>
          <?php 
            if (!empty($items_category)) {
              foreach ($items_category as $key => $category) {
          ?>
          <option value="<?=$key?>"><?=$category?></option>
          <?php }}?>
        </select>
      </div>
    </div>
  </div>
</section>
<div class="row m-t-5" id="result_ajaxSearch">
  <?php 
    if(!empty($items)){
      $data = array(
        "controller_name"     => $controller_name,
        "params"              => $params,
        "columns"             => $columns,
        "items"               => $items,
        "items_custom_rate"   => $items_custom_rate,
      );
      $this->load->view('child/index', $data);
    }else{
      echo show_empty_item();
    }
  ?>
</div>