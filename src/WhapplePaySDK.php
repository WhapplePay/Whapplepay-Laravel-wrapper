<?php

namespace Whapplepay;

use GuzzleHttp\Client;

class WhapplePaySDK
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('WHAPPLEPAY_API_URL', 'https://api.whapplepay.com/'),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function processPayment($amount, $paymentMethod, $clientId, $clientSecret, $phoneNumber)
    {
        try {
            $data = [
                'amount' => $amount,
                'currency' => env('CURRENCY', 'USD'), // Get currency from env, default to USD
                'paymentMethod' => env('WHAPPLEPAY_PAYMENT_METHOD', 'WhapplePay'),
                'redirectUrls' => [
                    'successUrl' => env('WHAPPLEPAY_SUCCESS_URL', 'http://example.com/success'),
                    'cancelUrl' => env('WHAPPLEPAY_CANCEL_URL', 'http://example.com/cancel'),
                ],
                'client_id' => env('WHAPPLEPAY_CLIENT_ID', ''),
                'client_secret' => env('WHAPPLEPAY_CLIENT_SECRET', ''),
                'phone_number' => $phoneNumber, 
            ];
            
            return $this->makeApiCall('POST', 'payments', $data);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function withdrawMoney($amount, $withdrawMethod, $clientId, $clientSecret)
    {
        try {
            $data = [
                'amount' => $amount,
                'currency' => env('CURRENCY', 'USD'), // Get currency from env, default to USD
                'withdrawMethod' => $withdrawMethod,
                'client_id' => env('WHAPPLEPAY_CLIENT_ID', ''),
                'client_secret' => env('WHAPPLEPAY_CLIENT_SECRET', ''),
            ];
    
            return $this->makeApiCall('POST', 'withdrawals', $data);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private function makeApiCall($method, $endpoint, $data = [])
    {
        try {
            $response = $this->client->request($method, $endpoint, [
                'json' => $data,
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }
}
