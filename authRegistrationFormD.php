<?php
	
	/**Declare and initialize variables used in the program **/
	$fnameErr = $lnameErr = $emailErr = $mobileErr = $addressErr 
	=$departmentErr = $passwordErr="";
	$dataFName = $dataLName = $dataEmail = $dataMobile = $dataAddress 
	=$dataDepartment = $dataPassword = "";
	
	/** Parsing client data and storing it different variables **/
	$formDataJsonArray= json_decode($_POST['data'],true);
	
	$operationCode = $formDataJsonArray['operation'];
	$key = $formDataJsonArray['keyValue'];
	$dataFName = $formDataJsonArray['fname'];
	$dataLName = $formDataJsonArray['lname'];
	$dataEmail = $formDataJsonArray['email'];
	$dataMobile = $formDataJsonArray['mobile'];
	$dataAddress = $formDataJsonArray['address'];
	$dataDepartment = $formDataJsonArray['department'];
	$dataPassword = $formDataJsonArray['password'];
	
	/**Initialize Server response JSON object **/
	$myObj = new StdClass;
	$myObj->operation = "";
	$myObj->code = "";
	$myObj->status = "";
	$myObj->error = "";
	$myObj->id = "";
	$myObj->fname = "";
	$myObj->lname = "";
	$myObj->email = "";
	$myObj->mobile = "";
	$myObj->address = "";
	$myObj->department = "";
	$myObj->password = '';
	
	/** Establish connection with Server and checking it **/
	$con = mysqli_connect('127.0.0.1', 'root','');
	if(!$con){
		echo'Not connected to Server';
	}
	if(!mysqli_select_db($con, 'employee')){
		echo'Not conneted to database';
	}
	
	/**
	 * checkDepartment() method is invoked for cheking department data
	 * If $Department is 'Software Engineer' or 'Software Test Engineer'
	   or 'UX/UI Engineer' it returns false else it returns true;
	 * It set the $departmentErr message according to validation output.
	 */
	function checkDepartment(){
		
		global $dataDepartment, $departmentErr;
		
		$x = strcmp('Software Engineer', $dataDepartment);
		$y = strcmp('Software Test Engineer', $dataDepartment);
		$z = strcmp('UX/UI Engineer', $dataDepartment);
		
		if( $dataDepartment === "" ){
			$departmentErr = "Department must not be empty";	
			return true;
		}else if( $x==0 || $y==0 || $z==0 ){
			return false;
		}else{
			$departmentErr = "Invalid department"; 
			return true;
		}
		
	}
	
	/**
	 * checkFName() is method which validates the first name entered by the user.
	 * set the $fnameErr message according to validation result.
	 * returns "true" if the entered name is invalid.
	 * returns "false" if entered name is valid.
	 */
	function checkFName()
	{
		global $fnameErr, $dataFName;
		
		if( $dataFName === ""){
			$fnameErr="First name should not remain empty"; 
			return true;
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$dataFName)){
			$fnameErr="First should contain only alphabets"; 
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	 * checkLName() is method which validates the last name entered by the user.
	 * set the $lnameErr message according to validation result.
	 * returns "true" if the entered last name is invalid.
	 * returns "false" if entered last name is valid.
	 */
	function checkLName(){
		
		global $dataLName, $lnameErr;
		
		if( $dataLName !== "" ){
			if(!preg_match("/^[a-zA-Z ]*$/",$dataLName)){
				$lnameErr = "Last should contain only alphabets";
				return true;
			}
		}
		return false;
	}
	
	/**
	 * checkEmail() is method which validates the email entered by the user.
	 * It checks first wheather the entered email is valid.
	 * Set the $emailErr message variable according to validation result.
	 * returns "true" if the entered email is invalid.
	 * returns "false" if entered email is valid.
	 */
	function checkEmail()
	{
		if( $GLOBALS['dataEmail'] === "" ){
			$GLOBALS['emailErr'] = "Email should be empty";
			return true;
		}else if( !preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $GLOBALS['dataEmail'] )){
			$GLOBALS['emailErr'] = "Email is not valid";
			return true;
		}
		return false;
	}
	
	/** 
	 * checkMobile() is method which validates the mobile no. entered by the user.
	 * It checks first wheather the entered mobile no. is valid.
	 * It set the $mobileErr message according to validation result.
	 * returns "true" if the entered mobile is invalid & not having any duplicate.
	 * returns "false" if entered mobile is valid.
	 */
	function checkMobile()
	{
		if( $GLOBALS['dataMobile'] === "" ){
			$GLOBALS['mobileErr'] = "Mobile No. should not be empty"; 
			return true;
		}else if( !preg_match('/^(\+\d{1,3}[- ]?)?\d{10}$/',$GLOBALS['dataMobile'])){
			$GLOBALS['mobileErr'] = "Mobile no. should contain 10 numeric chars";
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
		if( $GLOBALS['dataPassword'] === "" ){
			$GLOBALS['passwordErr'] = "Password must not be empty"; 
			return true;
		}
		else if(strlen($GLOBALS['dataPassword'])<8){
			$GLOBALS['passwordErr'] ="Password length must be min. 8 chars"; 
			return true;
		}
		return false;
	}
	
	/**
	 * validateCredentials() method invoke all the methods used for validation
	 * Store the results of all validation methods
	 * If all the results are false it returns false as validated & o/p correct
	 * If output of any method invoked is true finally returns true.
	 */
	function validateCredentials(){
		
		$statusFName = checkFName();
		$statusLName = checkLName();
		$statusEmail = checkEmail();
		$statusMobile = checkMobile();
		$statusDepartment = checkDepartment();
		$statusPassword = checkPassword();
		
		if( $statusFName == true 
		    || $statusLName == true
			|| $statusEmail == true
			|| $statusMobile == true
			|| $statusDepartment == true 
			|| $statusPassword == true
		){
			return true;
		}else{
			return false;
		}
		
	}
	
	
	/**
	 * Different SQL operations are performed depending on $operationCode
	 * $operationCode=3 for Delete Operation
	 * $operationCode=2 for Update Operation
	 * $operationCode=1 for Insert Operation
	 */
	if($operationCode == 3){
		global $key;
		
		$sql = "delete from employeetable where Email = '$key' ";
		
		if(!mysqli_query($con, $sql)){
		
			$myObj->operation = "DELETE";
			$myObj->code = 403;
			$myObj->status = "FAILURE";
			$myObj->error = "DELETE query not executed!";
			$responseServerJSON = json_encode($myObj);
			echo $responseServerJSON;
		}else{
			
			$myObj->operation = "DELETE";
			$myObj->code = 200;
			$myObj->status = "SUCCESS";
			$myObj->error = "";
			$responseServerJSON = json_encode($myObj);
			echo $responseServerJSON;
		}
		
		
		
	}else if($operationCode == 2){ 
		
		$statusValidation = validateCredentials();
		
		if( $statusValidation == false ){
			
			$sql = "update employeetable set firstname='$dataFName',
			lastname='$dataLName', Email='$dataEmail', mobile='$dataMobile',
			address='$dataAddress', department='$dataDepartment', 
			password='$dataPassword' where Email = '$key' ";
			
			if(!mysqli_query($con, $sql)){
				$myObj->operation = "UPDATE";
				$myObj->code = 403;
				$myObj->status = "FAILURE";
				$myObj->error = "Update query not executed!";
			
				$responseServerJSON = json_encode($myObj);
				echo $responseServerJSON;
			}else{
				$myObj->operation = "UPDATE";
				$myObj->code = 200;
				$myObj->status = "SUCCESS";
				$myObj->error = "";
			    $myObj->id = "";
			    $myObj->fname = $GLOBALS['dataFName'];
			    $myObj->lname = $GLOBALS['dataLName'];
			    $myObj->email = $GLOBALS['dataEmail'];
			    $myObj->mobile = $GLOBALS['dataMobile'];
			    $myObj->address = $GLOBALS['dataAddress'];
			    $myObj->department = $GLOBALS['dataDepartment'];
				$myObj->password = $GLOBALS['dataPassword'];
		
			    $responseServerJSON = json_encode($myObj);
			    echo $responseServerJSON;
		    }
		
		}else{
			$myObj->operation = "UPDATE";
			$myObj->code = 403;
			$myObj->status = "FAILURE";
			$myObj->error = "Invalid Credentials for Update!";
			
		    $responseServerJSON = json_encode($myObj);
			echo $responseServerJSON;
		}
		
	}else if($operationCode == 1){ 
		global $myObj,$dataFName, $dataLName, $dataEmail, $dataMobile;
		global $dataAddress, $dataDepartment;
		$statusValidation = validateCredentials();
		
		if( $statusValidation == false ){
			
			$id = rand(100,999).$GLOBALS['dataEmail'];
			$sql = "insert into employeetable 
			(firstname, lastname, Email, mobile, address, department, password)
			values 
			('$dataFName', '$dataLName', '$dataEmail', '$dataMobile',
			'$dataAddress', '$dataDepartment', '$dataPassword')";
			
			if(!mysqli_query($con, $sql)){
				
				$myObj->operation = "INSERT";
				$myObj->code = 403;
				$myObj->status = "FAILURE";
				$myObj->error = "Insert query not executed!";
			
				$responseServerJSON = json_encode($myObj);
				echo $responseServerJSON;
			}else{
				
				$myObj->operation = "INSERT";
				$myObj->code = 200;
				$myObj->status = "SUCCESS";
				$myObj->error = "";
			    $myObj->id = $id;
			    $myObj->fname = $GLOBALS['dataFName'];
			    $myObj->lname = $GLOBALS['dataLName'];
			    $myObj->email = $GLOBALS['dataEmail'];
			    $myObj->mobile = $GLOBALS['dataMobile'];
			    $myObj->address = $GLOBALS['dataAddress'];
			    $myObj->department = $GLOBALS['dataDepartment'];
				$myObj->password = $GLOBALS['dataPassword'];
		
			    $responseServerJSON = json_encode($myObj);
				echo $responseServerJSON;
		    }
			
		}else{
			$myObj->operation = "INSERT";
			$myObj->code = 403;
			$myObj->status = "FAILURE";
			$myObj->error = "Invalid credentials for insert!";
			
		    $responseServerJSON = json_encode($myObj);
			echo $responseServerJSON;
		}
	}
	    
?>