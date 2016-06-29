<?php

/**
 * @author Baps
 * @copyright2015
 * @desc customer class
 */
 
class Customer extends User
{
	private $userID;
	private $passcode;
	
	
	
	public function makeOrder($customerid,$fabricid,$quantity,$price,$billingadd,$deliveryadd){
		
		$dbconn = new dbconnection ( 'customer' );
		
		$customerid = $_SESSION['email']; 
		
		$result = $dbconn->newOrder($customerid,$fabricid,$quantity,$price,$billingadd,$deliveryadd);
		
		if ($result === true)
			echo "order succesful";
		
		else
			echo "Order Unsuccesful";
		
	}
	
	public  function  checkOrder()
	{
		
	}
	
	public function orderHistory()
	{
		
	}
	
}
?>