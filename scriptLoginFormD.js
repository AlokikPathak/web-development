
/**
 * Filename  - scriptFormDa.php
 * File path - C:\xampp\htdocs\Project\Repository\
 * Description : Validates Login credentials and sends it to server
 * @author  : Alokik Pathak
 * Created date : 18/07/2018
 */

/** Error flag for Email and Password Fields **/
var errorEmail =true;
var errorPassword = true;

/** Storing id's of various form element **/
var idEmail = $("#email");
var idPassword= $("#password");
var idSubmit = $("#login");
var idEmailError = $("#email_error_message");
var idPasswordError = $("#password_error_message");
var idResponse = $("#responseHead");

/**
 * Alternate of $(document).ready(function(){});
 * Executed after all DOM elements are loaded and Document is ready
 */
$(function(){
	
	/** Hides the Error Messages when the form is ready **/
	idEmailError.hide();
	idPasswordError.hide();
	
	/** Changes background-color ro yellow of input field when it is in focus **/
	$("input[type=text], input[type=password]").focus(function(){
		$(this).css("background-color","#ffffcc");
	});
	
	/** Changes background-color to white of input field when it is blur **/
	$("input[type=text], input[type=password] ").blur(function(){
		$(this).css("background-color","#ffffff")
	});
	
	/** Changes background-color to white of input field when it is keydown **/
	$("input[type=text], input[type=password]").keydown(function(){
		$(this).css("background-color","#ffffff")
	});
	
	/** Changes background-color to yellow of input field when it is keyup **/
	$("input[type=text], input[type=password] ").keyup(function(){
		$(this).css("background-color","#ffffcc")
	});
	
	/** Assign checkEmail() method to email input field for keyup event **/
	$("#email").keyup(function(){
		checkEmail();
	});
	
	/** Assign checkPassword() to password input field for keyup event **/
	$("#password").keyup(function(){
		checkPassword();
	});
	
	
	/**
	 * Validates Email data and check for duplicates.
   	 * Set errorEmail value as false for valid data else true.
	 */
	function checkEmail()
	{
		var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var email = $("#email").val();
		
		if(pattern.test(email) && email !== '') {
			
			errorEmail = false;
			idEmailError.hide();
		}else{
		
			idEmailError.html("Invalid email");
			errorEmail = true;
			idEmailError.show();
		}
	}
	
	/**
	 * Validates Password field.
   	 * Set errorPassword value as false for valid data else true.
	 */
	function checkPassword()
	{
	
		if(idPassword.val().length < 8 ){
			errorPassword = true;
			idPasswordError.html("Password must be >=8 chars");
			idPasswordError.show();
		}else{
			errorPassword = false;
			idPasswordError.hide();
		}
	}

	
	
});

   /** 
    * Authenticate the user's login credentials form the server side database 
	*
	* @param string email contains the email data of user
	* @parem string pswrd contains the pswrd data of user
    */
	function authenticateUserCredentials(email, pswrd)
	{
	
		var formDataObj = {'Email':email, 'Password':pswrd};
		var formDataObjJSON = JSON.stringify(formDataObj);
	
		$.ajax({
		
			type: "POST",
			url: "authLoginFormDOOPs.php",
			data: 'data='+formDataObjJSON,
			success: function(data){
				//alert("Server Response: "+data);
				var responseObj = JSON.parse(data);
			    var  responseCode = responseObj.code;
				showServerResponse(responseCode, responseObj.firstName, responseObj.lastName);
			}
		});
	
	}
	
	function showServerResponse(responseCode, firstName, lastName){
		if(responseCode == 200){
			idResponse.html("Welcome "+firstName+" "+lastName+" !");
			idResponse.css("color","Dodgerblue");
			idEmail.val("");
			idPassword.val("");
		}else{
			idResponse.html("Invalid credentials...!");
			idResponse.css("color","red");
		}
	}

    /**
	 * It fetches & validates login and password field data,
	   then auhthenticate them form the server database
	 *	
     */
	function myFunctionLogin()
	{
		var email = idEmail.val();
		var pswrd = idPassword.val();
		
		var hashKeyPswrd = CryptoJS.MD5(pswrd);
		hashKeyPswrd = hashKeyPswrd.toString();
	
		if( errorEmail == true || errorPassword == true){
			alert("Please fill the form correctly first!");
		}else{
			authenticateUserCredentials(email, hashKeyPswrd);
		}
	}
   