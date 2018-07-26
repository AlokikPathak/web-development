<?php

	/**
	 * Filename  - authLoginFormA.php
	 * File path - C:\xampp\htdocs\Project\Repository\
	 * Description : Validates and authenticate login credentials
	 * @author  : Alokik Pathak
	 * Created date : 20/07/2018
	 */
	
	
	$dataEmail = $dataPassword = $emailError = $passwordError="";
	/** Decoding and storing client data **/
	$formDataJsonArray= json_decode($_POST['data'],true);
	
	$dataEmail = $formDataJsonArray['Email'];
	$dataPassword = $formDataJsonArray['Password'];
	
	/**
	 * Sanitize Email and Password data.
	 */
	function sanitizeData(){
		global $dataEmail, $dataPassword;
		$dataEmail = filter_var($dataEmail, FILTER_SANITIZE_EMAIL);
		$dataPassword = filter_var($dataPassword, FILTER_SANITIZE_STRING);
	}
	
	/**
	 * Validates Email data.
   	 *  
	 * @return boolean if valid returns false else returns true.
	 */
	function checkEmail()
	{
		global $dataEmail, $emailError;
		if( $dataEmail === "" ){
			$emailError= "Email should be empty";
			return true;
		}else if( !preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $dataEmail )){
			$emailError = "Email is not valid";
			return true;
		}
		return false;
	}
	
	/**
	 * Validates Password data.
   	 *  
	 * @return boolean if valid returns false else returns true.
	 */
	function checkPassword()
	{
		global $dataPassword, $passwordError;
		if( $dataPassword === "" ){
			$passwordError = "Password must not be empty"; 
			return true;
		}
		else if(strlen($dataPassword)<8){
			$passwordError ="Password length must be min. 8 chars"; 
			return true;
		}
		return false;
	}
	
	/**
	 * Validates all user's data.
   	 *  
	 * @return boolean if valid returns false else returns true.
	 */
	function validateClientData(){
		$emailFlag = checkEmail();
		$passwordFlag = checkPassword();
		
		if( !$emailFlag && !$passwordFlag){
			return false;
		}
		return true;
		
	}
	
	sanitizeData();
	$statusValidation = validateClientData();
	
	/**If the client data is valid if block will be executed otherwise else **/
	if( $statusValidation == false ){
		
		/** Establising connection with MYsqli database **/
		$db = include('config.php');
		$mysqli = new mysqli($db['host'], $db['user'], "", $db['database']);
	
		/** Preventing MYsqli injection **/
		$stmt = $mysqli->prepare(" Select * from employeetable where Email = ? ");
		$stmt->bind_param("s", $dataEmail);
		$stmt->execute();
		$result = $stmt->get_result();
	
		/** $result is empty else block will be excecuted else if block **/
		if($result){
		
			$row = mysqli_fetch_row($result);
			$storePassword = $row[7];
		
			/** Comparing the client's password with Database password **/
			$x = strcmp($storePassword, $GLOBALS['dataPassword']);
			
			if($x!=0){
				$myObj = new StdClass;
				$myObj->code = 404;
				$myObj->result = "FAILURE";
				
				$responseServerJSON = json_encode($myObj);
				echo $responseServerJSON;		
			}else{	
				$myObj = new StdClass;
				$myObj->code = 200;
				$myObj->result = "SUCCESS";
				$myObj->firstName = $row[1];
				$myObj->lastName = $row[2];
				$myObj->email = $row[3];
				$myObj->mobile = $row[4];
				$myObj->address = $row[5];
				$myObj->department = $row[6];
				$myObj->password = $row[7];
				
				$responseServerJSON = json_encode($myObj);
				echo $responseServerJSON;
			}
		}else{
			echo'Query not executed: ';
		}
	
		$stmt->close();
		$mysqli->close();
	
	}else{
		
		$myObj = new StdClass;
		$myObj->code = 404;
		$myObj->result = "FAILURE";
		$myObj->error =	"Client data is invalid-> ".$emailError." ; ".$passwordError;
		$responseServerJSON = json_encode($myObj);
		echo $responseServerJSON;	
	}
	
?>