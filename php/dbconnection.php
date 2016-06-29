<?php

/**
 * @author Baps
 * @copyright 2015
 */

// load configuration file
require_once ('config.php');

// the database connection class
class dbconnection {
	// class properties
	private $dbhandler;
	private $xmlhandler;
	
	// methods: contructor
	function __construct($user) {
		
		// create a database connection
		if ($user == 'admin') {
			$this->dbhandler = new mysqli ( HOST, USER_ADMIN, USER_ADMIN_PASS, DATABASE );
		} else if ($user == 'customer') {
			
			$this->dbhandler = new mysqli ( HOST, USER_CUSTOMER, USER_CUSTOMER_PASS, DATABASE );
		} else {
			print 'Please Specify a user';
			exit ();
		}
	}
	// get's the id associated with each email address
	public function get_user_id($email, $user) {
		$email = $this->dbhandler->real_escape_string ( $email );
		
		if ($user == 'customer') {
			$query_str = "SELECT id FROM customer WHERE email = '" . $email . "';";
		} elseif ($user == 'admin') {
			// execute the statement
			$query_str = "SELECT id FROM admin WHERE email = '" . $email . "';";
		}
		if ($result = $this->dbhandler->query ( $query_str )) {
			
			$column = mysqli_fetch_array ( $result );
			
			return $column [0];
		}
	}
	
