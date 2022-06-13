<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <?php 
      include 'elements/head.blade.php';
    ?>
  </head>
  <body class="antialiased vertical-menu">

    <div id="page-overlay" class="visible incoming">
      <div class="loader-wrapper-outer">
        <div class="loader-wrapper-inner">
          <div class="lds-double-ring">
            <div></div>
            <div></div>
            <div>
              <div></div>
            </div>
            <div>
              <div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php 
      include_once 'blocks/header_vertical.php';
    ?>
    <div class="d-flex flex-row h-100p">
      <?php include 'blocks/sidebar.php'; ?>
      <div class="layout-main d-flex flex-column flex-fill max-w-full">
        <main class="app-content">
          <?php echo $template['body']; ?>
        </main>
      </div>
    </div>
    <!-- modal -->
    <div id="modal-ajax" class="modal fade" tabindex="-1"></div>
    <!-- Theme Settings -->
    <?php
      include 'blocks/theme_settings.php';
    ?>
    <!-- Scripts -->
    <?php 
      include 'elements/script.blade.php';
    ?>
  </body>
</html>
