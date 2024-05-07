
### WhapplePay SDK Documentation

#### Introduction
Welcome to the WhapplePay SDK documentation. This SDK allows seamless integration with the WhapplePay payment gateway, enabling developers to process payments and withdrawals in their applications.

#### Installation
To use the WhapplePay SDK in your project, follow these steps:
1. Install the SDK package using Composer:
   ```bash
   composer require vendor/whapplepay-sdk
   ```
2. Include the SDK in your PHP files:
   ```php
   use Vendor\Whapplepay\WhapplePaySDK;
   ```

#### Configuration
Before using the WhapplePay SDK, make sure to set the following environment variables in your `.env` file:

Base URl = http://whapplepay.com/api/sdkprocess-payment/payments

```plaintext
WHAPPLEPAY_API_URL=https://api.whapplepay.com/
WHAPPLEPAY_SUCCESS_URL=http://example.com/success
WHAPPLEPAY_CANCEL_URL=http://example.com/cancel
WHAPPLEPAY_CLIENT_ID=your_client_id_here
WHAPPLEPAY_CLIENT_SECRET=your_client_secret_here
WHAPPLEPAY_PAYMENT_METHOD=MobileMoney  

```

#### Usage

##### Initialization
Instantiate the WhapplePaySDK class to begin using the SDK:
```php
$whapplePay = new WhapplePaySDK();
```

##### Process Payment
To process a payment using the WhapplePay SDK, use the `processPayment` method:
```php
// Process Payment and Handle Response
$response = $whapplePay->processPayment($amount, $currency, $paymentMethod, $clientId, $clientSecret, $phoneNumber);

// Check if the payment was successful
if (isset($response['transaction']) && isset($response['status']) && $response['status'] == 200) {
    $transaction = $response['transaction'];
    
    // Display payment details
    echo "Payment Details:\n";
    echo "Transaction ID: " . $transaction['id'] . "\n";
    echo "Amount: " . $transaction['total'] . " " . $transaction['currency'] . "\n";
    echo "Status: " . $transaction['status'] . "\n";

    // Additional processing or actions based on the payment success
    // For example, update user balance, send confirmation email, etc.
    // Your code here...

    // Display success message
    echo "Payment successful!\n";
} else {
    // Handle payment failure or other errors
    if (isset($response['error'])) {
        echo "Error: " . $response['error'] . "\n";
    } else {
        echo "Payment failed!\n";
    }
}
```
Parameters:
- `$amount`: The amount of the payment.
- `$currency`: The currency of the payment (e.g., "F.CFA", "NGN").
- `$paymentMethod`: The payment method (e.g., "CreditCard", "MobileMoney").
- `$clientId`: Your client ID for authentication.
- `$clientSecret`: Your client secret for authentication.
- `$phoneNumber`: The phone number for MobileMoney payments.

##### Withdraw Money
To initiate a withdrawal using the WhapplePay SDK, use the `withdrawMoney` method:
```php
$response = $whapplePay->withdrawMoney($amount, $currency, $withdrawMethod, $clientId, $clientSecret);
```
Parameters:
- `$amount`: The amount to withdraw.
- `$currency`: The currency of the withdrawal.
- `$withdrawMethod`: The withdrawal method.
- `$clientId`: Your client ID for authentication.
- `$clientSecret`: Your client secret for authentication.

#### Supported Payment Methods

The following table shows the supported payment methods and their implementation status for both deposit and withdrawal:

| Payment Method | Deposit Implemented | Withdraw Implemented |
|----------------|----------------------|----------------------|
| WhapplePay     | ✅                    | ❌                     |
| MobileMoney    | ✅                    | ❌                     |
| PayPal         | ❌                    | ❌                    |
| Bank Transfer  | ❌                    | ❌                    |


#### Errors Handling
In case of any errors during API calls, the SDK returns an error message. Handle these errors appropriately in your application.

#### Versioning
The WhapplePay SDK follows semantic versioning. Ensure compatibility by specifying the desired version when installing the package.

#### Support and Feedback
For support or feedback regarding the WhapplePay SDK, contact our support team at support@whapplepay.com.

#### License
The WhapplePay SDK is licensed under the MIT License. Refer to the LICENSE file for details.

