<?php
  foreach ($items as $key => $item_category) {
?>
  <div class="col-md-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $key; ?></h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-vcenter card-table">
          <?php 
            echo render_table_thead($columns, false, false, false); 
          ?>
          <tbody>
            <?php if (!empty($item_category)) {
              foreach ($item_category as $key => $item) {
                $show_item_view     = show_item_service_view($item);
                $item_price         = show_item_rate($item, $items_custom_rate, 'user');
            ?>
              <tr class="tr_<?php echo esc($item['id']); ?>">
                <td class="text-center w-10p text-muted"><?=esc($item['id']);?></td>
                <td>
                  <div class="title"><?=esc($item['name']);?></div>
                </td>
                <td class="text-center w-5p"><div><?=$item_price ;?></div></td>
                <td class="text-center w-10p text-muted"><?=$item['min'] . ' / ' . $item['max']?></td>
                <td class="text-center w-5p"> <?php echo $show_item_view;?></td>
              </tr>
            <?php }}?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php } ?>