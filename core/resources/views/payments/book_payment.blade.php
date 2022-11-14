<?php

// unique_order_id|total_amount
$odre_pay = $_GET["amount"];
$odre_id = $_GET["order_id"];
$plaintext = $odre_id.'|'.$odre_pay;
$publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC/XgbitCulgQI5MNBJVSuyEE0q
9y460Zmu+d46Mkua2jsCSqKwKdEGCE1dH8lTehwAmeUg0aSVlErheZjNeHFnBvyz
wRu7aJz+r2bIlhcqmP3HjWazhmjV6D2yc6X+xzX7lAY16SghNFRx5bTSb9rrHOYS
yxUy7Yf/QqCCqRI+iwIDAQAB
-----END PUBLIC KEY-----";
//load public key for encrypting
openssl_public_encrypt($plaintext, $encrypt, $publickey);

//encode for data passing
$payment = base64_encode($encrypt);
//checkout URL
$url = 'https://webxpay.com/index.php?route=checkout/billing';

//custom fields
//cus_1|cus_2|cus_3|cus_4
$custom_fields = base64_encode($odre_id.'|app|book|cus_4');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pavan Welihinda">
    <title>WebXPay</title>
  </head>
  <body>
      <form action="<?php echo $url; ?>" method="POST">
	   		<span>Redirecting...</span>
			<input type="hidden" name="first_name" value="<?php echo $_GET['first_name'];?>">
			<input type="hidden" name="last_name" value="<?php echo $_GET['last_name'];?>">
			<input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
			<input type="hidden" name="contact_number" value="<?php echo $_GET['contact_number'];?>">
			<input type="hidden" name="address_line_one" value="<?php echo $_GET['address'];?>">
			<input type="hidden" name="address_line_two" value=" ">
			<input type="hidden" name="city" value=" ">
			<input type="hidden" name="state" value=" ">
			<input type="hidden" name="postal_code" value=" ">
			<input type="hidden" name="country" value=" ">
			<input type="hidden" name="process_currency" value="LKR"> <!-- currency value must be LKR or USD -->
			<input type="hidden" name="cms" value="PHP">
			<input type="hidden" name="custom_fields" value="<?php echo $custom_fields; ?>">
			<input type="hidden" name="enc_method" value="JCs3J+6oSz4V0LgE0zi/Bg==">
			<br/>
			<!-- POST parameters -->
			<input type="hidden" name="secret_key" value="00f2dbf8-4b4e-49c4-866c-a65d0b9c18bf" >
			<input  hidden name="payment" value="<?php echo $payment; ?>" >
			<input type="submit" style="display:none" id="payment_submit" value="Pay Now" >
        </form>
  </body>
</html>
<script type="text/javascript">
document.getElementById("payment_submit").click();
</script>
