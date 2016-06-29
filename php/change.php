<?php
require_once ("dbconnection.php");
require_once ("error_handler.php");

$dbconn = new dbconnection ( 'customer' );



$email = $_POST ["email"];

// check if written email is in the database
$result = $dbconn->checkEmailPresent( $email );




// if the email exists then proceed
if($result){
	$token = getToken(32);
	$dbconn->updateToken($token, $email);
	$pwrurl = "reset_password.php?q=".$token."$ampe=".$email;
	$mailbody = "Dear user,\n\n
			If this e-mail does not apply to you please ignore it. 
			It appears that you have requested a password reset at our website www.yoursitehere.com\n\n
			To reset your password, 
			please click the link below. If you cannot click it, please paste it 
			into your web browser's address bar.\n\n" . $pwrurl . "\n\n
			Thanks,\n
			The Administration";
	
	mail($email, "Password Reset", $mailbody);
	
	echo "Your password recovery key has been sent to your e-mail address.";
	

}


//generate token to add to url in the mail
function crypto_rand_secure($min, $max) {

	$range = $max - $min;
	if ($range < 0)
		return $min; // not so random...
	$log = log ( $range, 2 );
	$bytes = ( int ) ($log / 8) + 1; // length in bytes
	$bits = ( int ) $log + 1; // length in bits
	$filter = ( int ) (1 << $bits) - 1; // set all lower bits to 1
	do {
		$rnd = hexdec ( bin2hex ( openssl_random_pseudo_bytes ( $bytes ) ) );
		$rnd = $rnd & $filter; // discard irrelevant bits
	} while ( $rnd >= $range );
	return $min + $rnd;
}
function getToken($length = 32) {

	$token = "";
	$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
	$codeAlphabet .= "0123456789";
	for($i = 0; $i < $length; $i ++) {
		$token .= $codeAlphabet [crypto_rand_secure ( 0, strlen ( $codeAlphabet ) )];
	}
	return $token;
}
?>