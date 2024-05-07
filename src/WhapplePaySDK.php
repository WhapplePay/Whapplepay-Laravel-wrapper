<?php

namespace Whapplepay;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class WhapplePaySDK
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => Config::get('app.whapplepay_api_url', 'https://api.whapplepay.com/'),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function processPayment($amount, $currency, $paymentMethod, $clientId, $clientSecret, $phoneNumber)
    {
        $data = [
            'amount' => $amount,
            'currency' => $currency,
            'paymentMethod' => Config::get('app.whapplepay_payment_method', 'WhapplePay'),
            'redirectUrls' => [
                'successUrl' => Config::get('app.whapplepay_success_url', 'http://example.com/success'),
                'cancelUrl' => Config::get('app.whapplepay_cancel_url', 'http://example.com/cancel'),
            ],
            'client_id' => Config::get('app.whapplepay_client_id', ''),
            'client_secret' => Config::get('app.whapplepay_client_secret', ''),
            'phone_number' => $phoneNumber, 
        ];
        
        $response = $this->makeApiCall('POST', 'payments', $data);

        return $response;
    }

    public function withdrawMoney($amount, $currency, $withdrawMethod, $clientId, $clientSecret)
    {
        $data = [
            'amount' => $amount,
            'currency' => $currency,
            'withdrawMethod' => $withdrawMethod,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ];

        $response = $this->makeApiCall('POST', 'withdrawals', $data);

        return $response;
    }

    private function makeApiCall($method, $endpoint, $data = [])
    {
        try {
            $response = $this->client->request($method, $endpoint, [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
