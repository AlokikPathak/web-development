<?php
/**
 * File Name : authenticateHome.php
 * File Path : C:\xampp\htdocs\Project\Repository\
 * Description : Validate and authenticate user's credentials using database
 * Created : 26/07/2018
 * @author : Alokik Pathak
 */
 
/** Starts a session **/
session_start();

/**
 * Stores, validates and authenticate user credentials with the database
 *
 * @author Alokik Pathak
 */
class AuthenticateUserData
{
	private $email;
	private $password;

	private $statusEmail = true;
	private $statusPassword = true;
	public $statusUserLoggedIn = false;
	
	private $emailError = "";
	private $passwordError = "";
	private $authenticationError = "";
	private $error = "";
	
	private $code = 403;
	private $operationStatus = "";
	private $firstName = "";
	private $lastName = "";
	private $mobile = "";
	private $address = "";
	private $department = "";

	
	/**
	 * Initialize class variables with the parameters passed to constructor
	 *
	 * @param string $email 
	 * @param string $password
	 */
	public function AuthenticateUserData($email, $password)
	{
		$this->email = $email;
		$this->password = $password;	
	}
	
	/**
	 * Validates Email of the user
	 * 
	 * @return boolean true if email is invalid else returns false
	 */
	public function validateEmail()
	{
		include_once('constantVariables.php');
		if( $this->email === "" ){
			$this->emailError= EMAIL_ERROR1;
			return true;
		}else if( !preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $this->email )){
			$this->emailError = EMAIL_ERROR2;
			return true;
		}
		return false;
	}
	
	/**
	 * Validates password of the user
	 *
	 * @return boolean true if email is invalid else returns false
	 */
	public function validatePassword()
	{
		include_once('constantVariables.php');
		if( $this->password === "" ){
			$this->passwordError = PASSWORD_ERROR1; 
			return true;
		}
		else if(strlen($this->password)<8){
			$this->passwordError = PASSWORD_ERROR2; 
			return true;
		}
		return false;
	}
	
	/**
	 * Validates email & password of the user
	 * 
	 */
	public function validateUser()
	{
		$this->statusEmail = $this->validateEmail();
		$this->statusPassword = $this->validatePassword();
	}
	
	/**
	 * Clean(remove tags) email & password of the user
	 * 
	 */
	public function sanitizeUserData()
	{
		$this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
		$this->password = filter_var($this->password, FILTER_SANITIZE_STRING);
	}
	
	/**
	 * Authenticate user with the database details
	 *
	 * @return boolean false for failure and true for success
	 */
	public function authenticateUser()
	{	
		include_once('constantVariables.php');
		
		if( $this->statusEmail || $this->statusPassword){
			$this->code = 403;
			$this->operationStatus = RESULT1;
			return false;
		}
		
		/** Establising connection with MYsqli database **/
		$db = include('config.php');
		$mysqli = new mysqli($db['host'], $db['user'], "", $db['database']);
	
		/** Preventing MYsqli injection **/
		$stmt = $mysqli->prepare(" Select * from employeetable where Email=?");
		$stmt->bind_param("s", $this->email);
		$stmt->execute();
		$result = $stmt->get_result();
			
		if(!$result){
			$this->code = 403;
			$this->operationStatus = RESULT1;
			$this->authenticationError = SQL_ERROR1;	
			return false;
		}
		
		$row = mysqli_fetch_row($result);
		$storePassword = $row[7];
		
		/** Comparing the client's password with Database password **/
		$comparePasswords = strcmp($storePassword, $this->password);
		
		if($comparePasswords!=0){
			$this->code = 403;
			$this->operationStatus= RESULT1;
			$this->error = PASSWORD_ERROR3;
			return false;
		}
		
		$this->code = 200;
		$this->operationStatus = RESULT2;
		$this->firstName = $row[1];
		$this->lastName = $row[2];
		$this->mobile = $row[4];
		$this->address = $row[5];
		$this->department = $row[6];
		
		
		$stmt->close();
		$mysqli->close();
		return true;
		
	}
	
	/**
	 * Show the User's Authentication details echo the result back to client
	 */
	function getUserAuthenticationResponse()
	{
		$responseObj = new StdClass;
		$responseObj->code = $this->code;
		$responseObj->result = $this->operationStatus;
		$responseObj->error = $this->error;
		$responseObj->firstName = $this->firstName ;
		$responseObj->lastName = $this->lastName;
		$responseObj->email = $this->email;
		$responseObj->mobile = $this->mobile;
		$responseObj->address = $this->address;
		$responseObj->department = $this->department;
		
		$responseServerJSON = json_encode($responseObj);
		
		header('application/json');
		echo $responseServerJSON;
	}

}


/** Decoding and storing client data **/
$formDataJsonArray= json_decode($_POST['data'],true);

/** Preventing CSRF attacks **/
include_once('constantVariables.php');

$arrayCSRF = array("token"=>$formDataJsonArray['token'],
			 "host"=>$_SERVER['HTTP_REFERER'],
			 "sessionToken"=>$_SESSION['token'],
			 "legalHost"=>LEGAL_HOST1
			 );

			 
if( strcmp($arrayCSRF['token'],$arrayCSRF['sessionToken']) != 0 || strcmp($arrayCSRF['host'],$arrayCSRF['legalHost']) != 0){
	
	/** Found UNAUTHORISED **/
	$responseObj = new StdClass;
	$responseObj->code = 403;
	$responseObj->result = RESULT1;
	$responseObj->error = CSRF_ERROR;
	
	$responseServerJSON = json_encode($responseObj);
	
	header('application/json');
	echo $responseServerJSON;
	exit;
}

/** Creating Class instance **/		
$userLoggedIn = new AuthenticateUserData($formDataJsonArray['Email'],
				$formDataJsonArray['Password']);

/** Validating User data **/
$userLoggedIn->validateUser();
$userLoggedIn->sanitizeUserData();

$userLoggedIn->statusUserLoggedIn = $userLoggedIn->authenticateUser();
$userLoggedIn->getUserAuthenticationResponse();

?>