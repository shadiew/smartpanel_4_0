
<?php 
  include_once 'blocks/head.blade.php';
?>
<section class="sign-up-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><?=lang("congratulations_your_registration_is_now_complete")?></h1>
                <p><?=lang('congratulations_desc')?></p>
                <div class="form-footer">
                  <a href="<?=cn("auth/login")?>" class="btn btn-primary round btn-pill"><?=lang("get_start_now")?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
    include_once 'blocks/script.blade.php';
?>



