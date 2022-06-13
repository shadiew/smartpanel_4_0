<div class="page-title m-b-20">
  <div class="row justify-content-between">
    <div class="col-md-10">
      <h1 class="page-title">
        <span class="fa fa-list-ul"></span> Import Services
      </h1>
    </div>
    <div class="col-md-2">
      <?php
        array_unshift($items_provider, ['id' => 0, 'name' => 'Choose provider']);
        $items_provider = array_column($items_provider, 'name', 'id');
        echo form_dropdown('provider', $items_provider, '', ['data-url' => admin_url($controller_name . '/services/'),'class' => 'form-select m-t-4 m-r-10 ajaxGetServicesChangeByProvider']);
      ?>
    </div>
  </div>
</div>

<div class="row" id="result_html">
  <?php if ($item && $item_services) {
    $this->load->view('child/services', ['item' => $item, 'item_services' => $item_services]);
  }else{
    echo show_empty_item();
  }?>
</div>