<!DOCTYPE html>

<!--
/**
 * Filename  - loginFormE.php
 * File path - C:\xampp\htdocs\Project\Repository\
 * Description : It is a User Login Form page.
 * @author  : Alokik Pathak
 * Created date : 20/07/2018
 */
-->

<html lang="en">
<head>
	<title>Login Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

	<div class="container" >
	
	<form class="form-horizontal" style="margin-right:auto; margin-left:auto; text-align:center" id="loginForm">
		
		<h2 class="col-sm-offset-1 col-sm-10" id="loginHeading">Login Form</h2>
		<h5 class="col-sm-offset-1 col-sm-10" id="responseHead"></h5>
		<div class="input-group col-sm-offset-4 col-sm-4 " style="text-align:center">
		  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		  <input id="email" type="text" class="form-control" name="email" placeholder="Enter your registered email">
		</div>
		
		<div>
			<span class="control-label col-offset-sm-0" id="email_error_message" style="color:tomato; ">Enter a valid Email</span>
		</div><br>
		
		<div class="input-group col-sm-offset-4 col-sm-4">
		  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		  <input id="password" type="password" class="form-control" name="password" placeholder="Enter your password">
		</div>
		
		<div>
			<span class="control-label col-offset-sm-0" id="password_error_message" style="color:tomato; ">Enter a valid password</span>
		</div><br>
		
		<div class="form-group">        
			<div class="col-sm-2 col-sm-offset-5">
				<input type="button" class="btn btn-success" id="login" onclick="myFunctionLogin()" value="Login">
			</div><br>	
		</div>
		
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-10" >
				<p><a href="regFormD.php">Sign Up</a> here!</p>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-2">
				<p id="paragraph" ></p>
			</div>
		</div>
		
	</form>
	
	</div>
	
<div class="container"  >
	
	<form class="form-horizontal" id="updateRecord" >
	
			<h2 class="" id="HeadingA" style="text-align:center" > Welcome </h2>
			<h3 class="" id="Heading" style="text-align:center" > Update your credentials! </h3>
			
		<div class="form-group">
			<label class="control-label col-sm-2" for="fname">First Name<span style="color: red"> * </span></label>
			<div class="col-sm-6	">
			  <input type="text" class="form-control" id="fname" placeholder="Enter your first name" name="fname">
			</div>
			<span class="control-label col-offset-sm-4" id="fname_error_message" style="color:tomato; "></span>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="lname">Last Name</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="lname" placeholder="Enter your last name" name="lname">
			</div>
			<span class="control-label col-offset-sm-4" id="lname_error_message" style="color:tomato; "></span>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="email">Email<span style="color: red"> * </span></label>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="emailUpdate" placeholder="Enter your email" name="email">
			</div>
			<span class="control-label col-offset-sm-4" id="update_email_error_message" style="color:tomato; "></span>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="mobile">Mobile No.<span style="color: red"> * </span></label>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="mobile" placeholder="Enter your mobile no." name="mobile">
			</div>
			<span class="control-label col-offset-sm-4" id="mobile_error_message" style="color:tomato; "></span>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="address">Address</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="address" placeholder="Enter your address" name="address">
			</div>
			<span class="control-label col-offset-sm-4" id="address_error_message" style="color:tomato; "></span>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="sel1">Department<span style="color: red"> * </span></label>
			<div class="col-sm-6">
			  <select class="form-control " id="department">
				<option>Software Engineer</option>
				<option>Software Test Engineer</option>
				<option>UX/UI Engineer</option>
			
			  </select>
			</div>
		</div>
		
		<div class="form-group">        
			<div class="col-sm-offset-2 col-sm-10 text-left">
				<input type="button" class="btn btn-success" id="subUpd" onclick="updateData()" value="UPDATE">
			</div>	
		</div>
		
	</form>
	
		
</body>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
 <script src="scriptLoginFormE.js"></script> 
 <script src="md5.js"></script>

 

</html>