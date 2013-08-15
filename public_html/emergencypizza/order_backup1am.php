<?php
require 'lib/stripe-php-1.8.1/lib/Stripe.php';

function do_post_request($url, $data, $optional_headers = null)
{
    $params = array('http' => array(
        'method' => 'POST',
        'content' => $data
    ));
    if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
    }
    $ctx = stream_context_create($params);
    $fp = @fopen($url, 'rb', false, $ctx);
    if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
    }
    $response = @stream_get_contents($fp);
    if ($response === false) {
        throw new Exception("Problem reading data from $url, $php_errormsg");
    }
    return $response;
}

/* ============BODY============= */

/*if ($_POST) {
    Stripe::setApiKey("sk_test_nqswmnpPT3CHdkbsgtrQSWR2");
    $error = '';
    $success = '';
    try {
        if (!isset($_POST['stripeToken']))
            throw new Exception("The Stripe Token was not generated correctly");
        Stripe_Charge::create(array("amount" => 100,
            "currency" => "usd",
            "card" => $_POST['stripeToken']));
        $success = 'Your payment was successful.';


    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    if (isset($_POST['json'])) {
        exit(json_encode(get_defined_vars()));
    }
}
*/


/*

$test = <<<'EOT'
{
  "Order": {
    "Address": {
      "Street": "130 Lytton Ave",
      "City": "PALO ALTO",
      "Region": "CA",
      "PostalCode": "94301-1065",
      "Type": "House"
    },
    "Coupons": [],
    "CustomerID": "",
    "Email": "ev.il.kro.nos+dfsdgreg@gmail.com",
    "Extension": "",
    "FirstName": "Richard",
    "LastName": "Chum",
    "LanguageCode": "en",
    "OrderChannel": "OLO",
    "OrderID": "",
    "OrderMethod": "Web",
    "OrderTaker": null,
    "Payments": [
      {
        "Type": "CreditCard",
        "Amount": 1.01,
        "Number": "4111111111111111",
        "CardType": "VISA",
        "Expiration": "0814",
        "SecurityCode": "822",
        "PostalCode": "94301"
      }
    ],
    "Phone": "3395451133",
    "Products": [
      {
        "Code": "P14IRECZ",
        "Qty": 1,
        "ID": 1,
        "isNew": false,
        "Options": {
          "C": {
            "1\/1": "1"
          },
          "E": {
            "1\/1": "1"
          },
          "Fe": {
            "1\/1": "1"
          },
          "Cs": {
            "1\/1": "1"
          },
          "Cp": {
            "1\/1": "1"
          },
          "X": {
            "1\/1": "1"
          }
        }
      }
    ],
    "ServiceMethod": "Delivery",
    "SourceOrganizationURI": "order.dominos.com",
    "StoreID": "3748",
    "Tags": {},
    "Version": "1.0",
    "NoCombine": true,
    "Partners": {}
  }
}
EOT;
*/

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
$CC_POSTAL = $zip; // ?

//$STORE_ID=


//Assemble order query
$order_query = <<<EOD
{ "Order" : { "Address" : { "City" : "$city",
          "PostalCode" : "$zip",
          "Region" : "$region",
          "Street" : "$address",
          "Type" : "House"
        },
      "Coupons" : [  ],
      "CustomerID" : "",
      "Email" : "$EMAIL",
      "Extension" : "",
      "FirstName" : "$first_name",
      "LanguageCode" : "en",
      "LastName" : "$last_name",
      "NoCombine" : true,
      "OrderChannel" : "OLO",
      "OrderID" : "yykV1Vs_sRap465csfk8",
      "OrderMethod" : "Web",
      "OrderTaker" : null,
      "Partners" : { "DOMINOS" : { "Tags" : {  } } },
      "Payments" : [ { "Amount" : 17.91,
            "CardType" : "VISA",
            "Expiration" : "$CC_EXP",
            "Number" : "$CC_NUMBER",
            "PostalCode" : "$CC_POSTAL",
            "SecurityCode" : "$CC_CVC",
            "Type" : "CreditCard"
          } ],
      "Phone" : "$phone",
      "Products" : [ { "Code" : "P12IREPV",
            "ID" : 4,
            "Options" : { "C" : { "1/1" : "1" },
                "Cp" : { "1/1" : "1" },
                "Cs" : { "1/1" : "1" },
                "Fe" : { "1/1" : "1" },
                "M" : { "1/1" : "1" },
                "O" : { "1/1" : "1" },
                "R" : { "1/1" : "1" },
                "Rr" : { "1/1" : "1" },
                "Si" : { "1/1" : "1" },
                "Td" : { "1/1" : "1" },
                "X" : { "1/1" : "1" }
              },
            "Qty" : 1,
            "isNew" : false
          } ],
      "ServiceMethod" : "Delivery",
      "SourceOrganizationURI" : "order.dominos.com",
      "StoreID" : "7930",
      "Tags" : {  },
      "Version" : "1.0"
    } }

EOD;

//Place order

//$response = do_post_request("https://order.dominos.com/power/place-order",'{"Order":{"Address":{"Street":"130 LYTTON AVE","City":"PALO ALTO","Region":"CA","PostalCode":"94301","Type":"House"},"Coupons":[],"CustomerID":"","Email":"evilkronos+dsfsdf@gmail.com","Extension":"","FirstName":"Richard","LastName":"Chum","LanguageCode":"en","OrderChannel":"OLO","OrderID":"yykV1Vs_sRap465csfk8","OrderMethod":"Web","OrderTaker":null,"Payments":[{"Type":"CreditCard","Amount":17.91,"Number":"4111111111111111","CardType":"VISA","Expiration":"0814","SecurityCode":"642","PostalCode":"94301"}],"Phone":"3395451133","Products":[{"Code":"P12IREPV","Qty":1,"ID":4,"isNew":false,"Options":{"X":{"1/1":"1"},"C":{"1/1":"1"},"Fe":{"1/1":"1"},"Cs":{"1/1":"1"},"Cp":{"1/1":"1"},"R":{"1/1":"1"},"M":{"1/1":"1"},"O":{"1/1":"1"},"Rr":{"1/1":"1"},"Si":{"1/1":"1"},"Td":{"1/1":"1"}}}],"ServiceMethod":"Delivery","SourceOrganizationURI":"order.dominos.com","StoreID":"7930","Tags":{},"Version":"1.0","NoCombine":true,"Partners":{"DOMINOS":{"Tags":{}}}}}');
$response = do_post_request("https://order.dominos.com/power/place-order",$order_query);


print($response);
exit;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title>Stripe Getting Started Form</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css" />
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
                form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
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