<?php
	/**
	 * Filename  - authRegistrationFormD.php
	 * File path - C:\xampp\htdocs\Project\Repository\
	 * Description : Validates, authenticate and store registration credentials
	 * @author  : Alokik Pathak
	 * Created date : 20/07/2018
	 */
	 
	/** Declare and initialize variables used in the program **/
	$firstNameError = $lastNameError = $emailError = $mobileError = $addressError 
	=$departmentError = $passwordError="";
	$dataFirstName = $dataLastName = $dataEmail = $dataMobile = $dataAddress 
	=$dataDepartment = $dataPassword = "";
	
	/** Parsing client data and storing it different variables **/
	$formDataJsonArray= json_decode($_POST['data'],true);
	
	$operationCode = $formDataJsonArray['operation'];
	$key = $formDataJsonArray['keyValue'];
	$dataFirstName = $formDataJsonArray['firstName'];
	$dataLastName = $formDataJsonArray['lastName'];
	$dataEmail = $formDataJsonArray['email'];
	$dataMobile = $formDataJsonArray['mobile'];
	$dataAddress = $formDataJsonArray['address'];
	$dataDepartment = $formDataJsonArray['department'];
	$dataPassword = $formDataJsonArray['password'];
	
	
	/** Initialize Server response JSON object **/
	$myObj = new StdClass;
	$myObj->operation = "";
	$myObj->code = "";
	$myObj->status = "";
	$myObj->error = "";
	$myObj->id = "";
	$myObj->firstName = "";
	$myObj->lastName = "";
	$myObj->email = "";
	$myObj->mobile = "";
	$myObj->address = "";
	$myObj->department = "";
	$myObj->password = '';
	
	include_once('constantVariables.php');
	/** Establish connection with Server and checking it **/
	$db = include('config.php');
	$con = mysqli_connect($db['host'], $db['user'],$db['password']);
	if(!$con){
		//echo'Not connected to Server';
		echo SERVER_ERROR;
	}
	if(!mysqli_select_db($con, $db['database'])){
		//echo'Not conneted to database';
		echo DB_ERROR;
	}
	
   /**
	* Sanitize all user's credentials.
	*  
	*/
	function sanitizeCredentials(){
		global $dataFirstName, $dataLastName, $dataEmail, $dataMobile,
		$dataPassword, $dataAddress, $dataDepartment;
		
		$dataFirstName = filter_var($dataFirstName, FILTER_SANITIZE_STRING);
		$dataLastName = filter_var($dataLastName, FILTER_SANITIZE_STRING);
		$dataEmail = filter_var($dataEmail, FILTER_SANITIZE_EMAIL);
		$dataMobile = filter_var($dataMobile, FILTER_SANITIZE_STRING);
		$dataAddress = filter_var($dataAddress, FILTER_SANITIZE_STRING);
		$dataDepartment = filter_var($dataDepartment, FILTER_SANITIZE_STRING);
		$dataPassword = filter_var($dataPassword, FILTER_SANITIZE_STRING);
	}
	
   /**
	* Validates department data.
	*  
	* @return boolean if valid returns false else true
	*/
	function checkDepartment(){
		
		global $dataDepartment, $departmentError;
		
		$resultCompareA = strcmp(DEPARTMENT1, $dataDepartment);
		$resultCompareB = strcmp(DEPARTMENT2, $dataDepartment);
		$resultCompareC = strcmp(DEPARTMENT3, $dataDepartment);
		
		if( $dataDepartment === "" ){
			$departmentError = DEPARTMENT_ERROR1;
			return true;
		}
		if( $resultCompareA == 0 || $resultCompareB == 0 || $resultCompareC == 0 ){
			return false;
		}
		
		$departmentError = DEPARTMENT_ERROR2; 
		return true;
		

	}
	
	/**
	 * Validates First Name data.
   	 *  
	 * @return boolean if valid returns false else true
	 */
	function checkFirstName()
	{
		global $firstNameError, $dataFirstName;
		
		if( $dataFirstName === ""){
			$firstNameError= FIRSTNAME_ERROR1; 
			return true;
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$dataFirstName)){
			$firstNameError= FIRSTNAME_ERROR2; 
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	 * Validates Last Name data.
   	 *  
	 * @return boolean if valid returns false else returns true.
	 */
	function checkLastName(){
		
		global $dataLastName, $lastNameError;
		
		if( $dataLastName !== "" ){
			if(!preg_match("/^[a-zA-Z ]*$/",$dataLastName)){
				$lastNameError = LASTNAME_ERROR;
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Validates Email data.
   	 *  
	 * @return boolean if valid returns false else returns true.
	 */
	function checkEmail()
	{
		if( $GLOBALS['dataEmail'] === "" ){
			$GLOBALS['emailErr'] = EMAIL_ERROR1;
			return true;
		}else if( !preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $GLOBALS['dataEmail'] )){
			$GLOBALS['emailErr'] = EMAIL_ERROR2;
			return true;
		}
		return false;
	}
	
	/**
	 * Validates Mobile data.
   	 *  
	 * @return boolean if valid returns false else returns true.
	 */
	function checkMobile()
	{
		if( $GLOBALS['dataMobile'] === "" ){
			$GLOBALS['mobileErr'] = MOBILE_ERROR1; 
			return true;
		}else if( !preg_match('/^(\+\d{1,3}[- ]?)?\d{10}$/',$GLOBALS['dataMobile'])){
			$GLOBALS['mobileErr'] = MOBILE_ERROR2;
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
		if( $GLOBALS['dataPassword'] === "" ){
			$GLOBALS['passwordErr'] = PASSWORD_ERROR1; 
			return true;
		}
		else if(strlen($GLOBALS['dataPassword'])<8){
			$GLOBALS['passwordErr'] = PASSWORD_ERROR2;
			return true;
		}
		return false;
	}
	
	/**
	 * Validates all user's data.
   	 *  
	 * @return boolean if valid returns false else returns true.
	 */
	function validateCredentials(){
		
		$statusFirstName = checkFirstName();
		$statusLastName = checkLastName();
		$statusEmail = checkEmail();
		$statusMobile = checkMobile();
		$statusDepartment = checkDepartment();
		$statusPassword = checkPassword();
		
		if( $statusFirstName == true 
		    || $statusLastName == true
			|| $statusEmail == true
			|| $statusMobile == true
			|| $statusDepartment == true 
			|| $statusPassword == true
		){
			return true;
		}
		
		return false;
		
	}
	
	sanitizeCredentials();
	
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
			$myObj->error = SQL_DELETE_ERROR1;
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
			
			$sql = "update employeetable set firstname='$dataFirstName',
			lastname='$dataLastName', Email='$dataEmail', mobile='$dataMobile',
			address='$dataAddress', department='$dataDepartment', 
			password='$dataPassword' where Email = '$key' ";
			
			if(!mysqli_query($con, $sql)){
				$myObj->operation = "UPDATE";
				$myObj->code = 403;
				$myObj->status = "FAILURE";
				$myObj->error = SQL_UPDATE_ERROR1;
			
				$responseServerJSON = json_encode($myObj);
				echo $responseServerJSON;
			}else{
				$myObj->operation = "UPDATE";
				$myObj->code = 200;
				$myObj->status = "SUCCESS";
				$myObj->error = "";
			    $myObj->id = "";
			    $myObj->firstName = $GLOBALS['dataFirstName'];
			    $myObj->lastName = $GLOBALS['dataLastName'];
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
			$myObj->error = SQL_UPDATE_ERROR2;
			
		    $responseServerJSON = json_encode($myObj);
			echo $responseServerJSON;
		}
		
	}else if($operationCode == 1){ 
		global $myObj,$dataFirstName, $dataLastName, $dataEmail, $dataMobile;
		global $dataAddress, $dataDepartment;
		$statusValidation = validateCredentials();
		
		if( $statusValidation == false ){
			
			$id = rand(100,999).$GLOBALS['dataEmail'];
			$sql = "insert into employeetable 
			(firstname, lastname, Email, mobile, address, department, password)
			values 
			('$dataFirstName', '$dataLastName', '$dataEmail', '$dataMobile',
			'$dataAddress', '$dataDepartment', '$dataPassword')";
			
			if(!mysqli_query($con, $sql)){
				
				$myObj->operation = "INSERT";
				$myObj->code = 403;
				$myObj->status = "FAILURE";
				$myObj->error = SQL_INSERT_ERROR1;
			
				$responseServerJSON = json_encode($myObj);
				echo $responseServerJSON;
			}else{
				
				$myObj->operation = "INSERT";
				$myObj->code = 200;
				$myObj->status = "SUCCESS";
				$myObj->error = "";
			    $myObj->id = $id;
			    $myObj->firstName = $GLOBALS['dataFirstName'];
			    $myObj->lastName = $GLOBALS['dataLastName'];
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
			$myObj->error = SQL_INSERT_ERROR2;
			
		    $responseServerJSON = json_encode($myObj);
			echo $responseServerJSON;
		}
	}
	echo "FAILURE";
	    
?>