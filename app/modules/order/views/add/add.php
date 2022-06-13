<?php
  $items_category = array_column($items_category, 'id', 'name');
  $form_items_category = array_flip(array_intersect_key($items_category, array_flip(array_keys($items_service))));
?>
<div class="row justify-content-md-center justify-content-xl-center m-t-30" id="result_ajaxSearch">
  <div class="col-md-10 col-xl-10 ">
    <div class="card">
      <div class="card-header d-flex align-items-center">
        <div class="tabs-list">
          <ul class="nav nav-tabs">
            <li class="">
              <a class="active show" data-toggle="tab" href="#new_order"><i class="fa fa-clone"></i> <?=lang("single_order")?></a>
            </li>
            <li>
              <a data-toggle="tab" href="#mass_order"><i class="fa fa-sitemap"></i> <?=lang("mass_order")?></a>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-body">
        <div class="tab-content">
          <div id="new_order" class="tab-pane fade in active show">
            <form class="form actionForm" action="<?=cn($controller_name . "/ajax_add_order")?>" data-redirect="<?=cn('new_order')?>" method="POST">
              <div class="row">
                <div class="col-md-6">
                  <div class="content-header-title">
                    <h4><i class="fa fa-shopping-cart"></i> <?=lang('add_new')?></h4>
                  </div>
                  <div class="form-group">
                    <label><?=lang("Category")?></label>
                    <select name="category_id" class="form-control square ajaxChangeCategory" data-url="<?=cn($controller_name."/get_services/")?>">
                      <option> <?=lang("choose_a_category")?></option>
                      <?php
                        if (!empty($form_items_category)) {

                          foreach ($form_items_category as $key => $category) {
                      ?>
                        <option value="<?=$key?>"><?=$category; ?></option>
                      <?php }}?>
                    </select>
                  </div>
                  <div class="form-group" id="result_onChange">
                    <label><?=lang("order_service")?></label>
                    <select name="service_id" class="form-control square ajaxChangeService" data-url="<?=cn($controller_name."/get_service/")?>">
                      <option> <?=lang("choose_a_service")?></option>
                    </select>
                  </div>

                  <!-- Min/max on responsive d-md-none-->
                  <div class="row d-none">
                    <div class="col-md-4  col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("minimum_amount")?></label>
                        <input class="form-control square" name="service_min" type="text" value="" readonly>
                      </div>
                    </div>

                    <div class="col-md-4  col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("maximum_amount")?></label>
                        <input class="form-control square" name="service_max" type="text" value="" readonly>
                      </div>
                    </div>

                    <div class="col-md-4  col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("price_per_1000")?></label>
                        <input class="form-control square" name="service_price" type="text" value="" readonly>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group order-default-link">
                    <label><?=lang("Link")?></label>
                    <input class="form-control square" type="text" name="link" placeholder="https://" id="">
                  </div>

                  <div class="form-group order-default-quantity">
                    <label><?=lang("Quantity")?></label>
                    <input class="form-control square ajaxQuantity" name="quantity" type="number">
                  </div>
                  
                  <div class="form-group order-comments d-none">
                    <label for=""><?=lang("Comments")?> <?php lang('1_per_line')?></label>
                    <textarea  rows="10" name="comments" class="form-control square ajax_custom_comments"></textarea>
                  </div> 

                  <div class="form-group order-comments-custom-package d-none">
                    <label for=""><?=lang("Comments")?> <?php lang('1_per_line')?></label>
                    <textarea  rows="10" name="comments_custom_package" class="form-control square"></textarea>
                  </div>

                  <div class="form-group order-usernames d-none">
                    <label for=""><?=lang("Usernames")?></label>
                    <input type="text" class="form-control input-tags" name="usernames" value="usenameA,usenameB,usenameC,usenameD">
                  </div>

                  <div class="form-group order-usernames-custom d-none">
                    <label for=""><?=lang("Usernames")?> <?php lang('1_per_line')?></label>
                    <textarea  rows="10" name="usernames_custom" class="form-control square ajax_custom_lists"></textarea>
                  </div>

                  <div class="form-group order-hashtags d-none">
                    <label for=""><?=lang("hashtags_format_hashtag")?></label>
                    <input type="text" class="form-control input-tags" name="hashtags" value="#goodphoto,#love,#nice,#sunny">
                  </div>

                  <div class="form-group order-hashtag d-none">
                    <label for=""><?=lang("Hashtag")?> </label>
                    <input class="form-control square" type="text" name="hashtag">
                  </div>

                  <div class="form-group order-username d-none">
                    <label for=""><?=lang("Username")?></label>
                    <input class="form-control square" name="username" type="text">
                  </div>   
                  
                  <!-- Mentions Media Likers -->
                  <div class="form-group order-media d-none">
                    <label for=""><?=lang("Media_Url")?></label>
                    <input class="form-control square" name="media_url" type="link">
                  </div>

                  <!-- Subscriptions  -->
                  <div class="row order-subscriptions d-none">

                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?=lang("Username")?></label>
                        <input class="form-control square" type="text" name="sub_username">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?=lang("New_posts")?></label>
                        <input class="form-control square" type="number" placeholder="<?=lang("minimum_1_post")?>" name="sub_posts">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?=lang("Quantity")?></label>
                        <input class="form-control square" type="number" name="sub_min" placeholder="<?=lang("min")?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <input class="form-control square" type="number" name="sub_max" placeholder="<?=lang("max")?>">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?=lang("Delay")?> (<?=lang("minutes")?>)</label>
                        <select name="sub_delay" class="form-control square">
                          <option value="0"><?=lang("")?><?=lang("No_delay")?></option>
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                          <option value="30">30</option>
                          <option value="60">60</option>
                          <option value="90">90</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?=lang("Expiry")?></label>
                        <div class="input-group">
                          <input type="text" class="form-control datepicker" name="sub_expiry" onkeydown="return false" name="expiry" placeholder="" id="expiry">
                          <span class="input-group-append">
                            <button class="btn btn-info" type="button" onclick="document.getElementById('expiry').value = ''"><i class="fe fe-trash-2"></i></button>
                          </span>
                        </div>
                      </div>
                    </div>

                  </div>
                  <?php
                    if (get_option("enable_drip_feed","") == 1) {
                  ?>
                  <div class="row drip-feed-option d-none">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="form-label"><?=lang("dripfeed")?> 
                          <label class="custom-switch">
                            <span class="custom-switch-description m-r-20"><i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?=lang("drip_feed_desc")?>" data-title="<?=lang("what_is_dripfeed")?>"></i></span>
                            <input type="checkbox" name="is_drip_feed" class="is_drip_feed custom-switch-input" data-toggle="collapse" data-target="#drip-feed" aria-expanded="false" aria-controls="drip-feed">
                            <span class="custom-switch-indicator"></span>
                          </label>
                        </div>
                      </div>

                      <div class="row collapse" id="drip-feed">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><?=lang("Runs")?></label>
                            <input class="form-control square ajaxDripFeedRuns" type="number" name="runs" value="<?=get_option("default_drip_feed_runs", "")?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><?=lang("interval_in_minutes")?></label>
                            <select name="interval" class="form-control square">
                              <?php
                                for ($i = 1; $i <= 60; $i++) {
                                  if ($i%10 == 0) {
                              ?>
                              <option value="<?=$i?>" <?=(get_option("default_drip_feed_interval", "") == $i)? "selected" : ''?>><?=$i?></option>
                              <?php }} ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label><?=lang("total_quantity")?></label>
                            <input class="form-control square" name="total_quantity" type="number" disabled>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php }?>
                  <div class="form-group" id="result_total_charge">
                    <input type="hidden" name="total_charge" value="0.00">
                    <input type="hidden" name="currency_symbol" value="<?=get_option("currency_symbol", "")?>">
                    <p class="btn btn-info total_charge"><?=lang("total_charge")?> <span class="charge_number">$0</span></p>
                    
                    <?php
                      $user = $this->model->get("balance, custom_rate", 'general_users', ['id' => session('uid')]);
                      if ($user->custom_rate > 0 ) {
                    ?>
                    <p class="small text-muted"><?=lang("custom_rate")?>: <span class="charge_number"><?=$user->custom_rate?>%</span></p>
                    <?php }?>
                    <div class="alert alert-icon alert-danger d-none" role="alert">
                      <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i><?=lang("order_amount_exceeds_available_funds")?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="agree">
                      <span class="custom-control-label text-uppercase"><?=lang("yes_i_have_confirmed_the_order")?></span>
                    </label>
                  </div>

                  <div class="form-actions left">
                    <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1">
                      <?=lang("place_order")?>
                    </button>

                  </div>
                </div>  

                <div class="col-md-6 order_resume" id="order_resume">
                  <div class="content-header-title">
                    <h4><i class="fa fa-shopping-cart"></i> <?=lang("order_resume")?></h4>
                  </div>
                  <div class="row" id="result_onChangeService">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("service_name")?></label>
                        <input type="hidden" name="service_id" id="service_id" value="<?=(!empty($service_item_default->id))? $service_item_default->id :''?>">
                        <input class="form-control square" name="service_name" type="text" readonly>
                      </div>
                    </div>   

                    <div class="col-md-4  col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("minimum_amount")?></label>
                        <input class="form-control square" name="service_min" type="text" readonly>
                      </div>
                    </div>

                    <div class="col-md-4  col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("maximum_amount")?></label>
                        <input class="form-control square" name="service_max" type="text" readonly>
                      </div>
                    </div>

                    <div class="col-md-4  col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label><?=lang("price_per_1000")?></label>
                        <input class="form-control square" name="service_price" type="text" readonly>
                      </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label for="userinput8"><?=lang("Description")?></label>
                        <textarea  rows="10" name="service_desc" class="form-control square" readonly>
                        </textarea>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </form>
          </div>
          <div id="mass_order" class="tab-pane fade">
            <form class="form actionForm" action="<?=cn($controller_name."/ajax_mass_order")?>" data-redirect="<?=cn($controller_name."/log")?>" method="POST">
              <div class="x_content row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="content-header-title">
                    <h6> <?=lang("one_order_per_line_in_format")?></h6>
                  </div>
                  <div class="form-group">
                    <textarea id="editor" rows="14" name="mass_order" class="form-control square" placeholder="service_id|quantity|link"></textarea>
                  </div>
                  <div class="form-group">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="agree">
                      <span class="custom-control-label text-uppercase"><?=lang("yes_i_have_confirmed_the_order")?></span>
                    </label>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="mass_order_error" id="result_notification">
                    <div class="content-header-title">
                      <h6><i class="fa fa-info-circle"></i> <?=lang("note")?></h6>
                    </div>
                    <div class="form-group">
                      <?=lang("here_you_can_place_your_orders_easy_please_make_sure_you_check_all_the_prices_and_delivery_times_before_you_place_a_order_after_a_order_submited_it_cannot_be_canceled")?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-actions left">
                <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
                  <?=lang("place_order")?>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .page-title h1{
    margin-bottom: 5px; }
    .page-title .border-line {
      height: 5px;
      width: 250px;
      background: #eca28d;
      background: -webkit-linear-gradient(45deg, #eca28d, #f98c6b) !important;
      background: -moz- oldlinear-gradient(45deg, #eca28d, #f98c6b) !important;
      background: -o-linear-gradient(45deg, #eca28d, #f98c6b) !important;
      background: linear-gradient(45deg, #eca28d, #f98c6b) !important;
      position: relative;
      border-radius: 30px; }
    .page-title .border-line::before {
      content: '';
      position: absolute;
      left: 0;
      top: -2.7px;
      height: 10px;
      width: 10px;
      border-radius: 50%;
      background: #fa6d7e;
      -webkit-animation-duration: 6s;
      animation-duration: 6s;
      -webkit-animation-timing-function: linear;
      animation-timing-function: linear;
      -webkit-animation-iteration-count: infinite;
      animation-iteration-count: infinite;
      -webkit-animation-name: moveIcon;
      animation-name: moveIcon; }

  @-webkit-keyframes moveIcon {
    from {
      -webkit-transform: translateX(0);
    }
    to { 
      -webkit-transform: translateX(250px);
    }
  }
</style>

<?php
  if (get_option('enable_attentions_orderpage')) {
?>
<div class="row justify-content-center m-t-50">
  <div class="col-md-10">
    <div class="page-title m-b-30">
      <h1>
        <?php echo get_option('title_attentions_orderpage',"Guides & Descriptions"); ?>
      </h1>
      <div class="border-line"></div>
    </div>
    <div class="content m-t-30">
      <?php echo get_option("guides_and_desc", ""); ?>
    </div>
  </div> 
</div>
<?php }; ?>


<script>
  $(function(){
    $('.datepicker').datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
      startDate: truncateDate(new Date())
    });
    $(".datepicker").datepicker().datepicker("setDate", new Date());

    function truncateDate(date) {
      return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

    $('.input-tags').selectize({
        delimiter: ',',
        persist: false,
        create: function (input) {
            return {
                value: input,
                text: input
            }
        }
    });
  });
</script>
