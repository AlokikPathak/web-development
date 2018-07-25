/**
 * errorFName, errorLName, errorEmail, errorMobile, errorAddress 
 * are the flags which are set as true when there is error in their respective
   input.
 * rowUpdateNo stores the value of row which will be updated.
 * update is used as flag. It is set as true when user request to update 
   a record.
 * counter stores the index of row in which the new user details will be added 
   to table.
*/
var errorFName = true;
var errorLName = false;
var errorEmail = true;
var errorMobile = true;
var errorAddress = false;
var errorPassword = true;
var errorCnfPassword = true;

var rowUpdateNo =0;
var update=false;
var counter=1;
var key="";
var responseCode =200;

/**
 * Assigning ids of form Elements to variable which are accessed many time of 
   Code optimization
 */

var idFirstName = $("#fname");
var idLastName = $("#lname");
var idEmail = $("#email");
var idMobile = $("#mobile");
var idAddress = $("#address");
var idDepartment = $("#department");
var idHeading = $("#Heading");
var idSubmit = $("#subUpd");
var idTable = $("#empTab");
var idPassword = $("#password");
var idCnfPassword = $("#cnfpassword");

var idFnameError = $("#fname_error_message");
var idLnameError = $("#lname_error_message");
var idMobileError = $("#mobile_error_message");
var idAddressError = $("#address_error_message");
var idEmailError = $("#email_error_message");
var idPasswordError = $("#password_error_message");
var idCnfPasswordError = $("#cnfpassword_error_message");

/** Base64 Object **/
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

/**
 * Alternate of $(document).ready(function(){});
 * Executed after all DOM elements are loaded and Document is ready
 */
