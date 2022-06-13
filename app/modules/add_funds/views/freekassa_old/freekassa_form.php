<?php
  $payments = array(
    '133'  => 'FK WALLET RUB',
    '80'   => 'Сбербанк RUR',
    '179'  => 'MAMASTERCARD/VISA RUB',
    '155'  => 'QIWI WALLET RUB',
    '128'  => 'QIWI',
    '63'   => 'QIWI кошелек RUB',
    '161'  => 'QIWI EURO',
    '123'  => 'QIWI USD',
    '45'   => 'Yandex',
    '175'  => 'Яндекс-Деньги ',
    '162'  => 'QIWI KZT',
    '153'  => 'VISA/MASTERCARD + RUB',
    '159'  => 'CARD P2P',
    '94'   => 'VISA/MASTERCARD RUB ',
    '67'   => 'VISA/MASTERCARD UAH',
    '100'  => 'VISA/MASTERCARD USD',
    '124'  => 'VISA/MASTERCARD EUR',
    '160'  => 'VISA/MASTERCARD RUB',
    '181'  => 'Tether USDT',
    '184'  => 'ADVCASH KZT',
    '136'  => 'ADVCASH USD',
    '150'  => 'ADVCASH RUB',
    '183'  => 'ADVCASH EUR',
    '180'  => 'Exmo RUB',
    '174'  => 'Exmo USD',
    '147'  => 'Litecoin',
    '166'  => 'BitcoinCash ABC',
    '172'  => 'Monero',
    '173'  => 'Ripple',
    '163'  => 'Ethereum',
    '167'  => 'Blackcoin BLK',
    '168'  => 'Dogecoin DOGE',
    '169'  => 'Emercoin EMC',
    '170'  => 'Primecoin XMP',
    '171'  => 'Reddcoin RDD',
    '165'  => 'ZCASH',
    '164'  => 'DASH',
    '116'  => 'Bitcoin',
    '105'  => 'WMR (VIP)',
    '154'  => 'Skin pay STEEM PAY',
    '106'  => 'OOOPAY RUR',
    '87'   => 'OOOPAY USD',
    '109'  => 'OOOPAY EUR',
    '121'  => 'WMR',
    '131'  => 'WMZ-bill',
    '130'  => 'WMR-bill',
    '1'    => 'WebMoney WMR',
    '2'    => 'WebMoney WMZ',
    '3'    => 'WebMoney WME',
    '114'  => 'PAYEER RUB',
    '115'  => 'PAYEER USD',
    '64'   => 'Perfect Money USD',
    '69'   => 'Perfect Money EUR',
    '79'   => 'Альфа-банк RUR',
    '110'  => 'Промсвязьбанк',
    '113'  => 'Русский стандарт',
    '82'   => 'Мобильный Платеж Мегафон',
    '84'   => 'Мобильный Платеж МТС',
    '132'  => 'Мобильный Платеж Tele2',
    '83'   => 'Мобильный Платеж Билайн',
    '99'   => 'Терминалы России',
    '118'  => 'Салоны связи',
    '117'  => 'Денежные переводы WU',
    '70'   => 'PayPal',
  );
?>

<section class="add-funds m-t-30">   
  <div class="container-fluid">
    <div class="row justify-content-md-center" id="result_ajaxSearch">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title text-uppercase"> <?=lang('freekassa_confirm_form')?></h3>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <form id="paymentFrm" method="get" action="<?=$freekassa->action_url?>">

                <div class="form-group">
                  <label class="form-label"><?=sprintf(lang("total_amount_XX_includes_fee"), get_option("freekassa_country_currency_code", 'USD'))?></label>
                  <input type="text" class="form-control" value="<?=$amount?>" disabled>
                </div>
                <div class="form-group">
                  <label class="form-label"  for="installments"><?=lang('choose_payment_method')?></label>
                  <select class="form-control"  name="i">
                  <?php
                    if (!empty($freekassa_acceptance) && is_array($freekassa_acceptance)) {
                      foreach ($freekassa_acceptance as $row) {
                  ?>
                  <option value="<?=$row?>"><?=$payments[$row]?></option>
                  <?php
                    }}
                  ?>
                  </select>
                </div>
                <div class="form-group">
                
                  <input type = 'hidden' name = 'm' value ='<?=$freekassa->merchantId?>'>
                  <input type = 'hidden' name = 'oa' value ='<?=$freekassa->amount?>'>
                  <input type = 'hidden' name = 'o' value ='<?=$freekassa->order_id?>'>
                  <input type = 'hidden' name = 's' value ='<?=$freekassa->signature?>'>
                  <!-- <input type = 'hidden' name = 'i' value ="<?=$freekassa->payment_method?>"> -->
                  <input type = 'hidden' name = 'lang' value = 'ru'>
                  <Input type = 'hidden' name = 'em' value='<?=$payer_email?>'>

                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                  <!-- submit button -->
                  <input type="submit" class="btn btn-primary btn-lg btn-block" name="PAYMENT_METHOD" value="<?=lang("Submit")?>">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<center><h1>Please do not refresh this page...</h1></center>
<form method="post" action="<?php echo $action_url ?>" name="f1">
  <table border="1">
    <tbody>
    <?php
    foreach($pm_params as $name => $value) {
      echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
    }
    ?>
    </tbody>
  </table>
  <script type="text/javascript">
    document.f1.submit();
  </script>
</form>