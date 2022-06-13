
<?php
  $option                          = get_value($payment_params, 'option');
  $min_amount                      = get_value($payment_params, 'min');
  $max_amount                      = get_value($payment_params, 'max');
  $type                            = get_value($payment_params, 'type');
  $tnx_fee                         = get_value($option, 'tnx_fee');
  $method_acceptance               = get_value($option, 'freekassa_acceptance');
  $currency_rate_to_usd            = get_value($option, 'rate_to_usd');
  $payments_name = array(
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
<div class="add-funds-form-content">
  <form class="form actionAddFundsForm" action method="POST">
    <div class="row">
      <div class="col-md-12">
        <div class="for-group text-center">
          <img src="<?=BASE?>/assets/images/payments/freekassa.png" style="max-width: 250px;" alt="Free-Kassa icon">
          <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Free-Kassa')?></small></p>
        </div>
        <div class="form-group">
          <label><?=sprintf(lang("amount_usd"), 'RUB')?></label>
          <input class="form-control square" type="number" name="amount" placeholder="<?php echo $min_amount; ?>">
        </div>
        <div class="form-group">
          <label class="form-label"  for="installments"><?=lang("choose_payment_method")?></label>
          <select class="form-control"  name="pm_code">
          <?php
            if (!empty($method_acceptance) && is_array($method_acceptance)) {
                foreach ($method_acceptance as $row) {
          ?>
            <option value="<?=$row?>"><?php echo $payments_name[$row]; ?></option>
          <?php }} ?>
          </select>
        </div>
        <div class="form-group">
          <label><?php echo lang("note"); ?></label>
          <ul>
            <?php
              if ($tnx_fee > 0) {
            ?>
            <li><?=lang("transaction_fee")?>: <strong><?php echo $tnx_fee; ?>%</strong></li>
            <?php } ?>
            <li><?=lang("Minimal_payment")?>: <strong><?php echo $currency_symbol.$min_amount; ?></strong></li>
            <?php
              if ($max_amount > 0) {
            ?>
            <li><?=lang("Maximal_payment")?>: <strong><?php echo $currency_symbol.$max_amount; ?></strong></li>
            <?php } ?>
            <?php
              if ( $currency_rate_to_usd  > 1) {
            ?>
            <li><?=lang("currency_rate")?>: 1USD = <strong><?php echo $currency_rate_to_usd; ?></strong>INR</li>
            <?php }?>
            <li><?php echo lang("clicking_return_to_shop_merchant_after_payment_successfully_completed"); ?></li>
          </ul>
        </div>

        <div class="form-group">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="agree" value="1">
            <span class="custom-control-label text-uppercase"><strong><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></strong></span>
          </label>
        </div>
        
        <div class="form-actions left">
          <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
          <input type="hidden" name="payment_method" value="<?php echo $type; ?>">
          <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
            <?=lang("Pay")?>
          </button>
        </div>
      </div>  
    </div>
  </form>
</div>