$(function(){

	hideErrorMessage();
	
	$("input[type=text], input[type=password]").focus(function(){
		$(this).css("background-color","#ffffcc");
	});
	
	$("input[type=text], input[type=password] ").blur(function(){
		$(this).css("background-color","#ffffff")
	});
	
	$("input[type=text], input[type=password]").keydown(function(){
		$(this).css("background-color","#ffffff")
	});
	
	$("input[type=text], input[type=password] ").keyup(function(){
		$(this).css("background-color","#ffffcc")
	});
	
	$("#fname").keyup(function(){
		checkFName();
	});

	
	$("#lname").keyup(function(){
		checkLName();
	});
	
	
	$("#email").keyup(function(){
		checkEmail();
	});
	
	$("#mobile").keyup(function(){
		checkMobile();
	});
	
	$('#password').keyup(function(){
		checkPassword();
	});
	
	$('#cnfpassword').keyup(function(){
		checkCnfPassword();
	});
	
	/**
	* checkFName() is method which validates the First name entered by the user.
	* It is invoked by keyup() event when user is entering the details.
	* set the errorLName flag as true when invalid and false when it is valid.
	* Returns "true" if the entered name is invalid.
	* Returns "false" if entered name is valid.
	*/
	function checkFName() {
		
		var pattern = /^[a-zA-Z]*$/;
		var fname = $("#fname").val();
		if (pattern.test(fname) && fname !== '') {
			idFnameError.hide();
			errorFName = false; 
			idFirstName.css("color","Dodgerblue");
		}
		else {
			idFnameError.html("Should contain only alphabets");
			idFnameError.show();
			errorFName = true; 
			idFirstName.css("color","tomato");

		}
	}
	
	/**
	* checkLName() is method which validates the last name entered by the user.
	* It is invoked by keyup() event when user is entering the details.
	* set the errorLName flag as true when invalid and false when it is valid.
	* returns "true" if the entered name is invalid.
	* returns "false" if entered name is valid.
	*/
	function checkLName() {
		
		var pattern = /^[a-zA-Z]*$/;
		var lname = $("#lname").val();
		
		if(lname == ""){
			idLnameError.hide();
			errorLName = false; 
			idLastName.css("color","Dodgerblue");
		}
		else if (pattern.test(lname)) {
			idLnameError.hide();
			errorLName = false; 
			idLastName.css("color","Dodgerblue");
			
		}
		else {
			idLnameError.html("Should contain only alphabets");
			idLnameError.show();
			errorLName = true; 
			idLastName.css("color","tomato");

		}
	}
	
	/**
	* checkEmail() is method which validates the email entered by the user.
	* It is invoked by keyup() event when user is entering the details.
	* It checks first wheather the entered email is valid.
	* If email is found to be valid, it invokes "checkDuplicateEmail(email)" method.
	* If the email is valid and not having any duplicate;
		* "errorEmail" is set as "false" else it is set as "true".
	* returns "true" if the entered email is invalid & not having any duplicate.
	* returns "false" if entered email is valid.
	*/
	function checkEmail() {
		
		var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var email = $("#email").val();
		if(pattern.test(email) && email !== '') {
			
			var emailDuplicate = checkDuplicateEmail(email);
			
			if(emailDuplicate == false ){
				idEmailError.hide();
				errorEmail = false;
				idEmail.css("color","Dodgerblue");
			}
			else{
				
				idEmailError.html("Email already exist! Try something else");
				idEmailError.show();
				errorEmail = true;
				idEmail.css("color","tomato");
				
			}
		}
		else {	
			idEmailError.html("Invalid Email (ex. xyz@gmail.com)");
			idEmailError.show();
			errorEmail = true;
			idEmail.css("color","tomato");
		}
	}
	

	
   /** 
	* checkMobile() is method which validates the mobile no. entered by the user.
	* It is invoked by keyup() event when user is entering the details.
	* It checks first wheather the entered mobile no. is valid.
	* If mobile is found to be valid, it invokes "checkDuplicateMobile(mob)" method.
	* If the mobile no. is valid and not having any duplicate;
		A. "errorMobile" is set as "false" else it is set as "true".
	* returns "true" if the entered mobile is invalid & not having any duplicate.
	* returns "false" if entered mobile is valid.
	*/
	function checkMobile(){
		var mob = $("#mobile").val();
		var pattern = /^(\+\d{1,3}[- ]?)?\d{10}$/;
		if( pattern.test(mob) ){ 
			var mobileDuplicate = checkDuplicateMobile(mob);
			
			if(mobileDuplicate == false ){
				idMobileError.hide();
				errorMobile = false;
				idMobile.css("color","Dodgerblue");
			}
			else{
				
				idMobileError.html("Mob. No. already exist! Try something else");
				idMobileError.show();
				errorMobile = true;
				idMobile.css("color","tomato");
				
			}
		}
		else{
			idMobileError.html("Mobile must contain 10 digit numeric value");
			idMobileError.show();
			errorMobile = true;
			idMobile.css("color","tomato");
		}
	}
	
	/**
	 * checkPassword() methods check wheather the password length is >= 8.
	 */
	function checkPassword(){
		
		if(idPassword.val() == "" || idPassword.val().length < 8){
			idPasswordError.html("Password must contain 8 chars");
			idPasswordError.show();
			errorPassword = true;
		}
		else{
			idPasswordError.hide();
			errorPassword = false;
		}
	}
	
	/**
	 * checkCnfPassword() method check wheather it is same as password.
	 */
	function checkCnfPassword(){
		if(errorPassword == true ){
			idCnfPasswordError.html("First submit the password correctly");
			idCnfPasswordError.show();
			errorCnfPassword = true;
		}
		else if( idCnfPassword.val() != idPassword.val() ){
			idCnfPasswordError.html("It should be same as Password");
			idCnfPasswordError.show();
			errorCnfPassword = true;
		}
		else{
			idCnfPasswordError.hide();
			errorCnfPassword = false;
		}
	}
	
	
});



/** 
 * It invoked by updateRow() method.
 * Seven arguments are passed which are fname, lname, email, mobile, address &
   department while invocation.
 * It fills out the text input fields such First Name, Last Name, Email, Mobile 
   etc. of the respective row.
 * It returns nothing specifically.
 */
