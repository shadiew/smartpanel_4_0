<?php
	$data_search = [];
	$requests    = [];
	$fetch_class = segment(1);
	$fetch_method = segment(2);

	if (in_array($fetch_class, ['services'])) {
		$requests = [
			'method' => 'POST',
			'action' => cn($fetch_class."/ajax_search"),
			'class'  => 'ajaxSearchItemsKeyUp',
		];
	}else{
		$requests = [
			'method' => 'GET',
			'action' => cn($fetch_class."/search"),
			'class'  => '',
		];
	}
?>

<form class="<?php echo $requests['class']; ?>" method="<?php echo $requests['method']; ?>" action="<?php echo $requests['action']; ?>">
	<div class="form-group">
	  <div class="input-group">
	    <input type="text" class="form-control" name="query" id="search-item" placeholder="<?=lang("Search_for_")?>" value="<?php echo get('query'); ?>">
	    <div class="input-group-append">
	      	<button class="btn btn-secondary btn-searchItem"  type="submit"><i class="fe fe-search"></i></button>
	    </div>
	  </div>
	</div>
</form>
