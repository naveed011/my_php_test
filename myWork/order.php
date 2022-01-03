<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once '../con.php';
//include Stripe PHP library
require_once('../lib/stripe/init.php');

if(!empty($_POST['stripeToken'])) {

    // get token and user details
    $stripeToken = $_POST['stripeToken'];
    $customerName = $_POST['holdername'];
    $customerEmail = $_POST['email'];

    $customerAddress = 'test';
    $customerCity = 'islamabad';
    $customerZipcode ='44000';
    $customerState = 'islamabad';
    $customerCountry = 'Pakistan';

    $cardNumber = $_POST['cardnumber'];
    $cardCVC = $_POST['cvv'];
    $cardExpMonth = $_POST['email'];
    $cardExpYear = $_POST['year'];



    //set stripe secret key and publishable key
    $stripe = array(
        "secret_key" => "sk_test_krzb8hGSrijniuIT8N5VbbtT",
        "publishable_key" => "pk_test_tVemoj1bBSyWgrRE1YnRSM6i"
    );

    \Stripe\Stripe::setApiKey($stripe['secret_key']);

    //add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'name' => $customerName,
        'description' => 'test description',
        'email' => $customerEmail,
        'source' => $stripeToken,
        "address" => ["city" => $customerCity, "country" => $customerCountry, "line1" => $customerAddress, "line2" => "", "postal_code" => $customerZipcode, "state" => $customerState]
    ));

    // item details for which payment made
    $itemName = 'My Php Test';
    $itemNumber = $_POST['order_id'];
    $itemPrice = $_POST['price'];
    $totalAmount = $_POST['price'];
    $currency = 'Usd';
    $orderNumber = $_POST['order_id'];

    // details for which payment performed
    $payDetails = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount' => $totalAmount,
        'currency' => $currency,
        'description' => $itemName,
        'metadata' => array(
            'order_id' => $orderNumber
        )
    ));

    // get payment details
    $paymenyResponse = $payDetails->jsonSerialize();

    $stripe_id = 0;
    $status = 'failed';
    // check whether the payment is successful
    if ($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1) {

        // transaction details
        $amountPaid = $paymenyResponse['amount'];
        $stripe_id = $paymenyResponse['id'];
        $balanceTransaction = $paymenyResponse['balance_transaction'];
        $paidCurrency = $paymenyResponse['currency'];
        $paymentStatus = $paymenyResponse['status'];
        $paymentDate = date("Y-m-d H:i:s");

        $status = 'success';
    }

    $order = R::dispense( 'order' );

    $order->product_id = $_POST['order_id'];
    $order->stripe_id = $stripe_id;
    $order->total = $_POST['price']*1000;
    $order->status = $status;

    $id = R::store( $order );

    header("Location: /");
}
?>