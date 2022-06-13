<div class="page-header">
  <h1 class="page-title">
    <i class="fe fe-calendar" aria-hidden="true"> </i> 
    <?=lang("Transaction_logs")?>
  </h1>
</div>

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
            <?php echo render_table_thead($columns, false, false, false); ?>
            <tbody>
              <?php if (!empty($items)) {
                $i = $from;
                foreach ($items as $key => $item) {
                  $i++;
                  $item_payment_type  = show_item_transaction_type($item['type']);
                  $created            = show_item_datetime($item['created'], 'long');
                  $item_status        = show_item_status($controller_name, $item['id'], $item['status'], '', 'user');
              ?>
                <tr class="tr_<?php echo $item['id']; ?>">
                  <td class="text-center w-5p text-muted"><?=$item['id']?></td>
                  <td class="text-center w-10p"><?php echo $item_payment_type ; ?></td>
                  <td class="text-center w-10p"><?php echo $item['amount']; ?></td>
                  <td class="text-center w-5p text-muted"><?php echo $item['txn_fee']; ?></td>
                  <td class="text-center w-5p text-muted"><?php echo $created; ?></td>
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
