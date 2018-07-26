
/**
 * Filename  - scriptFormDa.php
 * File path - C:\xampp\htdocs\Project\Repository\
 * Description : Validates registration credentials and sends it to server
 * @author  : Alokik Pathak
 * Created date : 16/07/2018
 */


/**
 * errorFirstName, errorLastName, errorEmail, errorMobile, errorAddress 
   are the flags which are set as true when there is error in their respective input.
 * "rowUpdateNo" stores the value of row which will be updated.
 * "update" is used as flag. It is set as true when user request to update 
   a record.
 * "counter" stores the index of row in which the new user details will be added 
   to table.
 * responseCode stores the Server response code.
 * key stores the unique email of the user for delete and update operation.
 */
var errorFirstName = true;
var errorLastName = false;
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
var idLabelPassword = $("#labelPswrd");
var idLabelCnfPassword = $("#labelCnfPswrd");

var idFirstNameError = $("#fname_error_message");
var idLastNameError = $("#lname_error_message");
var idMobileError = $("#mobile_error_message");
var idAddressError = $("#address_error_message");
var idEmailError = $("#email_error_message");
var idPasswordError = $("#password_error_message");
var idCnfPasswordError = $("#cnfpassword_error_message");

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
		checkFirstName();
	});

	
	$("#lname").keyup(function(){
		checkLastName();
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
	* Validate First Name field in Registration form,
	  Sets the errorFirstName as false if valid else true.
	*
	*/
	function checkFirstName() {
		
		var pattern = /^[a-zA-Z]*$/;
		var fname = $("#fname").val();
		if (pattern.test(fname) && fname !== '') {
			idFirstNameError.hide();
			errorFirstName = false; 
			idFirstName.css("color","Dodgerblue");
		}
		else {
			idFirstNameError.html("Should contain only alphabets");
			idFirstNameError.show();
			errorFirstName = true; 
			idFirstName.css("color","tomato");

		}
	}
	
   /**
	* Validate Last Name field in Registration form,
	  Sets the errorLastName as false if valid else true.
	*
	*/
	function checkLastName() {
		
		var pattern = /^[a-zA-Z]*$/;
		var lname = $("#lname").val();
		
		if(lname == ""){
			idLastNameError.hide();
			errorLastName = false; 
			idLastName.css("color","Dodgerblue");
		}
		else if (pattern.test(lname)) {
			idLastNameError.hide();
			errorLastName = false; 
			idLastName.css("color","Dodgerblue");
			
		}
		else {
			idLastNameError.html("Should contain only alphabets");
			idLastNameError.show();
			errorLastName = true; 
			idLastName.css("color","tomato");

		}
	}
	
    /**
	 * Validates Email data and check for duplicates.
   	 * Set errorEmail value as false for valid data else true.
	 *
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
	 * Validates Mobile data and check for duplicates.
   	 * Set errorMobile value as false for valid data else true.
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
	 * Validates Password field.
   	 * Set errorPassword value as false for valid data else true.
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
	 * Validates Confirm Password field.
   	 * Set errorCnfPassword value as false for valid data else true.
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
 * Fills all the input fields in Registration Form with selected row for update.
 * 
 * @param integer rowNo stores the row no. of selected record in table
 * @param string firstName stores the First Name data
 * @param string lastName stores the Last Name data
 * @param string email stores the Email data
 * @param string mobile stores the Last Name data
 * @param string address stores the Address data
 * @param string department stores the Department data
 * @param string pswrd stores the Password data
 */
function autoFill( rowNo, firstName, lastName, email, mobile, address, department, pswrd ) {
	event.preventDefault();
	
	
	idFirstName.val(firstName);
	idLastName.val(lastName);
	idEmail.val(email);
	idMobile.val(mobile);
	idAddress.val(address);
	idPassword.val(pswrd);
	idCnfPassword.val(pswrd);
	var table = document.getElementById("empTab").rows;
	var y = table[rowNo].cells; 
	idDepartment.val(y[6].innerHTML);
}


/**
 * Sends the validated user data to server to store in database and if stores successfully
   update the Employee details table in the registration form.
 * 
 * @param integer rowNo stores the row no. of selected record in table
 * @param string firstName stores the First Name data
 * @param string lastName stores the Last Name data
 * @param string email stores the Email data
 * @param string mobile stores the Last Name data
 * @param string address stores the Address data
 * @param string department stores the Department data
 * @param string pswrd stores the Password data  
 */
function updateTable(rowNo, firstName, lastName, email, mobile, address, department, pswrd){
	
	event.preventDefault();
	
	runPHPScript(2, firstName, lastName, email, mobile, address, department, pswrd);
	
	if( responseCode == 200 ){
	
	    var x = document.getElementById("empTab").rows[rowNo].cells;
	    x[0].innerHTML = rowNo ;
	    x[1].innerHTML = firstName;
	    x[2].innerHTML = lastName;
	    x[3].innerHTML = email ;
	    x[4].innerHTML = mobile;
	    x[5].innerHTML = address ;
	    x[6].innerHTML = department;
	    x[7].innerHTML = pswrd;
		
		resetDetails();
     	alert("Table updated...!");
	}else{
		alert("Could not update the table Server Response error ");
	}
	
}


/**
 * updateRow() method is invoked when user clicks on the Update button 
 * @param reference indexThis stores the reference to index in table
   selected for update the record 
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
	
	
	errorFirstName = errorEmail = errorMobile= errorCnfPassword = false;
	errorLastName = errorAddress = errorPassword = false;
	
	idHeading.html("Update Employee Details");
	idSubmit.val("UPDATE");
	idSubmit.css("background-color","Dodgerblue");
	key=x[3].innerHTML;

	
}


/**
 * Checks if email entered by user is already available or not.
 *
 * @param string emailInput Contains email field data
 * @return boolean false if duplicate not present else true
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
 * Checks if mobile entered by user is already available or not.
 *
 * @param string mobileInput contains mobile input field data
 * @return boolean false if duplicate not present else true
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
 * It updates the Sl.No. in Registration Form table after delete operation
 */
function updateAfterdel(rowNo){
	for(var i=rowNo; i<counter; i++){
		var x = document.getElementById("empTab").rows[i].cells;
		x[0].innerHTML = i;
	}
}


/**
 * Deletes the selected row from the Database and Registration form table.
 *
 * @param reference stores the reference to the selected row in the table.
 */
function deleteRow(index)
{
	var rowNum = index.parentNode.parentNode.rowIndex ;
	var x = document.getElementById("empTab").rows[rowNum].cells;
	key = x[3].innerHTML;
	
	
	event.preventDefault();
	runPHPScript(3,'','','','','','','');
		
	if(responseCode == 200){
		
		resetDetails();
		
		alert("Do you want to delete row: "+ rowNum);	
		document.getElementById("empTab").deleteRow( rowNum );
		counter--;
		
		updateAfterdel( rowNum);
		alert("Row: "+ rowNum +" deleted..!");
		resetDetails();
		
	}else{
		alert("Could not delete Server Response error");
	}
}


/**
 * It adds the user's data to the database and then to the Form table.
 *
 * @param string firstName stores the First Name data
 * @param string lastName stores the Last Name data
 * @param string email stores the Email data
 * @param string mobile stores the Last Name data
 * @param string address stores the Address data
 * @param string department stores the Department data
 * @param string pswrd stores the Password data  
 */
function addToTable(firstName, lastName, email, mobile, address, department, pswrd)
{

	
  /** Invoke the Function to store the details in MySQL database **/
  runPHPScript(1, firstName, lastName, email, mobile, address, department, pswrd);

  
  if( responseCode == 200 ){
	  
	var table = document.getElementById("empTab");
	var row = table.insertRow( counter );
		
	row.insertCell(0).innerHTML = counter;
	row.insertCell(1).innerHTML = firstName;
	row.insertCell(2).innerHTML = lastName;
	row.insertCell(3).innerHTML = email;
	row.insertCell(4).innerHTML = mobile;
	row.insertCell(5).innerHTML = address;
	row.insertCell(6).innerHTML = department;
	row.insertCell(7).innerHTML = pswrd;
	
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
	resetDetails();
	alert("Data inserted successfully into table");
	
  }else{
	  alert("Could not add to table Server Response Error: ");
  }  
}

/**
 * Hides all the error messages in the Registration Form.
 */
function hideErrorMessage()
{	
		idFirstNameError.hide();
		idLastNameError.hide();
		idEmailError.hide();
		idMobileError.hide();
		idAddressError.hide();
		idPasswordError.hide();
		idCnfPasswordError.hide();
}


/**
 * Validates the all user's data.
 * 
 * @return boolean false if data is valid else true.
 */
function validateFormJQuery()
{
	
	if( errorFirstName == false && errorLastName == false && errorEmail == false && 
	    errorMobile== false && errorAddress == false && errorPassword == false
		&& errorCnfPassword == false){
		return true;
	}else{
		return false;
	}
}


/**
 * Clear the Registration Form page and different Error flags.
 */
function resetDetails()
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
	
	errorFirstName = errorEmail = errorMobile = errorPassword = errorCnfPassword= true;
	errorAddress = errorLastName = false;
	
	hideErrorMessage();
	
	idSubmit.val("SUBMIT");
	idSubmit.css("background-color","#4CAF50");	
	idHeading.html("Registration Form");
	
	
	
}

/**
 * Performs the SQL operations on server MYsql database.
 * 
 * @param integer operationCode stores the value of different operations
 * @param string firstName stores the First Name data
 * @param string lastName stores the Last Name data
 * @param string email stores the Email data
 * @param string mobile stores the Last Name data
 * @param string address stores the Address data
 * @param string department stores the Department data
 * @param string pswrd stores the Password data
*/

function runPHPScript(operationCode, firstName, lastName, email, mobile, address, department, pswrd)
{
	var formDataObj= {'operation':operationCode, 'keyValue':key,
	'firstName':firstName, 'lastName':lastName, 'email':email, 'mobile':mobile,
	'address':address,'department':department, 'password':pswrd};
		
	var formDataJSON = JSON.stringify(formDataObj);
	var responseObj;
	$.ajax
	({
		type: "POST",
		url: "authRegistrationFormD.php",
		data: 'data='+formDataJSON,
		success: function(data)
		{
			responseObj = JSON.parse(data);
			responseCode = responseObj.code;
		}
	});
		
}

/**
 * Stores & validates the input fields values performs Insert & Update operations
 */
function myFunction()
{
	var firstName = idFirstName.val();
	var lastName= idLastName.val();
	var email= idEmail.val();
	var mobile = idMobile.val();
	var address = idAddress.val();
	var department = idDepartment.val();
	var pswrd = idCnfPassword.val();
	
    var hashKeyPswrd = CryptoJS.MD5(pswrd);
	hashKeyPswrd = hashKeyPswrd.toString();
	var statusFinal = validateFormJQuery();

	if( statusFinal == true )
	{
		if(update == true){
			update=false;
			updateTable(rowUpdateNo, firstName, lastName, email, mobile, address, department, hashKeyPswrd);
			resetDetails();
		}else{
			addToTable(firstName, lastName, email, mobile, address, department, hashKeyPswrd);
			resetDetails();
		}
	}else{
		alert("Please fill the form correctly..!")
	}
}