function autoFill( rowNo, fName, lName, email, mobile, address, department, pswrd ) {
	event.preventDefault();
	
	var dcrPswrd = Base64.decode(pswrd);
	
	idFirstName.val(fName);
	idLastName.val(lName);
	idEmail.val(email);
	idMobile.val(mobile);
	idAddress.val(address);
	idPassword.val(dcrPswrd);
	idCnfPassword.val(dcrPswrd);
	var table = document.getElementById("empTab").rows;
	var y = table[rowNo].cells; 
	idDepartment.val(y[6].innerHTML);
}


/**
 * It updates the table after user make changes in existing details entered earlier.
 * It is invoked by "submit/update" button is clicked.
 * Seven arguments are passed to it which needs to be updated on the table in specific
   row which is 1st coloumn.
 * It internally invoke the resetDet() method after updating the table and clears the 
   input fields.
 * Runs the phpScriptFunction to update the Database
 * Invode runPHPScript() with operationCode=2 method to update the database accordingly.
 */
function updateTable(row, fName, lName, email, mobile, address, dept, pswrd){
	
	var encPswrd = Base64.encode(pswrd);
	
	event.preventDefault();
	
	runPHPScript(2, fName, lName, email, mobile, address, dept, encPswrd);
	
	if( responseCode == 200 ){
	
	    var x = document.getElementById("empTab").rows[row].cells;
	    x[0].innerHTML = row ;
	    x[1].innerHTML = fName;
	    x[2].innerHTML = lName;
	    x[3].innerHTML = email ;
	    x[4].innerHTML = mobile;
	    x[5].innerHTML = address ;
	    x[6].innerHTML = dept;
	    x[7].innerHTML = encPswrd;
		resetDet();
     	alert("Table updated...!");
	}else{
		alert("Could not update the table Server Response error ");
	}
	
}


/**
 * updateRow() method is invoked when user clicks on the Update button 
   assign to each row.
 * It sets the update flag as true & assign the global var of row i.e., 
   rowUpdateNo to respective value.
 * It then invoke autofill() method which fills out the Form.
 * It then sets the errorFName, errorLName, errorEmail, errorMobile,
   errorAddress flag as false.
 */
function updateRow(indexThis)
{	
	
	update = true;	
	var rowNo = indexThis.parentNode.parentNode.rowIndex ;
	
	rowUpdateNo = rowNo;
	var x = document.getElementById("empTab").rows[rowNo].cells;
	autoFill(
		rowNo, 
		x[1].innerHTML, 
		x[2].innerHTML, 
		x[3].innerHTML, 
		x[4].innerHTML, 
		x[5].innerHTML, 
		x[6].innerHTML, 
		x[7].innerHTML 
	);
	
	errorFName = errorEmail = errorMobile= errorCnfPassword = false;
	errorLName = errorAddress = errorPassword = false;
	
	idHeading.html("Update Employee Details");
	idSubmit.val("UPDATE");
	idSubmit.css("background-color","Dodgerblue");
	key=x[3].innerHTML;

	
}


/**
 * checkDuplicateEmail() method is invoked by checkEmail() method.
 * It checks wheather the entered email by user already exist or duplicate or not.
 * It first check out the update flag if yes it ignores that row.
 * It returns "true" if it finds duplicate email else it returns "false".
 */

function checkDuplicateEmail( emailInput)
{
	if(update == false){
		for(var i=1; i<counter; i++){
			var x = document.getElementById("empTab").rows[i].cells;

			if( emailInput == x[3].innerHTML){
				return true;
			}
		}
	}else{
		
		for(var i=1; i<counter; i++){
			var x = document.getElementById("empTab").rows[i].cells;

			if( emailInput == x[3].innerHTML && i!=rowUpdateNo){
				return true;
			}
		}	
	}
	return false;
	
	
}


