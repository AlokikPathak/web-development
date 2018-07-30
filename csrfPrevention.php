<?php
/**
 * File Name : csrfPrevention.php
 * File Path : C:\xampp\htdocs\Project\Repository\
 * Description : Used for preventing Cross-site-request-forgery attacks
 * Created : 30/07/2018
 * @author : Alokik Pathak
 */

 
/**
 * Class containes methods used for preventing CSRF attacks
 */
class csrf{
	
	/**
	 * Retrieves the Token ID from a user's session, if not available generates one
	 */
	public function get_token_id()
	{
		if(isset($_SESSION['token_id'])){
			return $_SESSION['token_id'];
		}else{	
			$token_id = $this->random(10);
			$_SESSION['token_id'] = $token_id;
			return $token_id;
		}
	}
	
	/**
	 * Retrieves token value, if not available generates one
	 */
	public function get_token()
	{
		if(isset($_SESSION['token_value'])){
			return $_SESSION['token_value'];
		}else{
			$token = hash('sha256', $this->random(500));
			$_SESSION['token_value'] = $token ;
			return $token;
		}
	}
		
	/**
	 * Determines wheather token ID and token value are both valid.
	 */	
	public function check_valid($method)
	{
		if($method=='post' || $method=="get"){
			$post = $_POST;
			$get = $_GET;
			
			if(isset(${$method}[ $this->get_token_id()]) && (${$method}[$this->get_token_id()] == $this->get_token())){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	/**
	 * This generates random names for the form fields.
	 */
	 public function form_names( $names, $regenerate){
		 
		 $values = array();
		 foreach ($names as $n){
			 if($regenerate == true){
				 unset($_SESSION[$n]);
			 }
			 $s = isset($_SESSION[$n]) ? $_SESSION[$n] : $this->random(10);
			 $_SESSION[$n] = $s;
			 $values[$n] = $s;
		 }
		 return $values;
	 }
	
	
	
}

?>