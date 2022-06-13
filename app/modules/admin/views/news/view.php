<div id="main-modal-content" class="news_announcement">
  <div class="modal-right">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-pantone">
          <h4 class="modal-title"><i class="fe fe-award"></i> <?=lang("whats_new_on_smartpanel")?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body o-auto" >
          <?php
            if (!empty($items)) {
          ?>
          <?php
            $i = 0;
            foreach ($items as $key => $item) {
              switch ($item['type']) {
                case 'new_services':
                  $type  = lang("New_services");
                  $color = "btn-info";
                  break;
                case 'disabled_services':
                  $type = lang("Disabled_services");
                  $color = "btn-orange";
                  break;
                case 'updated_services':
                  $type = lang("Updated_services");
                  $color = "btn-lime";
                  break;
                case 'announcement':
                  $type = lang("Announcement");
                  $color = "btn-primary";
                  break;
              }
          ?>
            <div class="news-item">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title btn round <?=$color?> btn-sm text-uppercase"><?=$type?></h3>
                  <small class="text-muted m-l-5"><?=date("d/m/Y" , strtotime(convert_timezone($item['created'], 'user')))?></small>
                </div>
                <div class="card-body desc">
                  <?=htmlspecialchars_decode($item['description'], ENT_QUOTES)?>
                </div>
              </div>
            </div>
          <?php }}else{ 
            echo show_empty_item(); 
          }?>

        </div>
      </div>
    </div>
  </div>
</div>
