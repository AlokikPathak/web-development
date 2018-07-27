<?php
/**
 * File Name : authLoginFormDOOPs.php
 * File Path : C:\xampp\htdocs\Project\Repository\
 * Description : Validate and register user's data in database
 * Created : 26/07/2018
 * @author : Alokik Pathak
 */
 

class RegisterUser{

	
	public $email;
	public $password;

	public $statusEmail = true;
	public $statusPassword = true;;
	
	public $emailError = "";
	public $passwordError = "";
	public $authenticationError = "";
	
	public $code = "";
	public $operationStatus = "";
	public $firstName = "";
	public $lastName = "";
	
	/**
	 * Initialize class variables with the parameters passed to constructor
	 *
	 * @param string $email 
	 * @param string $password
	 */
	public function RegisterUser($email, $password){
		
		$this->email = $email;
		$this->password = $password;
		
	}
	
	/**
	 * Validates Email of the user
	 */
	public function validateEmail(){
		if( $email === "" ){
			$emailError= "Email must not be empty";
			$statusEmail = true;
		}else if( !preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $email )){
			$emailError = "Email is invalid";
			$statusEmail = true;
		}
		$statusEmail = false;
	}
	
	/**
	 * Validates password of the user
	 */
	public function validatePassword(){
		if( $password === "" ){
			$passwordError = "Password must not be empty"; 
			$statusPassword = true;
		}
		else if(strlen($dataPassword)<8){
			$passwordError = "Password should be min. 8 chars"; 
			$statusPassword = true;
		}
		$statusPassword = false;
	}
	
	/**
	 * Validates email & password of the user
	 * 
	 */
	public function validateUser(){
		validateEmail();
		validatePassword();
	}
	
	/**
	 * Clean(remove tags) email & password of the user
	 * 
	 */
	public function sanitizeUserData(){
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$password = filter_var($password, FILTER_SANITIZE_STRING);
	}
	
	
	public function authenticateUser(){
		
		if( $statusEmail || $statusPassword){
			$this->code = 403;
			$this->operationStatus = "FAILURE";
			return false;
		}
		
		/** Establising connection with MYsqli database **/
		$db = include('config.php');
		$mysqli = new mysqli($db['host'], $db['user'], "", $db['database']);
	
		/** Preventing MYsqli injection **/
		$stmt = $mysqli->prepare(" Select * from employeetable where Email = ? ");
		$stmt->bind_param("s", $dataEmail);
		$stmt->execute();
		$result = $stmt->get_result();
			
		if(!$result){
			$authenticationError = "Query doesn't gave any result";	
			return false;
		}
		
		$row = mysqli_fetch_row($result);
		$storePassword = $row[7];
		
		/** Comparing the client's password with Database password **/
		$comparePasswords = strcmp($storePassword, $password);
		
		if($comparePasswords!=0){
			$this->code = 403;
			$this->operationStatus= "FAILURE"
			return true;
		}
		
		$this->firstName = $row[1];
		$this->lastName = $row[2];
		
		$stmt->close();
		$mysqli->close();
		
	}
}

?>