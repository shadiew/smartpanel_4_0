<?php
  $setting_sidebar = [
    'general_setting' => [
      'name' => 'General setting', 'icon' => 'fe fe-disc',        'area_title' => true,  'route-name' => '#',
      'elements' => [
        'website_setting' => ['name' => 'Website setting', 'icon' => 'fe fe-globe',       'area_title' => false, 'route-name' => 'website_setting'],
        'website_logo'    => ['name' => 'Website logo',    'icon' => 'fe fe-image',       'area_title' => false, 'route-name' => 'website_logo'],
        'default'         => ['name' => 'Default setting', 'icon' => 'fe fe-box',         'area_title' => false, 'route-name' => 'default'],
        'template'        => ['name' => 'Template',        'icon' => 'fe fe-layout',         'area_title' => false, 'route-name' => 'template'],
        'cookie_policy'   => ['name' => 'Cookie policy',   'icon' => 'fe fe-bookmark',    'area_title' => false, 'route-name' => 'cookie_policy'],
        'terms_policy'    => ['name' => 'Terms policy',    'icon' => 'fe fe-award',       'area_title' => false, 'route-name' => 'terms_policy'],
        'currency'        => ['name' => 'Currency',        'icon' => 'fe fe-dollar-sign', 'area_title' => false, 'route-name' => 'currency'],
        'other'           => ['name' => 'Other',           'icon' => 'fe fe-command',     'area_title' => false, 'route-name' => 'other'],
      ],
    ],
    'email' => [
      'name'     => 'Email', 'icon' => 'fe fe-disc', 'area_title' => true,  'route-name' => '#',
      'elements' => [
        'email_setting'   => ['name' => 'Email setting',   'icon' => 'fe fe-mail',        'area_title' => false, 'route-name' => 'email_setting'],
        'email_template'  => ['name' => 'Email template',  'icon' => 'fe fe-file-text',   'area_title' => false, 'route-name' => 'email_template'],
      ],
    ],
    'integrations' => [
      'name'     => 'Integrations', 'icon' => 'fe fe-disc', 'area_title' => true, 'route-name' => '#',
      'elements' => [
        'payments' => ['name' => 'Manual payments', 'icon' => 'fe fe-file-text',   'area_title' => false, 'route-name' => 'payment'],
      ],
    ],
  ];

  $xhtml = '<div class="sidebar o-auto">';
  $i = 0;
  foreach ($setting_sidebar as $key => $item) {
      $xhtml .= sprintf('
        <div class="list-group list-group-transparent mb-0 mt-5">
          <h5><span class="icon mr-3"><i class="%s"></i></span>%s</h5>
        </div>', $item['icon'], $item['name']
      );
      if (!empty($item['elements'])) {
        $xhtml_child = '<div class="list-group list-group-transparent mb-0">';
        foreach ($item['elements'] as $element) {
          $link = admin_url('settings/' . $element['route-name']);
          $class_active = ($element['route-name'] == segment(3)) ? 'active' : '';
          $xhtml_child .= sprintf(
            '<a href="%s" class="list-group-item list-group-item-action %s"><span class="icon mr-3"><i class="%s"></i></span>%s</a>', $link, $class_active, $element['icon'],  $element['name']
          );
        }
        $xhtml_child  .= '</div>';
      }
      $i++;
      $xhtml .= $xhtml_child;
    
  }
  $xhtml .= '</div>';
  echo $xhtml;
?>
