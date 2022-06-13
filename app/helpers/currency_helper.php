<?php 


/**
 * Get Price format
 * @param $price
 * @return new $price format
 */
if (!function_exists('show_price_format')) {
    function show_price_format($input_price, $show_currency_symbol = false, $is_new_format = false, $option = [])
    {
        $input_price = (double)$input_price;
        $curency_symbol = null;
        if ($show_currency_symbol) {
            $curency_symbol = get_option('currency_symbol', "$");
        }
        return $curency_symbol . $input_price;
    };
}


/**
 *
 * Currency function for paypal
 *
 */
if (!function_exists("currency_codes")) {
    function currency_codes(){
        $data = array(
            "AUD" => "Australian dollar",
            "BRL" => "Brazilian dollar",
            "CAD" => "Canadian dollar",
            "CZK" => "Czech koruna",
            "DKK" => "Danish krone",
            "EUR" => "Euro",
            "HKD" => "Hong Kong dollar",
            "HUF" => "Hungarian forint",
            "INR" => "Indian rupee",
            "ILS" => "Israeli",
            "JPY" => "Japanese yen",
            "MYR" => "Malaysian ringgit",
            "MXN" => "Mexican peso",
            "TWD" => "New Taiwan dollar",
            "NZD" => "New Zealand dollar",
            "NOK" => "Norwegian krone",
            "PHP" => "Philippine peso",
            "PLN" => "Polish złoty",
            "GBP" => "Pound sterling",
            "RUB" => "Russian ruble",
            "SGD" => "Singapore dollar",
            "SEK" => "Swedish krona",
            "CHF" => "Swiss franc",
            "THB" => "Thai baht",
            "USD" => "United States dollar",
        );

        return $data;
    }
}

if (!function_exists("currency_format")) {
    function currency_format($number, $number_decimal = "", $decimalpoint = "", $separator = ""){
        $decimal = 2;

        if ($number_decimal == "") {
            $decimal = get_option('currency_decimal', 2);
        }

        if ($decimalpoint == "") {
            $decimalpoint = get_option('currency_decimal_separator', 'dot');
        }

        if ($separator == "") {
            $separator = get_option('currency_thousand_separator', 'comma');
        }
        
        switch ($decimalpoint) {
            case 'dot':
                $decimalpoint = '.';
                break;
            case 'comma':
                $decimalpoint = ',';
                break;
            default:
                $decimalpoint = ".";
                break;
        }

        switch ($separator) {
            case 'dot':
                $separator = '.';
                break;
            case 'comma':
                $separator = ',';
                break;
            default:
                $separator = ',';
                break;
        }
        $number = number_format($number, $decimal, $decimalpoint, $separator);
        return $number;
    }
}

if (!function_exists("coinpayments_coin_setting")) {
    function coinpayments_coin_setting()
    {
        $items_coin = [
            'BTC'  => 'Bitcoin',
            'LTC'  => 'Litecoin',
            'ETH'  => 'Ether',
            'BCH'  => 'Bitcoin Cash',
            'DASH' => 'DASH',
            'XRP'  => 'Ripple',
            'LTCT' => 'Litecoin Testnet for testing',
        ];
        return $items_coin;
    }
}

if (!function_exists("midtrans_payment_setting")) {
    function midtrans_payment_setting()
    {
        $payment_channel = [
            "credit_card"      => 'credit_card',
            "gopay"            => 'gopay',
            "mandiri_clickpay" => 'mandiri_clickpay',
            "cimb_clicks"      => 'cimb_clicks',
            "bca_klikbca"      => 'bca_klikbca',
            "bca_klikpay"      => 'bca_klikpay',
            "bri_epay"         => 'bri_epay',
            "telkomsel_cash"   => 'telkomsel_cash',
            "echannel"         => 'echannel',
            "bbm_money"        => 'bbm_money',
            "xl_tunai"         => 'xl_tunai',
            "indosat_dompetku" => 'indosat_dompetku',
            "mandiri_ecash"    => 'mandiri_ecash',
            "permata_va"       => 'permata_va',
            "bca_va"           => 'bca_va',
            "bni_va"           => 'bni_va',
            "danamon_online"   => 'danamon_online',
            "other_va"         => 'other_va',
            "kioson"           => 'kioson',
            "Indomaret"        => 'Indomaret',
          ];
        return $payment_channel;
    }
}