/**
 * checkDuplicateMobile() method is invoked by checkMobile() method.
 * It checks wheather the entered mobile by user already exist or duplicate or not.
 * It first check out the update flag if yes it ignores that row.
 * It returns "true" if it finds duplicate mobile else it returns "false".
 */
function checkDuplicateMobile( mobileInput )
{	
	if(update == false ){
		for(var i=1; i<counter; i++){
			var x = document.getElementById("empTab").rows[i].cells;

			if( mobileInput == x[4].innerHTML){
				return true;
			}
		}
	}else{
		for(var i=1; i<counter; i++){
			var x = document.getElementById("empTab").rows[i].cells;
			if( mobileInput == x[4].innerHTML && i!=rowUpdateNo){
				return true;
			}
		}	
	}
	return false;
	
}


/**
 * This method is invoked by deleteRow() method.
 * It updates the Sl.Nos. of each row present after the deleted row.
 */
function updateAfterdel(rowNo){
	for(var i=rowNo; i<counter; i++){
		var x = document.getElementById("empTab").rows[i].cells;
		x[0].innerHTML = i;
	}
}


/**
 * deleteRow() method is invoked when the delete button assigned to row is cliked.
 * It invoke resetDet() method.
 * Deletes the specific row of the clicked delete button.
 * It decrements the counter value and invokes the updateAfterdel() method.
 * Set the unique key value as Email of selected row.
 * Invoke runPHPScript() with operationCode=3 to delete from the Database accordingly.
 */
function deleteRow(index)
{
	var rowNum = index.parentNode.parentNode.rowIndex ;
	var x = document.getElementById("empTab").rows[rowNum].cells;
	key = x[3].innerHTML;
	
	
	event.preventDefault();
	runPHPScript(3,'','','','','','','');
		
	if(responseCode == 200){
		
		resetDet();
		
		alert("Do you want to delete row: "+ rowNum);	
		document.getElementById("empTab").deleteRow( rowNum );
		counter--;
		
		updateAfterdel( rowNum);
		alert("Row: "+ rowNum +" deleted..!");
		resetDet();
		
	}else{
		alert("Could not delete Server Response error");
	}
}


/**
 * addToTable() method is used to add new user details into the table.
 * It is invoked when user clicks the submit/update button and 
   when update flag is set as false.
 * It is invoked after the details are validated.
 * It adds the input details to table and increment the counter.
 */
function addToTable(fName, lName, email, mobile, address, dept, pswrd)
{
 
	var encPswrd = Base64.encode(pswrd);
	
  /** Invoke the Function to store the details in MySQL database **/
  runPHPScript(1, fName, lName, email, mobile, address, dept, encPswrd);

  
  if( responseCode == 200 ){
	  
	var table = document.getElementById("empTab");
	var row = table.insertRow( counter );
		
	row.insertCell(0).innerHTML = counter;
	row.insertCell(1).innerHTML = fName;
	row.insertCell(2).innerHTML = lName;
	row.insertCell(3).innerHTML = email;
	row.insertCell(4).innerHTML = mobile;
	row.insertCell(5).innerHTML = address;
	row.insertCell(6).innerHTML = dept;
	row.insertCell(7).innerHTML = encPswrd;
	
	var btnUpdate = document.createElement("button");
	btnUpdate.setAttribute("name","buttonUpdate");
	btnUpdate.setAttribute("id","buttonUpdate");
	btnUpdate.setAttribute("value","UPDATE");
	btnUpdate.setAttribute("class","newButtonUpdate");
	btnUpdate.onclick= function()
	{
	    event.preventDefault();
		updateRow(this);
	}
	row.insertCell(8).appendChild(btnUpdate);
	
	var btnDel = document.createElement("button");
	btnDel.setAttribute("name","buttonDel");
	btnDel.setAttribute("value","DELETE");
	btnDel.setAttribute("class","newButtonDelete");
	btnDel.onclick= function()
	{
		deleteRow(this);
		event.preventDefault();
	}
	row.insertCell(9).appendChild(btnDel);
	counter++;
	resetDet();
	alert("Data inserted successfully into table");
	
  }else{
	  alert("Could not add to table Server Response Error: ");
  }  
}

