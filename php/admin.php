<?php

/**
 * @author Baps
 * @copyright2015
 * @desc customer class
 */
 
class Admin extends User
{
	private $securityPin;
	private $dob;
	private $passphrase;
	
	
	
	public function processOrders(){
		return true;
	}
	
	public  function  viewOrder()
	{
		
	}
	
	public function viewOrders()
	{
		
	}
	
}
?>