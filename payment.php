<?php
require_once('vendor/autoload.php');
require_once "db.php";
use Razorpay\Api\Api;




$api_key    = "xxxxxxxxxxxxxxxxxxxxxxxx";
$api_secret = "xxxxxxxxxxxxxxxxxxxxxxxx";



  

$api = new Api($api_key, $api_secret);

$payment_id = '';

$payment_id = $_POST["payment_id"];
$customer_id = $_POST["customer_id"];
$order_id = $_POST["order_id"];
$signature = $_POST["signature"];

$token_id = get_token_id($api,$payment_id);
/*
*Get rzp order id
*/
function get_token_id($api,$payment_id)
{
   $payment= $api->payment->fetch($payment_id); // Returns a particular payment
   return $payment->token_id;
}
  // id  user_id order_id  payment_id

$sql = "INSERT INTO user_payment_id(customer_id ,order_id,payment_id,signature,token,status)
VALUES('$customer_id', '$order_id','$payment_id', '$signature','$token_id',1)";

$insert_id = mysqli_query($conn, $sql);
if($insert_id)
{
	echo "1";
}
