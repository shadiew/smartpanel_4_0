
<div class="page-header">
  <h1 class="page-title">
    <span><i class="fe fe-help-circle" aria-hidden="true"></i></span>
    <?=lang("FAQs")?>
  </h1>
</div>

<div class="row" id="result_ajaxSearch">

  <?php if(!empty($items)){
    foreach ($items as $key => $item) {
  ?>
  <div class="col-md-12 col-xl-12 tr_<?=$item['ids']?>">
    <div class="card card-collapsed">
      <div class="card-header">
        <h3 class="card-title" data-toggle="card-collapse">
          <span class="bg-question"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
          <?=$item['question']?>
        </h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body">
        <?=$item['answer']?>
      </div>
    </div>
  </div>
  <?php }}else{ 
    echo show_empty_item(); 
  }?>
</div>

