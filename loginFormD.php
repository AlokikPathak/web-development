<!DOCTYPE html>

<html lang="en">
<head>
	<title>BootStrap Login Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

	<div class="container" >
	
	
	<form class="form-horizontal">
		
		<h2 class="col-sm-offset-1 col-sm-10" id="loginHeading">Login Form</h2>
		
		<div class="input-group col-sm-4">
		  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		  <input id="email" type="text" class="form-control" name="email" placeholder="Enter your registered email">
		</div>
		
		<div>
			<span class="control-label col-offset-sm-0" id="email_error_message" style="color:tomato; ">Enter a valid Email</span>
		</div><br>
		
		
		<div class="input-group col-sm-4">
		  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		  <input id="password" type="password" class="form-control" name="password" placeholder="Enter your password">
		</div>
		<div>
			<span class="control-label col-offset-sm-0" id="password_error_message" style="color:tomato; ">Enter a valid password</span>
		</div><br>
		
		<div class="form-group">        
			<div class="col-sm-2 col-offset-sm-0">
				<input type="button" class="btn btn-success" id="login" onclick="myFunctionLogin()" value="Login">
			</div><br>	
		</div>
		
		<div class="form-group">
			<div class="col-sm-2">
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

</html>