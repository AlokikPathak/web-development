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
	
	$operationCode = $formDataJsonArray['operation'];
	$key = $formDataJsonArray['keyValue'];
	$fName = $formDataJsonArray['fname'];
	$lName = $formDataJsonArray['lname'];
	$Email = $formDataJsonArray['email'];
	$Mobile = $formDataJsonArray['mobile'];
	$Address = $formDataJsonArray['address'];
	$Department = $formDataJsonArray['department'];
	
	//Delete operation for code=3
	if($operationCode == 3){
	
		$sql = "delete from employeetable where Email = '$key' ";
		
		if(!mysqli_query($con, $sql)){
			echo'Not deleted from table!';
		}
		else{
			echo"Row Deleted from table!";
		}
	}
	else if($operationCode == 2){ //Update operation for code=2
		echo "Inside php update operation..!";
		
		$sql = "update employeetable set firstname='$fName', lastname='$lName', Email='$Email', mobile='$Mobile', address='$Address', department='$Department' where Email = '$key' ";
		if(!mysqli_query($con, $sql)){
			echo"Table not updated!!";
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
	}
	else if($operationCode == 1){  //Insert operation for code=1
		
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
	}
	
    
?>