if (!function_exists("freekassa_payment_setting")) {
    function freekassa_payment_setting()
    {
        $items = [
            '1'     => 'FK WALLET RUB',
            '2'     => 'FK WALLET USD',
            '3'     => 'FK WALLET EUR',
            '4'     => 'VISA RUB',
            '6'     => 'Yoomoney',
            '7'     => 'VISA UAH',
            '8'     => 'MasterCard RUB',
            '9'     => 'MasterCard UAH',
            '10'     => 'Qiwi',
            '11'    => 'VISA EUR',
            '12'    => 'МИР',
        ];
        return $items;
    }
}

if (!function_exists("currency_format")) {
    function local_currency_code(){
        $data = array(   
                  'USD',
                'EUR',
                'JPY',
                'GBP',
                'AUD',
                'CAD',
                'CHF',
                'CNY',
                'SEK',
                'NZD',
                'MXN',
                'SGD',
                'HKD',
                'NOK',
                'KRW',
                'TRY',
                'RUB',
                'INR',
                'BRL',
                'ZAR',
                'AED',
                'AFN',
                'ALL',
                'AMD',
                'ANG',
                'AOA',
                'ARS',
                'AWG',
                'AZN',
                'BAM',
                'BBD',
                'BDT',
                'BGN',
                'BHD',
                'BIF',
                'BMD',
                'BND',
                'BOB',
                'BSD',
                'BTN',
                'BWP',
                'BYN',
                'BZD',
                'CDF',
                'CLF',
                'CLP',
                'COP',
                'CRC',
                'CUC',
                'CUP',
                'CVE',
                'CZK',
                'DJF',
                'DKK',
                'DOP',
                'DZD',
                'EGP',
                'ERN',
                'ETB',
                'FJD',
                'FKP',
                'GEL',
                'GGP',
                'GHS',
                'GIP',
                'GMD',
                'GNF',
                'GTQ',
                'GYD',
                'HNL',
                'HRK',
                'HTG',
                'HUF',
                'IDR',
                'ILS',
                'IMP',
                'IQD',
                'IRR',
                'ISK',
                'JEP',
                'JMD',
                'JOD',
                'KES',
                'KGS',
                'KHR',
                'KMF',
                'KPW',
                'KWD',
                'KYD',
                'KZT',
                'LAK',
                'LBP',
                'LKR',
                'LRD',
                'LSL',
                'LYD',
                'MAD',
                'MDL',
                'MGA',
                'MKD',
                'MMK',
                'MNT',
                'MOP',
                'MRO',
                'MUR',
                'MVR',
                'MWK',
                'MYR',
                'MZN',
                'NAD',
                'NGN',
                'NIO',
                'NPR',
                'OMR',
                'PAB',
                'PEN',
                'PGK',
                'PHP',
                'PKR',
                'PLN',
                'PYG',
                'QAR',
                'RON',
                'RSD',
                'RWF',
                'SAR',
                'SBD',
                'SCR',
                'SDG',
                'SHP',
                'SLL',
                'SOS',
                'SRD',
                'SSP',
                'STD',
                'SVC',
                'SYP',
                'SZL',
                'THB',
                'TJS',
                'TMT',
                'TND',
                'TOP',
                'TTD',
                'TWD',
                'TZS',
                'UAH',
                'UGX',
                'UYU',
                'UZS',
                'VEF',
                'VND',
                'VUV',
                'WST',
                'XAF',
                'XAG',
                'XAU',
                'XCD',
                'XDR',
                'XOF',
                'XPD',
                'XPF',
                'XPT',
                'YER',
                'ZMW',
                'ZWL',
        );
        return $data;
    }

}
