<style>
  .search-box input.form-control{
    margin: -1px;
  }
  .search-box select.form-control{
    border-radius: 0px;
    border: 1px solid #fff;
  }
</style>
<?php
  $CI = &get_instance();
  $CI->load->model('model', 'model');
  $total_unread_tickets = $CI->model->count_results('id', TICKETS, ['user_read' => 1, 'uid' => session('uid')]);
?>

<div class="header top  py-4">
  <div class="container">
    <div class="d-flex">
      <a class="" href="<?=cn('statistics')?>">
        <img src="<?=get_option('website_logo_white', BASE."assets/images/logo-white.png")?>" alt="Website logo" style="max-height: 40px;">
      </a>
      <div class="d-flex order-lg-2 ml-auto my-auto search-box">
        <div class="search-box m-r-30 d-none d-lg-block">
          <?php
            if ( allowed_search_bar(segment(1)) || allowed_search_bar(segment(2)) ) {
              echo Modules::run("blocks/search_box");
            }
          ?>
        </div>
        
        <?php
          if (session('uid_tmp')) {
        ?>
        <div class="notifcation m-r-10">
          <a  class="ajaxViewUser" href="<?=cn("back-to-admin")?>" data-toggle="tooltip" data-placement="bottom" title="<?=lang('Back_to_Admin')?>" class="text-white ajaxBackToAdmin">
            <i class="fe fe-log-out"></i>
          </a>
        </div>
        <?php } ?>
        <?php
          if (get_option("enable_news_announcement") == 1) {
        ?>
        <div class="notifcation">
          <a href="<?=cn("news-annoucement")?>" data-toggle="tooltip" data-placement="bottom" title="<?=lang("news__announcement")?>" class="ajaxModal text-white">
            <i class="fe fe-bell"></i>
            <div class="test">
              <span class="nav-unread <?=(isset($_COOKIE["news_annoucement"]) && $_COOKIE["news_annoucement"] == "clicked") ? "" : "change_color"?>"></span>
            </div>
          </a>
        </div>
        <?php }?>
        <div class="dropdown">
          <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
            <span class="avatar" style="background-image: url(<?=BASE?>assets/images/user-avatar.png)"></span>
            <span class="ml-2 d-none d-lg-block">
              <span class="text-default text-white"><?php echo lang('Hi'); ?>! <span class="text-uppercase"><?php echo current_logged_user()->first_name; ?></span>!</span>
              <small class="text-muted  text-white d-block mt-1">
                <?php
                  $balance = current_logged_user()->balance;
                  if (empty($balance) || $balance == 0) {
                    $balance = 0.00;
                  }else{
                    $balance = currency_format($balance);
                  }
                  echo get_option('currency_symbol',"$") . $balance;
                ?>
              </small>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <a class="dropdown-item" href="<?=cn('profile')?>">
              <i class="dropdown-icon fe fe-user"></i> <?=lang("Profile")?>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?=cn("auth/logout")?>">
              <i class="dropdown-icon fe fe-log-out"></i> <?=lang("Sign_out")?>
            </a>
          </div>
        </div>
      </div>
      <a href="#" class="header-toggler text-white d-lg-none ml-3 ml-lg-0 my-auto" data-toggle="collapse" data-target="#headerMenuCollapse">
        <span class="header-toggler-icon"></span>
      </a>
    </div>
  </div>
</div>

<?php
  $header_elements = app_config('controller')['user'];
?>
<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg order-lg-first">
        <ul class="nav nav-tabs border-0 flex-column flex-lg-row">

          <li class="nav-item">
            <a href="<?=cn($header_elements['statistics']['route-name']); ?>" class="nav-link <?=(segment(1) == $header_elements['statistics']['route-name'])? "active" : "" ?>"><i class="<?=$header_elements['statistics']['icon']; ?>"></i> <?=lang($header_elements['statistics']['name']); ?></a>
          </li>   

          <li class="nav-item">
            <a href="<?=cn($header_elements['new_order']['route-name']); ?>" class="nav-link <?=(segment(1) == $header_elements['new_order']['route-name'])? "active" : "" ?>"><i class="<?=$header_elements['new_order']['icon']; ?>"></i> <?=lang($header_elements['new_order']['name']); ?></a>
          </li>   

          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link  <?=(in_array(segment(1), ['order', 'dripfeed', 'subscriptions']))?"active":""?>" data-toggle="dropdown"><i class="fe fe-inbox"></i><?=lang('Order')?></a>
            <div class="dropdown-menu dropdown-menu-arrow">
              <a href="<?=cn($header_elements['order']['route-name'])?>" class="dropdown-item "><?=lang($header_elements['order']['name']); ?></a>
              <a href="<?=cn($header_elements['dripfeed']['route-name'])?>" class="dropdown-item "><?=lang($header_elements['dripfeed']['name']); ?></a>
              <a href="<?=cn($header_elements['subscriptions']['route-name'])?>" class="dropdown-item "><?=lang($header_elements['subscriptions']['name']); ?></a>
            </div>
          </li>

          <li class="nav-item">
            <a href="<?=cn($header_elements['services']['route-name']); ?>" class="nav-link <?=(segment(1) == $header_elements['services']['route-name'])? "active" : "" ?>"><i class="<?=$header_elements['services']['icon']; ?>"></i> <?=lang($header_elements['services']['name']); ?></a>
          </li>   
          
          <?php 
            if (get_option('enable_api_tab')) {
              ?>      
            <li class="nav-item">
              <a href="<?=cn($header_elements['api']['route-name']); ?>" class="nav-link <?=(segment(2) == 'docs')?"active":""?>"><i class="<?=$header_elements['api']['icon']; ?>"></i> <?=lang($header_elements['api']['name']); ?></a>
            </li>   
          <?php }?>   
                 
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link <?=(in_array(segment(1), ['tickets', 'faq'])) ? "active":""?>" data-toggle="dropdown"><i class="fa fa-comments-o"></i>
              <?=lang('Support')?> <span class="badge badge-info"><?=$total_unread_tickets?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow">
              <a href="<?=cn($header_elements['tickets']['route-name'])?>" class="dropdown-item ">
                <?=lang($header_elements['tickets']['name']); ?>
                <span class="badge badge-info"><?=$total_unread_tickets?></span>
              </a>
              <a href="<?=$header_elements['faq']['route-name']?>" class="dropdown-item "><?=lang($header_elements['faq']['name']); ?></a>
            </div>
          </li>
          
          <li class="nav-item">
            <a href="<?=cn($header_elements['add_funds']['route-name']); ?>" class="nav-link <?=(segment(1) == $header_elements['add_funds']['route-name'])? "active" : "" ?>"><i class="<?=$header_elements['add_funds']['icon']; ?>"></i> <?=lang($header_elements['add_funds']['name']); ?></a>
          </li>   
          <li class="nav-item">
            <a href="<?=cn($header_elements['transactions']['route-name']); ?>" class="nav-link <?=(segment(1) == $header_elements['transactions']['route-name'])? "active" : "" ?>"><i class="<?=$header_elements['transactions']['icon']; ?>"></i> <?=lang($header_elements['transactions']['name']); ?></a>
          </li>   
          
        </ul>
      </div>
    </div>
  </div>
</div>
