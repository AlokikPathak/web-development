
/** Error flag for Email and Password Fields **/
var errorEmail =true;
var errorPassword = true;

/** Storing id's of various form element **/
var idEmail = $("#email");
var idPassword= $("#password");
var idSubmit = $("#login");
var idEmailError = $("#email_error_message");
var idPasswordError = $("#password_error_message");
/** Base64 Object **/
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

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
		var encPswrd = Base64.encode(pswrd);
	
		if( errorEmail == true || errorPassword == true){
			alert("Please fill the form correctly first!");
		}else{
			
			
			authenticateUserCredentials(email, encPswrd);
		}
	}
   