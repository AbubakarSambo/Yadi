<?php
/**
 * parent class User
 */
session_start ();
class User {
	public $firstname;
	public $lastname;
	public $email;
	public $phone;
	public $address;
	
	public function signUp($firstname, $lastname, $email, $phone, $address, $passcode, $securityPin = '', $dob = '', $user) {
		$dbconn = new dbconnection ( $user );
		
		if ($user === 'customer') {
			
			$result = $dbconn->newCustomer ( $firstname, $lastname, $email, $phone, $address, $passcode );
		} elseif ($user === 'admin') {
			
			$result = $dbconn->newAdmin ( $firstname, $lastname, $email, $phone, $address, $securityPin, $dob, $passcode );
		}
		if ($result === true)
			echo "New " . $user . " created successfully.";
		
		else
			echo "New " . $user . " NOT created, try again.";
		
		$dbconn->__destruct ();
	}
	public function signIn($email, $passcode, $user) {
		
		// session_start();
		$dbconn = new dbconnection ( $user );
		
		$result = $dbconn->login ( $email, $passcode, $user );
		
		if ($result === true) {
			
			$id = $dbconn->get_user_id ( $email, $user );
			$_SESSION ['email'] = $id;
			
			
			//echo "Signed in successfully.";
			
			return $_SESSION ['email'];
		} else{
			return 0;
			
		}
		$dbconn->__destruct ();
	}
	public function signOut() {
		unset ( $_SESSION ['email'] );
		session_destroy ();
		echo "signed out";
	}
	public function updateUser($firstname, $lastname, $email, $phone, $address, $user) {
		$dbconn = new dbconnection ( $user );
		
		if ($user == 'customer') {
			$result = $dbconn->updateCustomer ( $firstname, $lastname, $email, $phone, $address );
		} elseif ($user == 'admin') {
			$result = $dbconn->updateAdmin ( $firstname, $lastname, $email, $phone, $address );
		}
		if ($result === true)
			echo "Updated successfully.";
		
		else
			echo "Not Updated";
		
		$dbconn->__destruct ();
	}
	public function deleteUser($user) {
		$dbconn = new dbconnection ( $user );
		
		$result = $dbconn->deleteCustomer ();
		
		if ($result === true)
			echo "Deleted successfully.";
		
		else
			echo "Not Deleted";
		
		$dbconn->__destruct ();
	}
	public function createUser(){
		
	}
	public function changePasscode($oldpasscode, $newpasscode, $user) {
		$dbconn = new dbconnection ( $user );
		
		if ($user == 'customer'){
			$result = $dbconn->updatePasscode ( $oldpasscode, $newpasscode, $user );
		}
		elseif ($user == 'admin'){
			$result = $dbconn->updatePasscode($oldpasscode, $newpasscode, $user);
		}
		
		if ($result === true)
			echo "Passcode Updated successfully.";

		else
			echo "Not Updated";
		
		$dbconn->__destruct ();
	}
	public function changePin($oldpin, $newpin) {
		$dbconn = new dbconnection ( 'admin' );
	
		
			$result = $dbconn->updatePin($oldpin, $newpin);
		
	
		if ($result === true)
			echo "Pin Updated successfully.";
	
		else
			echo "Not Updated";
	
		$dbconn->__destruct ();
	}
	
	private function crypto_rand_secure($min, $max) {
		$range = $max - $min;
		if ($range < 0) return $min; // not so random...
		$log = log($range, 2);
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd >= $range);
		return $min + $rnd;
	}
	
	private function getToken($length=32){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "0123456789";
		for($i=0;$i<$length;$i++){
			$token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
		}
		return $token;
	}
	
	public function resetPasscode($user,$email){
		$token = $this->getToken(32);
		$dbconn = new dbconnection ( $user );
		
		if ($user == 'customer'){
			$result = $dbconn->resetPasscode ($token,$email);
		}
		elseif ($user == 'admin'){
		
		}
		
		if ($result === true)
			echo "Passcode reset successfully.";
		
		else
			echo "Not Reset";
		
		$dbconn->__destruct ();
		
				
	}
}

?>