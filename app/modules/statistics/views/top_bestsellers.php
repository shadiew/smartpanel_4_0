<?php
  $columns     =  array(
    "id"                => ['name' => lang("Name"),    'class' => ''],
    "order_details"     => ['name' => lang("rate_per_1000"), 'class' => 'text-center'],
    "created"           => ['name' => lang("min__max_order"), 'class' => 'text-center'],
    "status"            => ['name' => lang("Description"),  'class' => 'text-center'],
  );
?>

<?php
  if ($items_top_best_seller) {
?>
  <div class="row justify-content-center">
    <div class="col-md-12 col-xl-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?php echo lang("top_bestsellers"); ?></h3>
          <div class="card-options">
            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-vcenter card-table">
            <?php 
              echo render_table_thead($columns, false, true, false, []); 
            ?>
            <tbody>
              <?php
                foreach ($items_top_best_seller as $key => $item) {
                  $show_item_view     = show_item_service_view($item);
              ?>
                <tr class="tr_<?php echo esc($item['id']); ?>">
                  <td class="text-center w-10p text-muted"><?=esc($item['id']);?></td>
                  <td>
                    <div class="title"><?=esc($item['name']);?></div>
                  </td>
                  <td class="text-center w-5p"><div><?=$item['price'] ;?></div></td>
                  <td class="text-center w-10p text-muted"><?=$item['min'] . ' / ' . $item['max']?></td>
                  <td class="text-center w-5p"> <?php echo $show_item_view;?></td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php } ?>