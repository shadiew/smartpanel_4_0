<?php 
  // Page header
  echo show_page_header($controller_name, ['page-options' => '', 'page-options-type' => '']);
  // Page header Filter
  echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
?>

<div class="row">
  <?php if(!empty($items)){
  ?>
    <div class="col-md-12 col-xl-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?=lang("Lists")?></h3>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-vcenter card-table">
            <?php echo render_table_thead($columns, false); ?>
            <tbody>
              <?php if (!empty($items)) {
                $i = $from;
                foreach ($items as $key => $item) {
                  $i++;
                  $item_payment_type  = show_item_transaction_type($item['type']);
                  $created            = show_item_datetime($item['created'], 'long');
                  $show_item_buttons  = show_item_button_action($controller_name, $item['id']);
                  $item_status        = show_item_status($controller_name, $item['id'], $item['status'], '', '');
              ?>
                <tr class="tr_<?php echo esc($item['ids']); ?>">
                  <td class="text-center text-muted"><?=$item['id']?></td>
                  <td><?php echo show_high_light(esc($item['email']), $params['search'], 'email'); ?></td>
                  <td class="text-center w-10p"><?php echo show_high_light(esc($item['transaction_id']), $params['search'], 'transaction_id'); ?></td>
                  <td class="text-center w-10p"><?php echo $item_payment_type ; ?></td>
                  <td class="text-center w-10p"><?php echo $item['amount']; ?></td>
                  <td class="text-center w-5p text-muted"><?php echo $item['txn_fee']; ?></td>
                  <td class="text-center w-10p"><?php echo show_high_light(esc($item['note']), $params['search'], 'note'); ?></td>
                  <td class="text-center w-10p text-muted"><?php echo $created; ?></td>
                  <td class="text-center w-5p"><?php echo $item_status; ?></td>
                  <td class="text-center w-5p"><?php echo $show_item_buttons; ?></td>
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
