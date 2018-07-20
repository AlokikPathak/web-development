<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="responsiveRegFormBstyle.css">
  
</head>
<body >

	<div class="container"  >
	<h2 class="col-sm-offset-2 col-sm-10" id="Heading" > Registration Form </h2>
	
	<form class="form-horizontal">
		<div class="form-group">
			<label class="control-label col-sm-2" for="fname">First Name<span style="color: red"> * </span></label>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="fname" placeholder="Enter your first name" name="fname">
			</div>
			<span class="control-label col-offset-sm-4" id="fname_error_message" style="color:tomato; ">Enter a valid first name</span>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="lname">Last Name</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="lname" placeholder="Enter your last name" name="lname">
			</div>
			<span class="control-label col-offset-sm-4" id="lname_error_message" style="color:tomato; ">Enter a valid last name</span>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="email">Email<span style="color: red"> * </span></label>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="email" placeholder="Enter your email" name="email">
			</div>
			<span class="control-label col-offset-sm-4" id="email_error_message" style="color:tomato; ">Enter a valid email</span>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="mobile">Mobile No.<span style="color: red"> * </span></label>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="mobile" placeholder="Enter your mobile no." name="mobile">
			</div>
			<span class="control-label col-offset-sm-4" id="mobile_error_message" style="color:tomato; ">Enter a valid mobile</span>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2" for="address">Address</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="address" placeholder="Enter your address" name="address">
			</div>
			<span class="control-label col-offset-sm-4" id="address_error_message" style="color:tomato; ">Enter a valid address</span>
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
			<div class="col-sm-offset-2 col-sm-10">
				<input type="button" class="btn btn-success" id="subUpd" onclick="myFunction()" value="SUBMIT">
			</div>	
		</div>
		
		<div class="form-group">        
			<div class="col-sm-offset-2 col-sm-10">
				<input type="button" class="btn btn-danger" ondblclick="resetDet()" value="RESET">
			</div>
			
		</div>
	</form>

	
	<div class="form-group">
		<label class="control-label col-sm-2" for="Employee">Employee Details: </label><br>
	</div>
		
	<div class="table-responsive">	
		<table class="table table-bordered" id="empTab">
		<thead>
			<tr>
				<th>Sl.No.</th>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>Address</th>
				<th>Department</th>
				<th>Update</th>
				<th>Delete</th>
			</tr>
		</thead>
		
		</table>
	</div>
		

	
	
</body>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
 <script src="scriptFormD.js"></script>

</html>