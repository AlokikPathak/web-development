/**
 * error_fname, error_lname, error_email, error_mobile, error_address 
 * are the flags which are set as true when there is error in their respective input.
 * rowUpdateNo stores the value of row which will be updated.
 * update is used as flag. It is set as true when user request to update a record.
 * counter stores the index of row in which the new user details will be added to table.
*/
var error_fname = true;
var error_lname = false;
var error_email = true;
var error_mobile = true;
var error_address = false;
var rowUpdateNo =0;
var update=false; 
var counter=1;


/**
 * Assigning ids of form Elements to variable which are accessed many time of Code optimization
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

var idFnameError = $("#fname_error_message");
var idLnameError = $("#lname_error_message");
var idMobileError = $("#mobile_error_message");
var idAddressError = $("#address_error_message");
var idEmailError = $("#email_error_message");


/**
 * Alternate of $(document).ready(function(){});
 * Executed after all DOM elements are loaded and Document is ready
 */
$(function(){

	hideErrorMessage();
	idTable.hide();

	
	$("input[type=text]").focus(function(){
		$(this).css("background-color","#ffffcc");
	});
	
	$("input[type=text]").blur(function(){
		$(this).css("background-color","#ffffff")
	});
	
	$("input[type=text]").keydown(function(){
		$(this).css("background-color","#ffffff")
	});
	
	$("input[type=text]").keyup(function(){
		$(this).css("background-color","#ffffcc")
	});
	
	$("#fname").keyup(function(){
		check_fname();
	});

	
	$("#lname").keyup(function(){
		check_lname();
	});
	
	
	$("#email").keyup(function(){
		check_email();
	});
	
	$("#mobile").keyup(function(){
		check_mobile();
	});
	
	
	/**
	* check_fname() is method which validates the First name entered by the user.
	* It is invoked by keyup() event when user is entering the details.
	* set the error_lname flag as true when invalid and false when it is valid.
	* Returns "true" if the entered name is invalid.
	* Returns "false" if entered name is valid.
	*/
	function check_fname() {
		
		var pattern = /^[a-zA-Z]*$/;
		var fname = $("#fname").val();
		if (pattern.test(fname) && fname !== '') {
			idFnameError.hide();
			error_fname = false; 
			idFirstName.css("color","Dodgerblue");
		}
		else {
			idFnameError.html("Should contain only alphabets");
			idFnameError.show();
			error_fname = true; 
			idFirstName.css("color","tomato");

		}
	}
	
	/**
	* check_lname() is method which validates the last name entered by the user.
	* It is invoked by keyup() event when user is entering the details.
	* set the error_lname flag as true when invalid and false when it is valid.
	* returns "true" if the entered name is invalid.
	* returns "false" if entered name is valid.
	*/
	function check_lname() {
		
		var pattern = /^[a-zA-Z]*$/;
		var lname = $("#lname").val();
		
		if(lname == ""){
			idLnameError.hide();
			error_lname = false; 
			idLastName.css("color","Dodgerblue");
		}
		else if (pattern.test(lname)) {
			idLnameError.hide();
			error_lname = false; 
			idLastName.css("color","Dodgerblue");
			
		}
		else {
			idLnameError.html("Should contain only alphabets");
			idLnameError.show();
			error_lname = true; 
			idLastName.css("color","tomato");

		}
	}
	
	/**
	* check_email() is method which validates the email entered by the user.
	* It is invoked by keyup() event when user is entering the details.
	* It checks first wheather the entered email is valid.
	* If email is found to be valid, it invokes "checkDuplicateEmail(email)" method.
	* If the email is valid and not having any duplicate;
		* "error_email" is set as "false" else it is set as "true".
	* returns "true" if the entered email is invalid & not having any duplicate.
	* returns "false" if entered email is valid.
	*/
	function check_email() {
		
		var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var email = $("#email").val();
		if(pattern.test(email) && email !== '') {
			
			var emailDuplicate = checkDuplicateEmail(email);
			
			if(emailDuplicate == false ){
				idEmailError.hide();
				error_email = false;
				idEmail.css("color","Dodgerblue");
			}
			else{
				
				idEmailError.html("Email already exist! Try something else");
				idEmailError.show();
				error_email = true;
				idEmail.css("color","tomato");
				
			}
		}
		else {	
			idEmailError.html("Invalid Email (ex. xyz@gmail.com)");
			idEmailError.show();
			error_email = true;
			idEmail.css("color","tomato");
		}
	}
	

	
   /** 
	* check_mobile() is method which validates the mobile no. entered by the user.
	* It is invoked by keyup() event when user is entering the details.
	* It checks first wheather the entered mobile no. is valid.
	* If mobile is found to be valid, it invokes "checkDuplicateMobile(mob)" method.
	* If the mobile no. is valid and not having any duplicate;
		A. "error_mobile" is set as "false" else it is set as "true".
	* returns "true" if the entered mobile is invalid & not having any duplicate.
	* returns "false" if entered mobile is valid.
	*/
	function check_mobile(){
		var mob = $("#mobile").val();
		var pattern = /^(\+\d{1,3}[- ]?)?\d{10}$/;
		if( pattern.test(mob) ){ 
			var mobileDuplicate = checkDuplicateMobile(mob);
			
			if(mobileDuplicate == false ){
				idMobileError.hide();
				error_mobile = false;
				idMobile.css("color","Dodgerblue");
			}
			else{
				
				idMobileError.html("Mob. No. already exist! Try something else");
				idMobileError.show();
				mobile_email = true;
				idMobile.css("color","tomato");
				
			}
		}
		else{
			idMobileError.html("Mobile must contain 10 digit numeric value");
			idMobileError.show();
			error_mobile = true;
			idMobile.css("color","tomato");
		}
	}
	
	
	/**
	 * AJAX Request to acces a JSON File
	 * XMLHttpRequest obj. can be used to exchange the data at the background of Web without reloading the whole page

	 
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var myObj = JSON.parse(this.responseText);
		for(var i=0; i< myObj.length; i++){
			addToTable(myObj[i].fname, myObj[i].lname, myObj[i].email, myObj[i].mobile, myObj[i].address, myObj[i].department);	
		}
      }
	};
	xmlhttp.open("GET", "empData.json", true);
	xmlhttp.send();
	
	**/
	
});



