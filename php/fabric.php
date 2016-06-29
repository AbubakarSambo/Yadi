<?php
require_once ('config.php');

class Fabric {
	private $name;
	private $type; // cotton silk leather
	               // private $make;
	private $color;
	private $dimension;
	private $make_country;
	private $price; // per yard
	private $in_stock;
	private $category; // shadda atampa plain
	private $image;
	function updateInventory($name, $type, $category, $color, $dimension, $make_country, $price, $image) {
		$dbconn = new dbconnection ( 'admin' );
		$result = $dbconn->newFabric ( $name, $type, $category, $color, $dimension, $make_country, $price, $image );
		
		if ($result === true)
			echo "Inventory updated";
		
		else
			echo "Inventry Not Updated";
		
		$dbconn->__destruct ();
	}
	function calculateAmount() {
		return $this->price * $this->dimension;
	}
	
	// what's the difference between addfabtype and updatefabtype
	function addFabricType($newType) {
	}
	function updateFabricType($newType) {
		$dbconn = new dbconnection ( 'admin' );
		
		$result = $dbconn->updateFabricType ( $newType );
		
		if ($result === true)
			echo "type updated";
		
		else
			echo "type Not Updated";
		
		$dbconn->__destruct ();
	}
	function updateFabricCategory($newCategory) {
		$dbconn = new dbconnection ( 'admin' );
		
		$result = $dbconn->updateFabricCategory ( $newCategory );
		
		if ($result === true)
			echo "updated";
		
		else
			echo "Not Updated";
		
		$dbconn->__destruct ();
	}
	function updateFabricColor($newColor) {
		$dbconn = new dbconnection ( 'admin' );
		
		$result = $dbconn->updateFabricColor ( $newColor );
		
		if ($result === true)
			echo "updated";
		
		else
			echo "Not Updated";
		
		$dbconn->__destruct ();
	}
	function updateFabricImage($image) {
		$dbconn = new dbconnection ( 'admin' );
		
		$result = $dbconn->updateFabricImage ( $image );
		
		if ($result === true)
			echo "updated";
		
		else
			echo "Not Updated";
		
		$dbconn->__destruct ();
	}
	function getFabric($id) {
		$dbconn = new dbconnection ( 'admin' );
		
		$result = $dbconn->getFabric ( $id );
		
		// echo $result[8];
	}
	function getFabrics() {
		$dbconn = new dbconnection ( 'admin' );
		
		$result = $dbconn->getFabrics ();
		
		return $result;
	}
	function getFabricCategory() {
		$dbconn = new dbconnection ( 'admin' );
		
		$result = $dbconn->getFabricCategory();
		
		echo  $result;
	}
	function getFabricColor() {
		$dbconn = new dbconnection ( 'admin' );
	
		$result = $dbconn->getFabricColor();
	
		echo  $result;
	}
	
}

?>