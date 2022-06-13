<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'paypal/autoload.php';

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
/**
 * Paypal PHP SDK
 */
class paypalapi {
    private $client;
    private $clientId;
    private $clientSecret ;
    
    public function __construct($paypal_client_id = null, $paypal_client_secret = null, $mode = "") {
        if ($paypal_client_secret != "" && $paypal_client_id != "") {
            $this->clientSecret = $paypal_client_secret;
            $this->clientId = $paypal_client_id;
            if ($mode == 'live') {
                $environment = new ProductionEnvironment($this->clientId , $this->clientSecret);
            } else {
                $environment = new SandboxEnvironment($this->clientId , $this->clientSecret);
            }
            $this->client  = new PayPalHttpClient($environment);
        }
    }

    /**
     *
     * Define Payment && Create payment.
     *
     */
    function  create_payment($data = "", $mode){
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
                            "intent" => "CAPTURE",
                            "purchase_units" => [[
                                "reference_id" => "ref_id_" . strtotime(NOW),
                                "amount" => [
                                    "value" => number_format($data->amount, 2, '.', ''),
                                    "currency_code" => $data->currency,
                                ],
                                "description" => $data->description
                            ]],
                            "application_context" => [
                                "cancel_url" => $data->cancelUrl,
                                "return_url" => $data->redirectUrls
                            ] 
                        ];
        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);
            $createdOrder = $response->result;
            $foundApproveUrl = false;
            $approvalUrl = null;
            foreach ($createdOrder->links as $link) {
                if ("approve" === $link->rel) {
                    $foundApproveUrl = true;
                    $approvalUrl = $link->href;
                }
            }
            if ($foundApproveUrl) {
                $result = (object)array(
                    'status'      => 'success',
                    'approvalUrl' => $approvalUrl,
                    'data'        => $createdOrder,
                );
            }else{
                $result = (object)array(
                    'status'      => 'error',
                    'message'      => 'Not Found Approval Url',
                );
            }
        }catch (HttpException $ex) {
            $result = (object)array(
                'status'      => 'error',
                'message'     => $ex->statusCode . $ex->getMessage(),
            );
        }
        
        return $result;
    }

    /**
     * Execute payment 
     */
    public function execute_payment($token, $payerId, $mode){

        $request = new OrdersCaptureRequest($token);
        $request->prefer('return=representation');
        try {
            $result = $this->client->execute($request);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            pr($ex->getMessage(), 1);
        }
        return $result;
    }
}