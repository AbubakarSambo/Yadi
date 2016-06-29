<?php

/**
 * @author Sambo
 * @copyright 2015
 */
//session_start ();
// load error handling script and the queue class

require_once ('error_handler.php');
require_once ('user.php');
require_once ('customer.php');
require_once ('dbconnection.php');
// when the condition is met
if (! (isset ( $_GET ['action'] ))) {
	echo 'Server error: client command missing.';
	exit ();
} else {
	// store the action to be performed in the $action variable
	$action = $_GET ['action'];
}

// create a new queue connection class instance
	$new_customer = new Customer ();

if ($action === 'signIn') {

	
	$email = $_GET ['email'];
	$passcode = $_GET ['passcode'];
	$user = $_GET ['user'];
	//echo ($user);
	
	// error check goes here
	if (empty ( $_GET )) {
		echo "Error: Empty Submission not allowed";
		exit ();
	}
	
	$ans = $new_customer->signIn($email, $passcode, $user);
	echo $ans; 
}

?>