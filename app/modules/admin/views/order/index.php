<?php 
  $show_search_area = show_search_area($controller_name, $params);
  $show_filter_status_button = show_filter_status_button($controller_name, '', $params);
?>
<style>
  .order_btn_group .list-inline-item a.btn {
    font-size: 0.9rem;
    font-weight: 400;
  }
</style>
<div class="page-title m-b-20">
  <div class="row justify-content-between">
    <div class="col-md-2">
      <h1 class="page-title">
          <span class="fa fa-list-ul"></span> Orders
      </h1>
    </div>
    
    <div class="col-md-12">
      <div class="row justify-content-between">
        <div class="col-md-8">
          <?php echo $show_filter_status_button; ?>
        </div>
        <div class="col-md-4 search-area">
          <?php echo $show_search_area; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <?php if(!empty($items)){
  ?>
    <div class="col-md-12 col-xl-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?=lang("Lists")?></h3>
          <div class="card-options">
            <?php echo show_bulk_btn_action($controller_name); ?>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-vcenter card-table">
            <?php echo render_table_thead($columns, true, false); ?>
            <tbody>
              <?php if (!empty($items)) {
                $i = $from;
                foreach ($items as $key => $item) {
                  $i++;
                  $item_checkbox      = show_item_check_box('check_item', $item['id']);
                  $item_id            = show_item_order_id($controller_name, $item, $params);
                  $item_status        = show_item_status($controller_name, $item['id'], $item['status'], '');
                  $created            = show_item_datetime($item['created'], 'long');
                  $item_details       = show_item_order_details($controller_name, $item, $params);
                  $item_buttons       = show_item_button_action($controller_name, $item['id'], '', $item);
              ?>
                <tr class="tr_<?php echo esc($item['ids']); ?>">
                  <th class="text-center w-1"><?php echo $item_checkbox; ?></th>
                  <td class="w-5p"><?php echo $item_id; ?></td>
                  <td class="text-muted w-10p"><?php echo show_high_light(esc($item['email']), $params['search'], 'email'); ?></td>
                  <td>
                    <div class="title"><?php echo $item_details; ?></div>
                  </td>
                  <td class="text-center w-10p text-muted"><?=$created;?></td>
                  <td class="text-center w-10p text-danger"><?=esc($item['note'])?></td>
                  <td class="text-center w-10p"><?php echo $item_status; ?></td>
                  <td class="text-center w-5p"><?php echo $item_buttons; ?></td>
                </tr>
              <?php }}?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php echo show_pagination($pagination); ?>
  <?php }else{
    echo show_empty_item();
  }?>
</div>
