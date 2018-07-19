<?php

	$con = mysqli_connect('127.0.0.1', 'root','');
	
	if(!$con){
		echo'Not connected to Server';
	}
	
	if(!mysqli_select_db($con, 'employee')){
		echo'Not conneted to database';
	}
	

	
	$fName = $_POST['firstName'];
	$lName = $_POST['lastName'];
	$Email = $_POST['nameEmail'];
	$Mobile = $_POST['nameMobile'];
	$Address = $_POST['nameAddress'];
	$Department = $_POST['nameDepartment'];
	
	echo 'Inside php<br>';
	echo $fName."<br>";
	echo $lName."<br>";
	echo $Email."<br>";
	echo $Mobile."<br>";
	echo $Address."<br>";
	echo $Department."<br>";
	
	if($fName == ""){
		echo "Invalid details please resubmit the details!!";
	}
	else{
	
		$sql = "insert into employeetable (firstname, lastname, Email, mobile, address, department) values ('$fName', '$lName', '$Email', '$Mobile', '$Address', '$Department')";
	
		if(!mysqli_query($con, $sql)){
			echo'Not inserted into table!';
		}
		else{
			echo"Inserted";
		}		
    }
	header("refresh:1; url=regFormC.php");
?>