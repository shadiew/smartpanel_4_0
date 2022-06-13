<?php
  $form_url = admin_url($controller_name."/store/");
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => get_current_url(), 'method' => "POST");
?>
<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-edit-3"></i> <?=lang("terms__policy")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 col-lg-12">
      
          <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("content_of_terms")?></h5 class="text-info">
          <div class="form-group">
            <label class="form-label"><?=lang("Content")?></label>
            <textarea rows="3" name="terms_content" id="terms_content" class="form-control plugin_editor"><?=get_option('terms_content', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet, in eam consetetur consectetuer. Vivendo eleifend postulant ut mei, vero maiestatis cu nam. Qui et facer mandamus, nullam regione lucilius eu has. Mei an vidisse facilis posidonium, eros minim deserunt per ne.</p><p>Duo quando tibique intellegam at. Nec error mucius in, ius in error legendos reformidans. Vidisse dolorum vulputate cu ius. Ei qui stet error consulatu.</p><p>Mei habeo prompta te. Ignota commodo nam ei. Te iudico definitionem sed, placerat oporteat tincidunt eu per, stet clita meliore usu ne. Facer debitis ponderum per no, agam corpora recteque at mel.</p>")?>
            </textarea>
          </div>

          <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("content_of_policy")?></h5 class="text-info">
          <div class="form-group">
            <label class="form-label"><?=lang("Content")?></label>
            <textarea rows="3" name="policy_content" id="policy_content" class="form-control plugin_editor"><?=get_option('policy_content', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet, in eam consetetur consectetuer. Vivendo eleifend postulant ut mei, vero maiestatis cu nam. Qui et facer mandamus, nullam regione lucilius eu has. Mei an vidisse facilis posidonium, eros minim deserunt per ne.</p><p>Duo quando tibique intellegam at. Nec error mucius in, ius in error legendos reformidans. Vidisse dolorum vulputate cu ius. Ei qui stet error consulatu.</p><p>Mei habeo prompta te. Ignota commodo nam ei. Te iudico definitionem sed, placerat oporteat tincidunt eu per, stet clita meliore usu ne. Facer debitis ponderum per no, agam corpora recteque at mel.</p>")?>
            </textarea>
          </div> 

        </div>
      </div>
    </div>
    <div class="card-footer text-end">
      <button class="btn btn-primary btn-min-width text-uppercase"><?=lang("Save")?></button>
    </div>
  <?php echo form_close(); ?>
</div>
<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 500});
  });
</script>