
<div class="row justify-content-center row-card statistics">
  <!-- header Statistic -->
  <?php
    if ($header_area) {
  ?>
    <div class="col-sm-12">
      <div class="row">
        <?php
          foreach ($header_area as $key => $item) {
        ?>
          <div class="col-sm-6 col-lg-3 item">
            <div class="card p-3">
              <div class="d-flex align-items-center">
                <span class="stamp stamp-md <?=$item['class'];?> text-white mr-3">
                  <i class="<?=$item['icon'];?>"></i>
                </span>
                <div class="d-flex order-lg-2 ml-auto">
                  <div class="ml-2 d-lg-block text-right">
                    <h4 class="m-0 text-right number"><?=$item['value'];?></h4>
                    <small class="text-muted "><?=$item['name'];?></small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php
    }
  ?>
  <!-- Chart Area -->
  <div class="col-sm-12 charts">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?=lang("recent_orders")?></h3>
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="p-4 card">
            <div id="orders_chart_spline" style="height: 20rem;"></div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="p-4 card">
            <div id="orders_chart_pie" style="height: 20rem;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      Chart_template.chart_spline('#orders_chart_spline', <?=$chart_and_orders_area['chart_spline']?>);
      Chart_template.chart_pie('#orders_chart_pie', <?=$chart_and_orders_area['chart_pie']?>);
    });
  </script>

  <!-- Orders Logs -->
  <?php
    if ($chart_and_orders_area) {
  ?>
    <div class="col-sm-12">
      <div class="row">
        <?php
          foreach ($chart_and_orders_area['orders_statistics'] as $key => $item) {
        ?>
          <div class="col-sm-6 col-lg-3 item">
            <div class="card p-3">
              <div class="d-flex align-items-center">
                <span class="stamp stamp-md text-primary mr-3">
                  <i class="<?=$item['icon'];?>"></i>
                </span>
                <div class="d-flex order-lg-2 ml-auto">
                  <div class="ml-2 d-lg-block text-right">
                    <h4 class="m-0 text-right number"><?=$item['value'];?></h4>
                    <small class="text-muted "><?=$item['name'];?></small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php
    }
  ?>
</div>

<!-- Top best Sellers -->
<?php
  $this->load->view('top_bestsellers');
?>

