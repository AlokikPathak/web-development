<?php
	
	$dataEmail = $dataPassword = $emailErr = $passwordErr="";
	/** Decoding and storing client data **/
	$formDataJsonArray= json_decode($_POST['data'],true);
	
	$dataEmail = $formDataJsonArray['Email'];
	$dataPassword = $formDataJsonArray['Password'];
	
	/** Server side validation of Login Credentials **/
	
	/**
	 * checkEmail() is method which validates the email entered by the user.
	 * It checks first wheather the entered email is valid.
	 * Set the $emailErr message variable according to validation result.
	 * returns "true" if the entered email is invalid.
	 * returns "false" if entered email is valid.
	 */
	function checkEmail()
	{
		global $dataEmail, $emailErr;
		if( $dataEmail === "" ){
			$emailErr= "Email should be empty";
			return true;
		}else if( !preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $dataEmail )){
			$emailErr = "Email is not valid";
			return true;
		}
		return false;
	}
	
	/**
	 * checkPassword() methods check wheather the password length is >= 8.
	 * Set the $passwordErr message according to validation output.
	 * Returns true if the password is invalid else returns false.
	 */
	function checkPassword()
	{
		global $dataPassword, $passwordErr;
		if( $dataPassword === "" ){
			$passwordErr = "Password must not be empty"; 
			return true;
		}
		else if(strlen($dataPassword)<8){
			$passwordErr ="Password length must be min. 8 chars"; 
			return true;
		}
		return false;
	}
	
	/** 
	 * It validates the Client data login credentials
	 * It invoke checkEmail() and checkPassword() methods
	 * If the result of both method is false it returns false
	   else returns true stating the data is invalid
	 */
	function validateClientData(){
		$emailFlag = checkEmail();
		$passwordFlag = checkPassword();
		
		if( $emailFlag == false && $passwordFlag == false ){
			return false;
		}else{
			return true;
		}
	}
	
	$statusValidation = validateClientData();
	
	/**If the client data is valid if block will be executed otherwise else **/
	if( $statusValidation == false ){
		
		/** Establising connection with MYsqli database **/
		$mysqli = new mysqli("127.0.0.1", "root", "", "employee");
	
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
				$myObj->fname = $row[1];
				$myObj->lname = $row[2];
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
		$myObj->error =	"Client data is invalid-> ".$emailErr." ; ".$passwordErr;
		$responseServerJSON = json_encode($myObj);
		echo $responseServerJSON;	
	}
	
?>