/** 
 * It invoked by updateRow() method.
 * Seven arguments are passed which are fname, lname, email, mobile, address & department while invocation.
 * It fills out the text input fields such First Name, Last Name, Email, Mobile etc. of the respective row.
 * It returns nothing specifically.
 */
function autoFill( rowNo, fName, lName, Email, Mobile, Address, Department ) {
	event.preventDefault();
	
	idFirstName.val(fName);
	idLastName.val(lName);
	idEmail.val(Email);
	idMobile.val(Mobile);
	idAddress.val(Address);
	var table = document.getElementById("empTab").rows;
	var y = table[rowNo].cells; 
	idDepartment.val(y[6].innerHTML);
}


/**
 * It updates the table after user make changes in existing details entered earlier.
 * It is invoked by "submit/update" button is clicked.
 * Seven arguments are passed to it which needs to be updated on the table in specific row which is 1st coloumn.
 * It internally invoke the resetDet() method after updating the table and clears the input fields.
 */
function updateTable(r, fName, lName, Email, Mobile, Address, Dept){
	resetDet();
	event.preventDefault();

	var x = document.getElementById("empTab").rows[r].cells;
	x[0].innerHTML = r ;
	x[1].innerHTML = fName;
	x[2].innerHTML = lName;
	x[3].innerHTML = Email ;
	x[4].innerHTML = Mobile;
	x[5].innerHTML = Address ;
	x[6].innerHTML = Dept;
	
	alert("Table updated...!");
	
}


/**
 * UpdateRow() method is invoked when user clicks on the Update button assign to each row.
 * It sets the update flag as true & assign the global var of row i.e., rowUpdateNo to respective value.
 * It then invoke autofill() method which fills out the Form.
 * It then sets the error_fname, error_lname, error_email, error_mobile, error_address flag as false.
 */
function updateRow( indexThis, fName, lName, Email, Mobile, Address, Dept){
	
	update = true;	
	var rowNo = indexThis.parentNode.parentNode.rowIndex ;
	
	rowUpdateNo = rowNo;	
	autoFill(rowNo, fName, lName, Email, Mobile, Address, Dept);
	
	error_fname = error_email = error_mobile= false;
	error_lname = error_address = false;
	
	idHeading.html("Update Employee Details");
	idSubmit.val("UPDATE");
	idSubmit.css("background-color","Dodgerblue");

	
}


/**
 * checkDuplicateEmail() method is invoked by check_email() method.
 * It checks wheather the entered email by user already exist or duplicate or not.
 * It first check out the update flag if yes it ignores that row.
 * It returns "true" if it finds duplicate email else it returns "false".
 */

