<?php
require_once('vendor/autoload.php');
use Razorpay\Api\Api;

$api_key    = "xxxxxxxxxxxxxxxxxxxxxxxx";
$api_secret = "xxxxxxxxxxxxxxxxxxxxxxxx";

$api = new Api($api_key, $api_secret);


/*
*Get rzp customer id
*/
function get_rzp_customer_id($api,$roz_customer)
{
   $customer = $api->customer->create(array('name' => $roz_customer['name'], 'email' => $roz_customer['email'], 'contact' => $roz_customer['contact'],'fail_existing'=>0 ));

   if(is_object($customer))
   {
     $rzp_id = $customer->id;
     return  $rzp_id;
   }
   else{
    $customer1 = $api->customer->create(array('name' => $roz_customer['name'], 'email' => $roz_customer['email'], 'contact' => $roz_customer['contact']));

     if(is_object($customer1))
     {
       $rzp_id = $customer->id;
       return  $rzp_id;
     }
    }
  }
  /*
*Get rzp order id
*/
function create_order_id($api)
{
    $order  = $api->order->create(array('receipt' => time(), 'amount' => 100, 'currency' => 'INR')); // Creates order
   
    if(is_object($order))
   {
     $orderId = $order->id;
     return  $orderId;
   }
}



$name = 'Sujit Paul';
// $email = 'sujit.kreative@gmail.com';
 
$email = 'test5@gmail.com';
$contact = '9999999990';
$roz_customer['name']   = $name;
$roz_customer['email']  = $email;
$roz_customer['contact'] = $contact;





$rzp_cus_id = get_rzp_customer_id($api,$roz_customer);
//echo "rzp_cus_id=".$rzp_cus_id;
$order_id = create_order_id($api);
//echo "order_id=".$order_id;

// Str_sentto_Billdesk CRYORG|$order_id|NA|amount|NA|NA|NA|INR|NA|R|cryorg|NA|NA|F|44356041|799326|NA|NA|NA|NA|NA|https://www.cry.org/response.php|3A9396F0DC010D8D8642D97A9145F9BB466C13F3FB6F78F32F10ED00D8385B99



?>
<button id = "rzp-button1"> Pay </button>
  <script src = "https://checkout.razorpay.com/v1/checkout.js"> </script>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
  <script>
    var customer_id ="<?php echo $rzp_cus_id; ?>";
    var options = {
      "key": "<?php echo $api_key; ?>",
      "order_id": "<?php echo $order_id; ?>",
      "customer_id": "<?php echo $rzp_cus_id; ?>",
      "recurring": "1",
      "handler": function (response) {

        console.log(response)

        jQuery.ajax({
            url: 'payment.php',
            data: {
                payment_id : response.razorpay_payment_id,
                order_id : response.razorpay_order_id,
                signature : response.razorpay_signature,
                customer_id : customer_id,

            },
            type: 'POST',
            beforeSend: function(){
                        // Show image container
                        jQuery("#loader").show();
            },
            success : function(result){
              
             if(result==1)
             {
              
              alert("Payment Successfull");
             }

            },
            complete:function(data){
                    // Hide image container
                    jQuery("#loader").hide();
            }
        });
         alert("Payment Successfull");
        // alert(response.razorpay_order_id);
        // alert(response.razorpay_signature);
      },
      "notes": {
        "note_key 1": "Beam me up Scotty",
        "note_key 2": "Tea. Earl Gray. Hot."
      },
      "theme": {
        "color": "#F37254"
      }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function (e) {
      rzp1.open();
      e.preventDefault();
    }
  </script>
