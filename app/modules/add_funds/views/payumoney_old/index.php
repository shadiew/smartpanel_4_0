<?php

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){
  //Request hash
  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : ''; 
  if(strcasecmp($contentType, 'application/json') == 0){
    $data = json_decode(file_get_contents('php://input'));
    $hash=hash('sha512', $data->key.'|'.$data->txnid.'|'.$data->amount.'|'.$data->pinfo.'|'.$data->fname.'|'.$data->email.'|||||'.$data->udf5.'||||||'.$data->salt);
    $json=array();
    $json['success'] = $hash;
      echo json_encode($json);
  
  }
  exit(0);
}
 
function getCallbackUrl()
{
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . 'response.php';
}

$option                 = get_value($payment_params, 'option');
$min_amount             = get_value($payment_params, 'min');
$max_amount             = get_value($payment_params, 'max');
$type                   = get_value($payment_params, 'type');
$tnx_fee                = get_value($option, 'tnx_fee');
$currency_rate_to_usd   = get_value($option, 'rate_to_usd');
$currency_code          = get_value($option, 'currency_code');

$payumoney = (object)[
  'merchant_key'         => get_value($option, 'merchant_key'),
  'merchant_salt'        => get_value($option, 'merchant_salt'), 
  'productInfo'          => lang('Deposit_to_').get_option('website_name'), 
  'txnid'                => "Txn" . strtotime(NOW), 
  'response_url'         => cn('add_funds/payumoney/complete'), 
];

if (get_value($option, 'environment') == 'live') {
  $payumoney->action_url = "https://checkout-static.citruspay.com/bolt/run/bolt.min.js";
}else{
  $payumoney->action_url = "https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js";
}

?>

<section class="add-funds m-t-30">   
  <div class="container-fluid">
    <div class="row justify-content-md-center" id="result_ajaxSearch">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title"> <?=lang("payumoney_confirm_form")?></h3>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <form id="payment_form" method="post" action="#">

                <div class="form-group">
                  <label class="form-label"><?=sprintf(lang("total_amount_XX_includes_fee"), 'INR')?></label>
                  <input id="amount" name="amount" type="number" class="form-control">
                  <input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
                  <input type="hidden" id="surl" name="surl" value="<?php echo $payumoney->response_url; ?>" />
                </div>
                <div class="form-group">
                  <label class="form-label"><?=lang("user_information")?></label>
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <i class="fe fe-user"></i>
                    </span>
                    <input class="form-control" type="text" id="fname" name="fname" placeholder="<?=lang("Your_name")?>" value="" required>
                  </div>    

                  <div class="input-icon m-t-20">
                    <span class="input-icon-addon">
                      <i class="fe fe-mail"></i>
                    </span>
                    <input class="form-control" type="text" id="email" name="email" placeholder="<?=lang("Email")?>" value="" />
                  </div>

                  <div class="input-icon m-t-20">
                    <span class="input-icon-addon">
                      <i class="fe fe-phone"></i>
                    </span>
                    <input class="form-control" type="text" id="mobile" name="mobile" placeholder="Mobile/Cell Number" value="" />
                  </div>

                </div>
                <div class="form-group">
                  <span class="small"><?=lang("note")?> 
                    <ul>
                      <li>The system will convert automatically from INR to USD and add funds to your blance when payment is made</li>
                      <li>Clicking <strong class="text-danger">Return to Shop (Merchant)</strong> after payment successfully completed</li>
                    </ul>
                  </span>
                </div>
                <input type="hidden" id="key" name="key" placeholder="Merchant Key" value="<?php echo $payumoney->merchant_key; ?>" />
                <input type="hidden" id="salt" name="salt" placeholder="Merchant Salt" value="<?php echo $payumoney->merchant_salt; ?>" />
                <input type="hidden" id="txnid" name="txnid" placeholder="Transaction ID" value="<?php echo $payumoney->txnid; ?>" />
                <input type="hidden" id="pinfo" name="pinfo" placeholder="Product Info" value="<?php echo $payumoney->productInfo; ?>" />
                <input class="form-control" type="hidden" id="hash" name="hash" placeholder="Hash" value="" />
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                <!-- submit button -->
                <input type="submit" value="Pay" class="btn btn-primary btn-lg btn-block" onclick="launchBOLT(); return false;" value="<?=lang("Submit")?>">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- BOLT Production/Live //-->
<script id="bolt" src="<?php echo $payumoney->action_url; ?>" bolt-color="e34524" bolt-logo="https://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>



<script type="text/javascript"><!--
  $('#payment_form').bind('keyup blur', function(){
    var _that       = $(this),
        _action     = '<?php echo cn($module."/payumoney/request_hash"); ?>',
        _form       = _that.closest('form'),
        _data       = _that.serialize();
        _data       = _data + '&' + $.param({token:token});
    $.post( _action, _data, function(json){
      if (json['error']) {
       $('#alertinfo').html('<i class="fa fa-info-circle"></i>'+json['error']);
      } else if (json['success']) {
        $('#hash').val(json['success']);
      }
    },'json')
   
  });
//-->
</script>
<script type="text/javascript"><!--
  function launchBOLT()
  {
    bolt.launch({
    key: $('#key').val(),
    txnid: $('#txnid').val(), 
    hash: $('#hash').val(),
    amount: $('#amount').val(),
    firstname: $('#fname').val(),
    email: $('#email').val(),
    phone: $('#mobile').val(),
    productinfo: $('#pinfo').val(),
    udf5: $('#udf5').val(),
    surl : $('#surl').val(),
    furl: $('#surl').val(),
    mode: 'dropout' 
  },{ responseHandler: function(BOLT){
    console.log( BOLT.response.txnStatus );   
    if(BOLT.response.txnStatus != 'CANCEL')
    {
      //Salt is passd here for demo purpose only. For practical use keep salt at server side only.
      var fr = '<form action=\"'+$('#surl').val()+'\" method=\"post\">' +
      '<input type=\"hidden\" name=\"key\" value=\"'+BOLT.response.key+'\" />' +
      '<input type=\"hidden\" name=\"salt\" value=\"'+$('#salt').val()+'\" />' +
      '<input type=\"hidden\" name=\"txnid\" value=\"'+BOLT.response.txnid+'\" />' +
      '<input type=\"hidden\" name=\"amount\" value=\"'+BOLT.response.amount+'\" />' +
      '<input type=\"hidden\" name=\"productinfo\" value=\"'+BOLT.response.productinfo+'\" />' +
      '<input type=\"hidden\" name=\"firstname\" value=\"'+BOLT.response.firstname+'\" />' +
      '<input type=\"hidden\" name=\"email\" value=\"'+BOLT.response.email+'\" />' +
      '<input type=\"hidden\" name=\"udf5\" value=\"'+BOLT.response.udf5+'\" />' +
      '<input type=\"hidden\" name=\"mihpayid\" value=\"'+BOLT.response.mihpayid+'\" />' +
      '<input type=\"hidden\" name=\"status\" value=\"'+BOLT.response.status+'\" />' +
      '<input type=\"hidden\" name=\"hash\" value=\"'+BOLT.response.hash+'\" />' +
      '</form>';
      var form = jQuery(fr);
      jQuery('body').append(form);                
      form.submit();
    }
  },
    catchException: function(BOLT){
      alert( BOLT.message );
    }
  });
  }
</script> 