function checkDuplicateEmail( emailInput){
	if(update == false){
		for(var i=1; i<counter; i++){
			var x = document.getElementById("empTab").rows[i].cells;

			if( emailInput == x[3].innerHTML){
				return true;
			}
		}
	}
	else{
		
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
 * checkDuplicateMobile() method is invoked by check_mobile() method.
 * It checks wheather the entered mobile by user already exist or duplicate or not.
 * It first check out the update flag if yes it ignores that row.
 * It returns "true" if it finds duplicate mobile else it returns "false".
 */
function checkDuplicateMobile( mobileInput ){
	
	if(update == false ){
		for(var i=1; i<counter; i++){
			var x = document.getElementById("empTab").rows[i].cells;

			if( mobileInput == x[4].innerHTML){
				return true;
			}
		}
	}
	else{
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
 */
function deleteRow(index){
		event.preventDefault();
		resetDet();
		
		var rowNum = index.parentNode.parentNode.rowIndex ;
		alert("Do you want to delete row: "+ rowNum);
		
		document.getElementById("empTab").deleteRow( rowNum );
		counter--;
		
		updateAfterdel( rowNum);
		
		alert("Row: "+ rowNum +" deleted..!");
}


/**
 * addToTable() method is used to add new user details into the table.
 * It is invoked when user clicks the submit/update button and when update flag is set as false.
 * It is invoked after the details are validated.
 * It adds the input details to table and increment the counter.
 */
function addToTable(fName, lName, Email, Mobile, Address, Dept){

	
	var table = document.getElementById("empTab");
	var row = table.insertRow( counter );
		
	row.insertCell(0).innerHTML = counter;
	row.insertCell(1).innerHTML = fName;
	row.insertCell(2).innerHTML = lName;
	row.insertCell(3).innerHTML = Email;
	row.insertCell(4).innerHTML = Mobile;
	row.insertCell(5).innerHTML = Address;
	row.insertCell(6).innerHTML = Dept;
	

	var btnUpdate = document.createElement("button");
	btnUpdate.setAttribute("name","buttonUpdate");
	btnUpdate.setAttribute("id","buttonUpdate");
	btnUpdate.setAttribute("value","updateBtn");
	btnUpdate.setAttribute("class","newButtonUpdate");
	btnUpdate.onclick= function(){
		event.preventDefault();
		updateRow( this , fName, lName, Email, Mobile, Address, Dept);
	}
	row.insertCell(7).appendChild(btnUpdate);
	
	
	var btnDel = document.createElement("button");
	btnDel.setAttribute("name","buttonDel");
	btnDel.setAttribute("value","delete");
	btnDel.setAttribute("class","newButtonDelete");
	btnDel.onclick= function(){
	
		deleteRow(this);
		event.preventDefault();
	}
	row.insertCell(8).appendChild(btnDel);
	
	alert("All details are validated and  inserted inside the table.!");
	
	counter++;			 
}

/**
 * Invoked by resetDel() method.
 * Hides all the error messages if they are in form.
 */
function hideErrorMessage(){
	
		idFnameError.hide();
		idLnameError.hide();
		idEmailError.hide();
		idMobileError.hide();
		idAddressError.hide();
}


/**
 * It checks the status of validation flags assign to input fields.
 * If the all the flag are false i.e., entered details are correct returns "true".
 * If any of the flag status is false it returns "false"
 */
function validateFormJQuery(){
	
	if( error_fname == false && error_lname == false && error_email == false && error_mobile== false && error_address == false){
		return true;
	}
	else{
		return false;
	}
}


/**
 * This method is used to reset or clear the registration form.
 * It sets the update flag as false and clear the input fields.
 * It also sets the validation flags assign to each input as default.
 * It also invokes hideErrorMessage() method which hides all the error messages.
 */
function resetDet(){
	
	update = false;
	
	idFirstName.val("");
	idLastName.val("");
	idEmail.val("");
	idMobile.val("");
	idAddress.val("");
	idDepartment.val("Software Engineer");
	
	error_fname = error_email = error_mobile = true;
	erro_address = error_lname = false;
	
	hideErrorMessage();
	
	idSubmit.val("SUBMIT");
	idSubmit.css("background-color","#4CAF50");	
	idHeading.html("Registration Form");
}

/**
 * It is invoked when the submit/update button is clicked.
 * It fetches values of all input fields and assign them to their respective variables.
 * It invokes validateFormJQuery() method which checks the validation status of all flags.
 * If the details entered by the user is valid  and update flag is flase it invokes addToTable() & resetDet() method.
 * If the details entered by the user is valid and update flag is true it invokes updateTable() method.
 */
function myFunction() {

		var fName = idFirstName.val();
		var lName= idLastName.val();
		var Email= idEmail.val();
		var Mobile = idMobile.val();
		var Address = idAddress.val();
		var Dept = idDepartment.val();
	
		var statusFinal = validateFormJQuery();
		
		if(statusFinal==false){
			idFirstName.val("");
		}
	
		if( statusFinal == true ){
			if(update == true){
				update=false;
				updateTable(rowUpdateNo, fName, lName, Email, Mobile, Address, Dept);
			}
			else{
				//addToTable(fName, lName, Email, Mobile, Address, Dept);
				//resetDet();
			}
		}
		else{
			$("#hiddenNum").html("2");
			alert("Please fill the form correctly..!")
			
		}
		
}

