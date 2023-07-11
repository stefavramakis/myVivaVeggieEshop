<?php
require "vendor\autoload.php";
use GuzzleHttp\Client;

class VivaPaymentProvider {

    public $data;
    // public $
    public $response;

    const API_TOKEN_URL = 'https://demo-accounts.vivapayments.com/connect/token';

    public function getAuthorization(){

        $client = new Client();
        $credentials = 'Basic ' . base64_encode('gcc576s72xrn2g2gle61th108q7jtb11l8bdbc4g3a2c5.apps.vivapayments.com:6o4023rNLx45BTf1y2yg79r2yQydsT');

        $response = $client->request('POST', 'https://demo-accounts.vivapayments.com/connect/token',[
            'headers' => [
                'Authorization' => $credentials,
                // 'Accept' => 'application/json'
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ]
            ]);

        $response = json_decode($response->getBody()->getContents())->access_token;
        
        return $response;
    }

    public function getOrderCode($authToken){

        $postFields = [
            'amount'=> $this->data['amount'],
            'customerTrns' => "Test 2 - No End Payment",
            'customer' => [
                'email' => $this->data['email'],
                'fullName' => $this->data['fullName']
            ],
            'paymentTimeout' => 65535,
            'allowRecurring' => false,
            'maxInstallments' => 0,
            'forceMaxInstallments' => false,
            'paymentNotification' => false,
            'disableExactAmount' => false,
            'sourceCode' => 'Default'
        ];

        $client = new Client();
        $credentials = 'Bearer ' . $authToken;


        $response = $client->post('https://demo-api.vivapayments.com/checkout/v2/orders', [
            'headers' => [
                'Authorization' => $credentials,
            ],
            'json' => $postFields
        ]);

        $response = $response->getBody()->getContents();

        return  json_decode($response,true);
    }


    public function retrieveOrderDetailes($orderCode){
        $client = new Client();
        $merchantId = 'dc2ddfd8-b961-4358-a5c4-5aac1ce8dd6e';
        $apiKey = 'n+Wy[I';
        $base64Credentials = base64_encode($merchantId . ":" . $apiKey);
        $credentials = 'Basic  ' . $base64Credentials;


        $response = $client->get('https://demo.vivapayments.com/api/orders/' . $orderCode, [
            'headers' => [
                'Authorization' => $credentials,
            ]
        ]);

        $response = $response->getBody()->getContents();

        var_dump($response);
        die();
    }
}