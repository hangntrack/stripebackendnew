<?php
require_once('vendor/autoload.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
StripeStripe::setApiKey("sk_test_4acWNdN2Xh386H3xdlhRS45U");

// Get the credit card details submitted by the form
$token =  $_POST['stripeToken'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$description = $_POST['description'];

// Create the charge on Stripe's servers - this will charge the user's card
try {
    $charge = StripeCharge::create(array(
    "amount" => $amount*100, // Convert amount in cents to dollar
    "currency" => $currency,
    "source" => $token,
    "description" => $description)
    );

    // Check that it was paid:
    if ($charge->paid == true) {
        $response = array( 'status'=> 'Success', 'message'=>'Payment has been charged!!' );
    } else { // Charge was not paid!
        $response = array( 'status'=> 'Failure', 'message'=>'Your payment could NOT be processed because the payment system rejected the transaction. You can try again or use another card.' );
    }
    header('Content-Type: application/json');
    echo json_encode($response);

} catch(StripeErrorCard $e) {
  // The card has been declined

    header('Content-Type: application/json');
    echo json_encode($response);
}

?>
	
func postToken(token:STPToken) {

    let parameters : [ String : AnyObject] = ["stripeToken": token.tokenId, "amount": 10000, "currency": "usd", "description": "testRun"]

    Alamofire.request(.POST, "https://thawing-inlet-46474.herokuapp.com/charge.php", parameters: parameters).responseString { (response) in

        print(response)

    }

}