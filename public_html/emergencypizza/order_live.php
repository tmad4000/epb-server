<?php/*
ini_set("log_errors", 1);
ini_set("error_log", "tmp/php-error.log");
error_log( "Hello, errors!" );
*/

echo 'aoeu';
//error_reporting(-1);
//ini_set('display_errors','On');
//echo 'aoeu';

//require 'lib/stripe-php-1.8.1/lib/Stripeh.php';

//require 'lib/stripe-php-1.8.1/lib/Stripe.php';
exit;

//should only be called from app
if ($_POST||$_GET['123test']) {
    Stripe::setApiKey("sk_test_nqswmnpPT3CHdkbsgtrQSWR2");
    $error = '';
    $success = '';
    try {

        /*================CHARGE CARD====================*/
        if (!isset($_POST['stripe_token']))
            throw new Exception("The Stripe Token was not generated correctly");
        Stripe_Charge::create(array("amount" => 1622,
            "currency" => "usd",
            "card" => $_POST['stripe_token']));
        $success = 'Your payment was successful.';



        /*==============PLACE ORDER====================*/
        /*
                $address = "2465 ALPINE RD";
                $city = "MENLO PARK";
                $region = "CA";
                $zip = "94025";
                $first_name = "Richard";
                $last_name = "Chum";
                $phone = "6099759738";

                $EMAIL = "evilkronos+123456789@gmail.com";
                $CC_NUMBER = "4111111111111111";
                $CC_EXP = "0815";
                $CC_CVC = "666";
                $CC_POSTAL = $zip; // ?*/

        $address = $_POST['address']; //"2465 ALPINE RD";
        $city = $_POST['city']; //"MENLO PARK";
        $region = $_POST['region']; //"CA";
        $zip = $_POST['zip']; //"94025";
        $first_name = $_POST['first_name']; //"Richard";
        $last_name = $_POST['last_name']; //"Chum";
        $phone = $_POST['phone']; //"6099759738";

        $CC_POSTAL = $zip; // ?

        /*======================================++*/

        $EMAIL = "evilkronos+123456789@gmail.com";
        $CC_NUMBER = "4111111111111111";
        $CC_EXP = "0815";
        $CC_CVC = "666";
        $CC_POSTAL = $zip; // ?

        //$STORE_ID=
        //$products_str=pizzas_to_product($_POST['pizzas'])

        //Assemble order query




        print($response);


    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    if (isset($_POST['json'])) {
        exit(json_encode(get_defined_vars()));
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title>Stripe Getting Started Form</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css"/>
    <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
    <!-- jQuery is used only for this example; it isn't required to use Stripe -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script type="text/javascript">
        // this identifies your website in the createToken call below
        Stripe.setPublishableKey('pk_test_us3cqQL37ixeBc90QSHuFxMb');

        function stripeResponseHandler(status, response) {
            if (response.error) {
                // re-enable the submit button
                $('.submit-button').removeAttr("disabled");
                // show the errors on the form
                $(".payment-errors").html(response.error.message);
            } else {
                var form$ = $("#payment-form");
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                form$.append("<input type='hidden' name='stripe_token' value='" + token + "' />");
                // and submit
                form$.get(0).submit();
            }
        }

        $(document).ready(function () {
            $("#payment-form").submit(function (event) {
                // disable the submit button to prevent repeated clicks
                $('.submit-button').attr("disabled", "disabled");

                // createToken returns immediately - the supplied callback submits the form if there are no errors
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
                return false; // submit from callback
            });
        });
    </script>
</head>
<body class="container-fluid">
<div class="span8 offset2">
    <h1>Charge $1.00 with Stripe</h1>
    <!-- to display errors returned by createToken -->
    <span class="payment-errors"><?= $error ?></span>
    <span class="payment-success"><?= $success ?></span>

    <form action="" method="POST" id="payment-form">
        <div class="form-row">
            <label>Card Number</label>
            <input type="text" size="20" autocomplete="off" class="card-number"/>
        </div>
        <div class="form-row">
            <label>CVC</label>
            <input type="text" size="4" autocomplete="off" class="card-cvc"/>
        </div>
        <div class="form-row">
            <label>Expiration (MM/YYYY)</label>
            <input type="text" size="2" class="card-expiry-month"/>
            <span> / </span>
            <input type="text" size="4" class="card-expiry-year"/>
        </div>
        <button type="submit" class="submit-button">Submit Payment</button>
    </form>
</div>
</body>
</html>