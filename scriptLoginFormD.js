
/** Error flag for Email and Password Fields **/
var errorEmail =true;
var errorPassword = true;

/** Storing id's of various form element **/
var idEmail = $("#email");
var idPassword= $("#password");
var idSubmit = $("#login");
var idEmailError = $("#email_error_message");
var idPasswordError = $("#password_error_message");
	

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
	
	/** Assign checkPassword() method to password input field for keyup event**/
	$("#password").keyup(function(){
		checkPassword();
	});
	
	/**
	 * checkEmail() method checks wheather the client entered data is valid
	 * It is invoked by keyup() event
	 * Returns false and hide the error message for valid email
	 * Returns true and show the error message for invalid email
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
	 * checkPassword() method checks wheather the entered password is valid
	 * It is invoked by keyup() event
	 * Returns false and hide the error message for valid password
	 * Returns true and show the error message for invalid password
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
    * This methods takes user's email and password as parameters
    * It makes a JSON object of those arguments and converts to string
    * It makes the AJAX call to "authLoginFormA.php" file and send the 
      JSON string
    * It then alerts the server response and set the paragraph test with it
    */
	function authenticateUserCredentials(email, pswrd)
	{
	
		var formDataObj = {'Email':email, 'Password':pswrd};
		var formDataObjJSON = JSON.stringify(formDataObj);
	
		$.ajax({
		
			type: "POST",
			url: "authLoginFormA.php",
			data: 'data='+formDataObjJSON,
			success: function(data){
				alert("Server response: "+data);
				$("#paragraph").html(data);
			}
		});
	
	}

    /**
	 * This function is invoked when Login button is clicked
     * It checks wheather the client data is valid or not if it is valid;
     * The client data form Login Form are
       passed as arguments to authenticateUserCredentials() method
     */
	function myFunctionLogin()
	{
	
		var email = idEmail.val();
		var pswrd = idPassword.val();
	
		if( errorEmail == true || errorPassword == true){
			alert("Please fill the form correctly first!");
		}else{
		
			authenticateUserCredentials(email, pswrd);
		}
	}
   