<!DOCTYPE html>

<!--
/**
 * Filename  - loginFormD.php
 * File path - C:\xampp\htdocs\Project\Repository\
 * Description : It is a User Login Form page.
 * @author  : Alokik Pathak
 * Created date : 20/07/2018
 */
-->

<html lang="en">
<head>
	<title>BootStrap Login Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

	<div class="container" >
	
	<form class="form-horizontal" style="margin-right:auto; margin-left:auto; text-align:center">
		
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
	
		
</body>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
 <script src="scriptLoginFormD.js"></script> 
 <script src="md5.js"></script>

 

</html>