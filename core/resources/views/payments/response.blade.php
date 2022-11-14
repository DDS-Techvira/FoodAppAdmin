@extends($activeTemplate.'layouts.frontend')
@section('content')


    <?php

//decode & get POST parameters
$payment = base64_decode($_POST ["payment"]);
$signature = base64_decode($_POST ["signature"]);
$custom_fields = base64_decode($_POST ["custom_fields"]);
//load public key for signature matching

    //    test
    $publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDZASiqkl5xx2qUzjp++0gNv+jy
mRMjzisuDVTafSJ0orugfBu2wZJawFRPuj0wu4Oku0YC+g+aj2AywRhJTt/LMkYe
OUyx+GTL2QxsoNbsOAkJaGBn4Ve1YJYbwh5Zw6BfgEJXZKp9J1NnwL2CFKbpg9S9
nM1N5c4EVNib63Ik5QIDAQAB
-----END PUBLIC KEY-----";

    //live
//    $publickey = "-----BEGIN PUBLIC KEY-----
//MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDp0nLwTPBR96TPKdygsRmY5ooi
//1cIv9D0uzD9FVtgM4p1UnaQKO/NkvFin8oBDtJMRAjDmhZ+migxskhzxihiwtnIh
//NCejystmndqzwLHFHzk9s77snfbekaqVqbZSn+Vt9ShROkVhI0FbWAfhkL4lsyeu
//FyWLa4t36UdkjPti8wIDAQAB
//-----END PUBLIC KEY-----";


openssl_public_decrypt($signature, $value, $publickey);

$signature_status = false ;

if($value == $payment){
	$signature_status = true ;
}


//get payment response in segments
//payment format: order_id|order_refference_number|date_time_transaction|payment_gateway_used|status_code|comment;
$responseVariables = explode('|', $payment);

if($signature_status == true)
{
	//display values
	echo $signature_status;
	$custom_fields_varible = explode('|', $custom_fields);
	var_dump($custom_fields_varible);
	echo '<br/>';
	var_dump($responseVariables);

//    //     this is expanded respond
//    echo $signature_status;
//    $custom_fields_varible = explode('|', $custom_fields);
//    var_dump($custom_fields_varible);
//    echo '<br/>';
//    var_dump($responseVariables);
//    echo '<br/>';
//    echo '111';
//    echo '<br/>';
//    echo $responseVariables[0];
//    echo '<br/>';
//    echo $responseVariables[1];
//    echo '<br/>';
//    echo $responseVariables[2];
//    echo '<br/>';
//    echo $responseVariables[4];
//    echo '<br/>';
//    echo $responseVariables[5];
//    echo '<br/>';
//	echo '111';
//    echo '<br/>';
}else
{
//     this is expanded respond
//    echo $signature_status;
//    $custom_fields_varible = explode('|', $custom_fields);
//    var_dump($custom_fields_varible);
//    echo '<br/>';
//    var_dump($responseVariables);
//    echo '<br/>';
//    echo '111';
//    echo '<br/>';
//    echo $responseVariables[0];
//    echo '<br/>';
//    echo $responseVariables[1];
//    echo '<br/>';
//    echo $responseVariables[2];
//    echo '<br/>';
//    echo $responseVariables[4];
//    echo '<br/>';
//    echo $responseVariables[5];
//    echo '<br/>';
//	echo '111';
//    echo '<br/>';
	echo 'Error Validation';
}

?>




@endsection
