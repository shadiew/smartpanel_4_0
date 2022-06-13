
<style>
  .tickets-number{
    font-size: 14px !important;
  }
</style>

<?php
  $CI = &get_instance();
  $CI->load->model('model');
  $total_unread_tickets = $CI->model->count_results('id', TICKETS, ['user_read' => 1, 'uid' => session('uid')]);
  $enable_item_api_menu = get_option('enable_api_tab');
?>

<?php
  $sidebar_elements = app_config('controller')['user'];
  $xhtml = '<ul class="navbar-nav mb-md-4" id="menu">';
  foreach ($sidebar_elements as $key => $item) {
    $item_name = lang($item['name']);
    if ($item['area_title']) {
      $xhtml .= sprintf('<h6 class="navbar-heading first"><span class="text">%s</span></h6>', $item_name);
    } else {
      if ($key == 'api' && !$enable_item_api_menu) {
        continue;
      }
      
      $route_name = $item['route-name'];
      $class_active = ($route_name == segment(1)) ? 'active' : '';

      $xmtml_ticket_unread_numbers = null;
      if ($key == 'tickets') {
        $xmtml_ticket_unread_numbers = sprintf('<span class="ml-auto badge badge-warning">%s</span>', $total_unread_tickets);
      }

      $xhtml .= sprintf(
        '<li class="nav-item">
          <a class="nav-link %s" href="%s" data-toggle="tooltip" data-placement="right" title="%s">
            <span class="nav-icon">
              <i class="%s"></i>
            </span>
            <span class="nav-text">
              %s
              %s
            </span>
          </a>
        </li>', $class_active, cn($route_name), $item_name, $item['icon'],  $item_name, $xmtml_ticket_unread_numbers);
    }
    
  }
  $xhtml .= '</ul>';
?>
<aside class="navbar navbar-side navbar-fixed js-sidebar" id="aside">
  <div class="mobile-logo">
    <a href="<?php echo cn('statistics'); ?>" class="navbar-brand text-inherit">
      <img src="<?=get_option('website_logo', BASE."assets/images/logo.png")?>" alt="Website Logo" class="hide-navbar-folded navbar-brand-logo">
      <img src="<?=get_option('website_logo_mark', BASE."assets/images/logo-mark.png")?>" alt="Website Logo" class="hide-navbar-expanded navbar-brand-logo">
    </a>
  </div>
  <div class="flex-fill scroll-bar">
    <?=$xhtml?>
  </div>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a href="<?php echo cn('auth/logout'); ?>" class="nav-link" data-toggle="tooltip" data-placement="right" title="<?php echo lang('Logout'); ?>">
        <span class="nav-icon"><i class="icon fe fe-power"></i>
        </span>
        <span class="nav-text"><?php echo lang('Logout'); ?></span>
      </a>
    </li>
  </ul>
</aside>