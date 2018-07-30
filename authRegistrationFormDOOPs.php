<?php
/**
 * File Name : authRegistrationFormDOOPs.php
 * File Path : C:\xampp\htdocs\Project\Repository\
 * Description : Validate and register user's data in database
 * Created : 27/07/2018
 * @author : Alokik Pathak
 */

 /**
  * Validates and perform SQL operation using user credentials with the database
  *
  * @author Alokik Pathak
  */
class RegisterUserData
{
	private $operationCode;
	private $keyId;
	private $firstName;
	private $lastName;
	private $email;
	private $password;
	private $mobile;
	private $address;
	private $department;
	
	private $statusEmail = true;
	private $statusPassword = true;
	private $statusFirstName = true;
	private $statusLastName = true;
	private $statusMobile = true;
	private $statusDepartment = true;
	
	private $statusValidation = true;
	public  $statusRegistration = true;
	private $responseCode = 403;
	private $responseStatus = "";
	private $error = "";
	private $operation = "";
	
	/**
	 * Initialize all members of class RegisterUserData
	 * 
	 * @param integer $operatioCode
	 * @param string $keyId
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $email
	 * @param string $mobile
	 * @param string $address
	 * @param string $department
	 * @param string $password
	 */
	function __construct( $operationId, $keyId, $firstName, $lastName, $email, $mobile, $address, $department, $password)
	{
		$this->operationCode = $operationId;
		$this->keyId = $keyId;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->password = $password;
		$this->mobile = $mobile;
		$this->address = $address;
		$this->department = $department;
	}
	
	
	/**
	 * Validates First Name data.
   	 *  
	 * @return boolean if valid returns false else true
	 */
	public function validateFirstName()
	{	
		include_once('constantVariables.php');
		if( $this->firstName === ""){
			$this->error = FIRSTNAME_ERROR1; 
			return true;
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$this->firstName)){
			$this->error = FIRSTNAME_ERROR2; 
			return true;
		}
		return false;
	}
	
	/**
	 * Validates Last Name data.
   	 *  
	 * @return boolean if valid returns false else returns true.
	 */
	function validateLastName()
	{
		include_once('constantVariables.php');
		if( $this->lastName !== "" ){
			if(!preg_match("/^[a-zA-Z ]*$/",$this->lastName)){
				$this->error = LASTNAME_ERROR;
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Validates Email of the user
	 *
	 * @return boolean true if email is invalid else false
	 */
	public function validateEmail()
	{
		include_once('constantVariables.php');
		if( $this->email === "" ){
			$this->error = EMAIL_ERROR1;
			return true;
		}else if( !preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $this->email )){
			$this->error = EMAIL_ERROR2;
			return true;
		}
		return false;
	}
	
	/**
	 * Validates Mobile data.
   	 *  
	 * @return boolean if valid returns false else returns true.
	 */
	function validateMobile()
	{
		include_once('constantVariables.php');
		if( $this->mobile === "" ){
			$this->error = MOBILE_ERROR1; 
			return true;
		}else if( !preg_match('/^(\+\d{1,3}[- ]?)?\d{10}$/',$this->mobile)){
			$this->error = MOBILE_ERROR2;
			return true;
		}
		return false;
	}
	
	
	/**
	 * Validates password of the user
	 *
	 * @return boolean true if email is invalid else false
	 */
	public function validatePassword()
	{
		include_once('constantVariables.php');
		if( $this->password === "" ){
			$this->error = PASSWORD_ERROR1; 
			return true;
		}
		else if(strlen($this->password)<8){
			$this->error = PASSWORD_ERROR2; 
			return true;
		}
		return false;
	}
	
    /**
	 * Validates department data.
	 *  
	 * @return boolean if valid returns false else returns true
	 */
	function validateDepartment()
	{	
		include_once('constantVariables.php');
		if( $this->department === "" ){
			$this->error = DEPARTMENT_ERROR1."***".$this->department."####";
			return true;
		}
		
		$resultCompareA = strcmp(DEPARTMENT1, $this->department);
		$resultCompareB = strcmp(DEPARTMENT2, $this->department);
		$resultCompareC = strcmp(DEPARTMENT3, $this->department);
		
		if( $resultCompareA == 0 || $resultCompareB == 0 || $resultCompareC == 0 ){
			return false;
		}
		
		$this->error = DEPARTMENT_ERROR2; 
		return true;
	}
	
	/**
	 * Validates User registration data
	 *  
	 * @return boolean if valid returns false else returns true
	 */
	public function validateUser()
	{
		$this->statusFirstName = $this->validateFirstName();
		$this->statusLastName = $this->validateLastName();
		$this->statusEmail = $this->validateEmail();
		$this->statusMobile = $this->validateMobile();
		$this->statusPassword = $this->validatePassword();
		$this->statusDepartment = $this->validateDepartment();
		
		if( $this->statusFirstName || $this->statusLastName || $this->statusEmail
   		|| $this->statusMobile || $this->statusPassword || $this->statusDepartment){
			$this->statusValidation = true;
		}
		$this->statusValidation = false;
	}
	
	/**
	 * Sanitize all user's credentials.
	 *  
	 */
	function sanitizeCredentials(){
		
		$this->firstName = filter_var($this->firstName, FILTER_SANITIZE_STRING);
		$this->lastName = filter_var($this->lastName, FILTER_SANITIZE_STRING);
		$this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
		$this->mobile = filter_var($this->mobile, FILTER_SANITIZE_STRING);
		$this->address = filter_var($this->address, FILTER_SANITIZE_STRING);
		$this->department = filter_var($this->department, FILTER_SANITIZE_STRING);
		$this->password = filter_var($this->password, FILTER_SANITIZE_STRING);
	}
	
	/**
	 * Validate all user's credentials and perform SQL operation
	 *  
	 * @return boolean false it all operation performed correctly else true;
	 */
	function authenticateRegisterUser(){
		
		include_once('constantVariables.php');
		
		$this->validateUser();
		$this->sanitizeCredentials();
		
		if( $this->statusValidation ){
			$this->operationStatus = RESULT1;
			return true;
		}		
		
		if($this->operationCode == 3){
			$this->operation = "DELETE";
		    $statusDelete = $this->deleteUserData();
		}else if($this->operationCode == 2){
			$this->operation = "UPDATE";
			$statusUpdate = $this->updateUserData();
		}else if($this->operationCode == 1){
			$this->operation = "INSERT";
			$statusInsert = $this->insertUserData();
		}
		
		return false;
	}
	
	/**
	 * Perform Delete SQL operation
	 *  
	 * @return boolean false it all operation performed correctly else true;
	 */
	function deleteUserData(){
		
		include_once('constantVariables.php');
		/** Establising connection with MYsqli database **/
		$db = include('config.php');
		$mysqli = new mysqli($db['host'], $db['user'], "", $db['database']);
	
		/** Preventing MYsqli injection **/
		$stmt = $mysqli->prepare(" Delete from employeetable where Email=?");
		$stmt->bind_param("s", $this->keyId);
		
		if($stmt->execute()){
			$this->responseCode = 200;
			$this->responseStatus = RESULT2;
			
			$stmt->close();
			$mysqli->close();
			
			return false;
		}
		$this->error = SQL_DELETE_ERROR1;
		return true;
		
	}
	
	/**
	 * Perform Insert SQL operation
	 *  
	 * @return boolean false it all operation performed correctly else true;
	 */
	function insertUserData(){
		
		include_once('constantVariables.php');
		/** Establising connection with MYsqli database **/
		$db = include('config.php');
		$mysqli = new mysqli($db['host'], $db['user'], "", $db['database']);
	
		/** Preventing MYsqli injection **/
		$stmt = $mysqli->prepare("insert into employeetable 
			   (firstname, lastname, Email, mobile, address, department, password)
		     	values (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssssss", $this->firstName, $this->lastName,$this->email,
        	   $this->mobile, $this->address, $this->department, $this->password);
		
		if($stmt->execute()){
			$this->responseCode = 200;
			$this->responseStatus = RESULT2;
			
			$stmt->close();
			$mysqli->close();
			
			return false;
		}
		$this->error = SQL_INSERT_ERROR1;
		return true;
	}
	
	/**
	 * Perform Update SQL operation
	 *  
	 * @return boolean false it all operation performed correctly else true;
	 */
	function updateUserData(){
		
		include_once('constantVariables.php');
		/** Establising connection with MYsqli database **/
		$db = include('config.php');
		$mysqli = new mysqli($db['host'], $db['user'], "", $db['database']);
		
		/** Preventing MYsqli injection **/
		$stmt = $mysqli->prepare("update employeetable set firstname=?,
			lastname=?, Email=?, mobile=?,
			address=?, department=? where Email =? ");
		$stmt->bind_param("sssssss",$this->firstName, $this->lastName,
		$this->email, $this->mobile, $this->address, $this->department,
		$this->keyId);
		
		if($stmt->execute()){
			$this->responseCode = 200;
			$this->responseStatus = RESULT2;
			
			$stmt->close();
			$mysqli->close();
			
			return false;
		}
		$this->error = SQL_UPDATE_ERROR1;
		return true;
	}
	
	/**
	 * Show the User's Registration details echo the result back to client
	 */
	function getUserRegistionResponse()
	{
		$responseObj = new StdClass;
		$responseObj->code = $this->responseCode;
		$responseObj->result = $this->responseStatus;
		$responseObj->operation = $this->operation;
		$responseObj->error = $this->error;
		$responseObj->firstName = $this->firstName ;
		$responseObj->lastName = $this->lastName;
		$responseObj->mobile = $this->mobile;
		$responseObj->address = $this->address;
		$responseObj->department = $this->department;
		$responseObj->password = $this->password;
		
		$responseServerJSON = json_encode($responseObj);
		echo $responseServerJSON;
	}
	
}


/** Parsing client's registration data **/
$formDataJsonArray= json_decode($_POST['data'],true);
	
$registerUser = new RegisterUserData( $formDataJsonArray['operation'],
				$formDataJsonArray['keyValue'], $formDataJsonArray['firstName'],
				$formDataJsonArray['lastName'], $formDataJsonArray['email'],
				$formDataJsonArray['mobile'], $formDataJsonArray['address'],
				$formDataJsonArray['department'], $formDataJsonArray['password']
				);
	
$registerUser->statusRegistration = $registerUser->authenticateRegisterUser();
$registerUser->getUserRegistionResponse();
	
?>