	// registers a new customer in the db
	public function newCustomer($fn, $ln, $email, $phone, $address, $passcode) {
		
		// validate input
		$fn = $this->dbhandler->real_escape_string ( $fn );
		$ln = $this->dbhandler->real_escape_string ( $ln );
		$email = $this->dbhandler->real_escape_string ( $email );
		$phone = $this->dbhandler->real_escape_string ( $phone );
		$address = $this->dbhandler->real_escape_string ( $address );
		$passcode = $this->dbhandler->real_escape_string ( $passcode );
		
		// p wording
		$passcode = hash ( 'sha256', $passcode, false );
		$passcode = substr ( $passcode, 0, 50 );
		
		// sql query
		$query_str = "INSERT INTO customer VALUES ('', '$fn', '$ln', '$email', '$phone', '$address', '$passcode','',''); ";
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	public function updateCustomer($firstname, $lastname, $email, $phone, $address) {
		// session_start();
		// first name and last name are always required
		$firstname = $this->dbhandler->real_escape_string ( $firstname );
		$lastname = $this->dbhandler->real_escape_string ( $lastname );
		$email = $this->dbhandler->real_escape_string ( $email );
		$phone = $this->dbhandler->real_escape_string ( $phone );
		$address = $this->dbhandler->real_escape_string ( $address );
		
		$query_str = "UPDATE Customer
					  SET firstname='" . $firstname . "' ,lastname ='" . $lastname . "' ,email = '" . $email . "' ,phone = '" . $phone . "', address = '" . $address . "'
					  WHERE id = " . $_SESSION ['email'] . ";";
		
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	public function deleteCustomer() {
		$query_str = "DELETE FROM Customer WHERE id = " . $_SESSION ['email'] . ";";
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	public function updatePasscode($oldpasscode, $newpasscode, $user) {
		$oldpasscode = $this->dbhandler->real_escape_string ( $oldpasscode );
		$newpasscode = $this->dbhandler->real_escape_string ( $newpasscode );
		
		$oldpasscode = hash ( 'sha256', $oldpasscode, false );
		$oldpasscode = substr ( $oldpasscode, 0, 50 );
		
		$newpasscode = hash ( 'sha256', $newpasscode, false );
		$newpasscode = substr ( $newpasscode, 0, 50 );
		
		if ($user == 'customer')
			$query_str = "SELECT passcode FROM customer WHERE id = " . $_SESSION ['email'] . ";";
		elseif ($user == 'admin')
			$query_str = "SELECT passphrase FROM admin WHERE id = " . $_SESSION ['email'] . ";";
		
		if ($result = $this->dbhandler->query ( $query_str )) {
			
			$column = mysqli_fetch_array ( $result );
			
			if ($column [0] == $oldpasscode) {
				if ($user == 'customer') {
					$query_str = "UPDATE Customer
					  		  SET passcode='" . $newpasscode . "'
					  		  WHERE id = " . $_SESSION ['email'] . ";";
				} elseif ($user == 'admin') {
					$query_str = "UPDATE admin
					  		  SET passphrase='" . $newpasscode . "'
					  		  WHERE id = " . $_SESSION ['email'] . ";";
				}
				if ($this->dbhandler->query ( $query_str )) {
					
					return true;
				} else {
					return false;
				}
				return true;
			}
		} else
			return false;
	}
	public function updateToken($token, $email) {
		$token = $this->dbhandler->real_escape_string ( $token );
		$query_str = "UPDATE customer
					  		  SET token='" . $token . "'
					  		  WHERE email = '" . $email . "';";
		// echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str )) {
			
			return true;
		} else
			return false;
	}
	public function login($email, $password, $user) {
		$email = $this->dbhandler->real_escape_string ( $email );
		
		$password = hash ( 'sha256', $password, false );
		$password = substr ( $password, 0, 50 );
		
		if ($user === 'customer') {
			$query_str = "SELECT passcode FROM customer WHERE email ='" . $email . "';";
		} elseif ($user === 'admin') {
			
			$query_str = "SELECT passphrase FROM admin WHERE email ='" . $email . "';";
		}
		
		// echo $query_str. '<br />';
		// execute the statement
		$result = $this->dbhandler->query ( $query_str );
		
		$column = mysqli_fetch_array ( $result );
		
		if ($column [0] == $password) {
			
			return true;
		} else
			return false;
	}
	public function logOut() {
	}
	public function newFabric($name, $type, $category, $color, $dimension, $make_country, $price, $image) {
		$name = $this->dbhandler->real_escape_string ( $name );
		$dimension = $this->dbhandler->real_escape_string ( $dimension );
		$make_country = $this->dbhandler->real_escape_string ( $make_country );
		$image = $this->dbhandler->real_escape_string ( $image );
		
		$query_str = "INSERT INTO Fabric VALUES('','$name','$type','$category','$color','$dimension','$make_country','$price','$image',NOW())";
		
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	// fabric
	public function updateFabricType($newtype) {
		$newtype = $this->dbhandler->real_escape_string ( $newtype );
		
		$query_str = "INSERT INTO FabricType VALUES('','$newtype',NOW())";
		
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	public function updateFabricImage($newimage) {
		$newtype = $this->dbhandler->real_escape_string ( $newimage );
		
		$query_str = "INSERT INTO FabricImage VALUES('','$newimage',NOW())";
		
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	
	// fabric
	public function updateFabricCategory($newcategory) {
		$newcategory = $this->dbhandler->real_escape_string ( $newcategory );
		
		$query_str = "INSERT INTO FabricCategory VALUES('','$newcategory',NOW())";
		
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	
	// fabric
	public function updateFabricColor($newcolor) {
		$newcolor = $this->dbhandler->real_escape_string ( $newcolor );
		
		$query_str = "INSERT INTO FabricColor VALUES('','$newcolor',NOW())";
		
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	public function newAdmin($fn, $ln, $email, $phone, $address, $securityPin, $dob, $passphrase) {
		
		// validate input
		$fn = $this->dbhandler->real_escape_string ( $fn );
		$ln = $this->dbhandler->real_escape_string ( $ln );
		$email = $this->dbhandler->real_escape_string ( $email );
		$phone = $this->dbhandler->real_escape_string ( $phone );
		$address = $this->dbhandler->real_escape_string ( $address );
		
		$dob = $this->dbhandler->real_escape_string ( $dob );
		$passphrase = $this->dbhandler->real_escape_string ( $passphrase );
		
		// p wording
		$passphrase = hash ( 'sha256', $passphrase, false );
		$passphrase = substr ( $passphrase, 0, 50 );
		
		// sql query
		$query_str = "INSERT INTO admin VALUES ('', '$fn', '$ln', '$email', '$phone', '$address', $securityPin, '$dob', '$passphrase','') ";
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	public function updateAdmin($firstname, $lastname, $email, $phone, $address) {
		$firstname = $this->dbhandler->real_escape_string ( $firstname );
		$lastname = $this->dbhandler->real_escape_string ( $lastname );
		$email = $this->dbhandler->real_escape_string ( $email );
		$phone = $this->dbhandler->real_escape_string ( $phone );
		$address = $this->dbhandler->real_escape_string ( $address );
		
		$query_str = "UPDATE admin
					  SET firstname='" . $firstname . "' ,lastname ='" . $lastname . "' ,email = '" . $email . "' ,phone = '" . $phone . "', address = '" . $address . "'
					  WHERE id = " . $_SESSION ['email'] . ";";
		
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
	}
	public function deleteAdmin() {
		$query_str = "DELETE FROM admin WHERE id = " . $_SESSION ['email'] . ";";
		echo $query_str . '<br />';
		// execute the statement
		$this->dbhandler->query ( $query_str );
	}
	public function resetAdminCode() {
	}
	
	// public function changeAdminCode() {
	// }
	public function updatePin($oldpin, $newpin) {
		// turning commands into string
		$oldpin = $this->dbhandler->real_escape_string ( $oldpin );
		$newpin = $this->dbhandler->real_escape_string ( $newpin );
		
		// checking user permission
		
		$query_str = "SELECT secuirity_pin FROM admin WHERE id ='" . $_SESSION ['email'] . "'; ";
		echo $query_str;
		
		$result = $this->dbhandler->query ( $query_str ) or die ( mysql_error () ); // result is a mysql result object
		$column = mysqli_fetch_array ( $result ); // column is the item selected for
		
		if ($column [0] == $oldpin) {
			
			// if the old pin is correct then changes the pin
			$query_str = "UPDATE admin SET secuirity_pin='" . $newpin . "' WHERE id = " . $_SESSION ['email'] . "; ";
			$this->dbhandler->query ( $query_str );
			
			return true;
		} else
			return false; // if the old pin is not correct then returns false
	}
	// new function creadted for password reset
	public function checkEmailPresent($email) {
		$query_str = "SELECT email FROM customer WHERE email = '" . $email . "';";
		echo $query_str;
		$result = $this->dbhandler->query ( $query_str );
		
		$column = mysqli_fetch_array ( $result );
		
		if ($column [0] === $email) {
			return true;
		} else
			return false;
	}
	public function getCustomers() {
	}
	public function getCustomer() {
	}
	public function getAdministrators() {
	}
	public function getAdministrator() {
	}
	public function getFabric($id) {
		$query_str = "SELECT * FROM Fabric;";
		echo $query_str;
		$json = array();
		$result = $this->dbhandler->query ( $query_str );
		
		$column = mysqli_fetch_array ( $result );
		
		while ( $column = mysqli_fetch_array ( $result ) ) {
			
			$fabric = array (
					'id' => $column ['id'],
					'name' => $column ['name'],
					'type' => $column ['type'],
					'category' => $column ['category'],
					'color' => $column ['color'],
					'dimension' => $column ['dimension'],
					'country' => $column ['make_country'],
					'price' => $column ['price'] 
			);
			array_push($json, $fabric);
		}
		$jsonstring = json_encode($json);
		echo $jsonstring;
	}
	public function getFabrics() {
		$query_str = "SELECT * FROM Fabric;";
		echo $query_str;
		$json = array();
		$result = $this->dbhandler->query ( $query_str );
		
		while ( $column = mysqli_fetch_array ( $result ) ) {
			
			$fabric = array (
					'id' => $column ['id'],
					'name' => $column ['name'],
					'type' => $column ['type'],
					'category' => $column ['category'],
					'color' => $column ['color'],
					'dimension' => $column ['dimension'],
					'country' => $column ['make_country'],
					'price' => $column ['price'] 
			);
			array_push($json, $fabric);
		}
		$jsonstring = json_encode($json);
		return  $jsonstring;
	}
	function getFabricCategory() {
		$query_str = "SELECT * FROM FabricCategory;";
		echo $query_str;
		$json = array ();
	
		$result = $this->dbhandler->query($query_str);
		
	
		while ($column = mysqli_fetch_array($result)){
			$fabric = array (
					'id' => $column ['id'],
					'category' => $column ['category']
			);
			array_push ( $json, $fabric );
		}
		$jsonstring = json_encode ( $json );
		return   $jsonstring;
	}
	function getFabricColor() {
		$query_str = "SELECT * FROM FabricColor;";
		echo $query_str;
		$json = array ();
	
		$result = $this->dbhandler->query($query_str);
	
	
		while ($column = mysqli_fetch_array($result)){
			$fabric = array (
					'id' => $column ['id'],
					'color' => $column ['color']
			);
			array_push ( $json, $fabric );
		}
		$jsonstring = json_encode ( $json );
		return   $jsonstring;
	}
	
	
	public function newOrder($customerid,$fabricid,$quantity,$price,$billingadd,$deliveryadd) {
		$billingadd = $this->dbhandler->real_escape_string ($billingadd);
		$deliveryadd = $this->dbhandler->real_escape_string ($deliveryadd);
		
		// sql query
		$query_str = "INSERT INTO order_ VALUES ('', '$customerid', '$fabricid', '$quantity', '$price', '$billingadd', '$deliveryadd', NOW(), '',''); ";
		echo $query_str . '<br />';
		// execute the statement
		if ($this->dbhandler->query ( $query_str ))
			return true;
		else
			return false;
		
		
		
	} 
	public function updateOrder() {
	}
	public function deleteOrder() {
	}
	public function getOrder() {
	}
}

?>