/**
 * Invoked by resetDel() method.
 * Hides all the error messages if they are in form.
 */
function hideErrorMessage()
{	
		idFnameError.hide();
		idLnameError.hide();
		idEmailError.hide();
		idMobileError.hide();
		idAddressError.hide();
		idPasswordError.hide();
		idCnfPasswordError.hide();
}


/**
 * It checks the status of validation flags assign to input fields.
 * If the all the flag are false i.e., entered details are correct returns true.
 * If any of the flag status is false it returns "false"
 
 
 */
function validateFormJQuery()
{
	
	if( errorFName == false && errorLName == false && errorEmail == false && 
	    errorMobile== false && errorAddress == false && errorPassword == false
		&& errorCnfPassword == false){
		return true;
	}else{
		return false;
	}
}


/**
 * This method is used to reset or clear the registration form.
 * It sets the update flag as false and clear the input fields.
 * It also sets the validation flags assign to each input as default.
 * It also invokes hideErrorMessage() method which hides all the error messages.
 */
function resetDet()
{
	update = false;
	
	idFirstName.val("");
	idLastName.val("");
	idEmail.val("");
	idMobile.val("");
	idAddress.val("");
	idDepartment.val("Software Engineer");
	idPassword.val("");
	idCnfPassword.val("");
	
	errorFName = errorEmail = errorMobile = errorPassword = errorCnfPassword= true;
	errorAddress = errorLName = false;
	
	hideErrorMessage();
	
	idSubmit.val("SUBMIT");
	idSubmit.css("background-color","#4CAF50");	
	idHeading.html("Registration Form");
	
}

/**
 * Pass operation code value through function which is calling it
 * When update is clicked store it email/mobile no. at the beginning
 * A another variable to store the email of the User 
 * That email will act as primary key for update and delete operation
 * operationCode 3->Delete, 2->Update, 1->Inserts
*/

function runPHPScript(operationCode, fName, lName, email, mobile, address, dept, pswrd)
{
		var formDataObj= {'operation':operationCode, 'keyValue':key,
		'fname':fName, 'lname':lName, 'email':email, 'mobile':mobile,
		'address':address,'department':dept, 'password':pswrd};
		
		var formDataJSON = JSON.stringify(formDataObj);
		
		var responseObj;
		$.ajax
		({
			type: "POST",
			url: "authRegistrationFormD.php",
			data: 'data='+formDataJSON,
			success: function(data)
			{
				alert("Server Response: "+data);
				responseObj = JSON.parse(data);
				responseCode = responseObj.code;
			}
		});
		
		
	
}

/**
 * It is invoked when the submit/update button is clicked.
 * It fetches values of all input fields and assign them to their respective variables.
 * It invokes validateFormJQuery() method which checks the validation status of all flags.
 * If the details entered by the user is valid  and update flag is flase it 
   invokes addToTable() & resetDet() method.
 * If the details entered by the user is valid and update flag is true it 
   invokes updateTable() method.
 */
function myFunction()
{
		var fName = idFirstName.val();
		var lName= idLastName.val();
		var email= idEmail.val();
		var mobile = idMobile.val();
		var address = idAddress.val();
		var dept = idDepartment.val();
		var pswrd = idCnfPassword.val();
	
		var statusFinal = validateFormJQuery();
	
		if( statusFinal == true )
		{
			if(update == true){
				update=false;
				updateTable(rowUpdateNo, fName, lName, email, mobile, address, dept, pswrd);
				resetDet();
			}else{
				addToTable(fName, lName, email, mobile, address, dept, pswrd);
				resetDet();
			}
		}else{
			alert("Please fill the form correctly..!")
		}
}

