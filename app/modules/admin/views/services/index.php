<?php 
  $show_search_area = show_search_area($controller_name, $params);
  $show_items_sort_by_cateogry = show_items_sort_by_category($controller_name, $items_category, $params);
?>
<div class="page-title m-b-20">
  <div class="row justify-content-between">
    <div class="col-md-2">
      <h1 class="page-title">
          <span class="fa fa-list-ul"></span> Services
      </h1>
    </div>
    <div class="col-md-4 search-area">
      <?php echo $show_search_area; ?>
    </div>
    <div class="col-md-12">
      <div class="row justify-content-between">
        <div class="col-md-6">
          <div class="btn-group" role="group" aria-label="Basic example">
            <a href="<?=admin_url($controller_name . "/update"); ?>" class="btn btn-outline-primary ajaxModal"><span class="fe fe-plus"></span> Add new</a>
            <a href="<?=admin_url('provider/services');?>" class="btn btn-outline-primary"><span class="fe fe-folder-plus"></span> Import</a>
          </div>
        </div>
        <div class="col-md-4 d-flex">
          <?php echo $show_items_sort_by_cateogry; ?>
          <?php echo show_bulk_btn_action($controller_name); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <?php if(!empty($items)){
    foreach ($items as $key => $items_category) {
  ?>
    <div class="col-md-12 col-xl-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?=$key;?></h4>
          <div class="card-options">
            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-vcenter card-table">
            <?php 
              $thead_params = [
                'checkbox_data_name' => 'check_' . $items_category[0]['cate_id']
              ];
              echo render_table_thead($columns, true, false, true, $thead_params); 
            ?>
            <tbody>
              <?php if (!empty($items_category)) {
                foreach ($items_category as $key => $item) {
                  $item_checkbox      = show_item_check_box('check_item', $item['id'], '', 'check_' . $item['cate_id']);
                  $item_status        = show_item_status($controller_name, $item['id'], $item['status'], 'switch');
                  $show_item_buttons  = show_item_button_action($controller_name, $item['id']);
                  $show_item_view     = show_item_service_view($item);
              ?>
                <tr class="tr_<?php echo esc($item['ids']); ?>">
                  <th class="text-center w-1"><?php echo $item_checkbox; ?></th>
                  <td class="text-center w-5p text-muted"><?=show_high_light(esc($item['id']), $params['search'], 'id');?></td>
                  <td>
                    <div class="title"><?php echo show_high_light(esc($item['name']), $params['search'], 'name'); ?></div>
                  </td>
                  <td class="text-center w-10p  text-muted">
                    <?php
                      echo ($item['add_type'] == "api") ? truncate_string($item['api_name'], 13) : 'manual';
                    ?>
                    <div class="text-muted small">
                      <?=(!empty($item['api_service_id'])) ? show_high_light(esc($item['api_service_id']), $params['search'], 'api_service_id') : ""?>
                    </div>
                  </td>
                  <td class="text-center w-10p"><?php echo $item['type'];?></td>
                  <td class="text-center w-5p">
                    <div><?=(double)$item['price'];?></div>
                    <?php 
                      if (isset($item['original_price'])) {
                        $text_color = ($item['original_price'] > $item['price']) ? "text-danger" : "text-muted";
                        echo '<small class="'.$text_color.'">'.(double)$item['original_price'].'</small>';
                      }
                    ?>
                  </td>
                  <td class="text-center w-10p text-muted"><?=$item['min'] . ' / ' . $item['max']?></td>
                  <td class="text-center w-5p"> <?php echo $show_item_view;?></td>
                  <td class="text-center w-5p"><?php echo $item_status; ?></td>
                  <td class="text-center w-5p"><?php echo $show_item_buttons; ?></td>
                </tr>
              <?php }}?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php }}else{
    echo show_empty_item();
  }?>
</div>
