<?php
	
	$fnameErr = $lnameErr = $emailErr=$mobileErr=$addressErr=$departmentErr="";
	
	$con = mysqli_connect('127.0.0.1', 'root','');
	
	if(!$con){
		echo'Not connected to Server';
	}
	
	if(!mysqli_select_db($con, 'employee')){
		echo'Not conneted to database';
	}
	
	$formDataJsonArray= json_decode($_POST['data'],true);
	
	$fName = $formDataJsonArray['fname'];
	$lName = $formDataJsonArray['lname'];
	$Email = $formDataJsonArray['email'];
	$Mobile = $formDataJsonArray['mobile'];
	$Address = $formDataJsonArray['address'];
	$Department = $formDataJsonArray['department'];
	
	
	$sql = "insert into employeetable (firstname, lastname, Email, mobile, address, department) values ('$fName', '$lName', '$Email', '$Mobile', '$Address', '$Department')";
	
	if(!mysqli_query($con, $sql)){
		echo'Not inserted into table!';
	}
	else{
		$myObj = new StdClass;
		$myObj->id = rand(100,999).$Email;
		$myObj->fname = $fName;
		$myObj->lname = $lName;
		$myObj->email = $Email;
		$myObj->mobile = $Mobile;
		$myObj->address = $Address;
		$myObj->department = $Department;
		
		$responseServerJSON = json_encode($myObj);
		
		echo $responseServerJSON;
	}		
    
?>