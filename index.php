<?php


require_once ("php/error_handler.php");
require_once ("php/dbconnection.php");
require_once ("php/error_handler.php");
require_once ("php/user.php");
require_once ("php/customer.php");
require_once ("php/admin.php");
require_once ("php/fabric.php");
require_once ('php/config.php');
//echo "bruhdfh";




$fname = "Abubakar";
$lname = "Sambo";
$email = "abu_sb87@yahoo.com";
$phone = "5148394800";
$address = "1693 rue sanguinet";
$password = "chunabig";




$fname2 = "john";
$lname2 = "bull";
$email2 = "bull@yahoo.com";
$phone2= "6478376434";
$address2 = "13 house 221 gwaripma";
$password2 = "blueangel";
$securityPin = 905301805;
$dob = 12121991;


$abu = new Customer($email,$password);
//$abu->signUp($fname, $lname, $email, $phone, $address, $password,'','', 'customer');
$shadda = new Fabric();
$shadda->getFabricColor();
//$john = new Admin($email2,$password2,$securityPin,$dob);
//$john->signUp($fname, $lname, $email, $phone2, $address2, $password,$securityPin,$dob,'admin');

//$john->signIn($email2, $password2, 'admin');
//echo $_SESSION['email'];
//$abu->signIn($email, $password, 'customer');

//$abu->makeOrder('', '2', '1', '5000', 'wuse 2', 'wuse 3');

//$abu->signOut();
//$john->signIn($email2, $password2, 'admin');
//$john->signOut();
//$abu->updateUser('sam', 'brah', '', '', '', 'customer');
//$john->updateUser('sam', 'brah', '', '', '', 'admin');
//$abu->changePasscode('newpasswordabu', $password, 'customer');
//$john->changePin(4294967295, $securityPin);

//$abu->resetPasscode('customer','abu_sb87@yahoo.com');
?>
