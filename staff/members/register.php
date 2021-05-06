<?php
	require_once('admin/initialize.php');
	require_login_redirect();
	include(SHARED_PATH . '/public_header.php');
	include(SHARED_PATH . '/public_navigation.php');

	if(is_post_request()) {
			
		// Create record using post parameters
	   $args = $_POST['person'];
	   $people = new People($args);
	   $result = $people->create();
	   
	   
	   if($result === true) {
		$new_id = $people->id;
		$session->message('Your account was created successfully. You need to check your email to verify your account');
		} else {
			// show errors
		}
	}else {
	  // display the form
	  $people = new People;
	}

?>
<div class="container">
	<div class="col-md-6">
		<div class="" style="margin-top:50px;margin-bottom: 100px">
			
			<p>Dont have an account ? <a href="#">Register</a></p>
			<form method="post">
				<div class="section-title">
					<h3 class="title">Login</h3>
				</div>
				<div class="errors">
				   <b>
				  <?php echo display_session_message();?>
				  <?php echo display_errors($people->errors); ?>
				  </b> 
		 		 </div>
		 		 <br/>
		 		<div class="form-group">
		 			<input class="input" type="text" name="person[first_name]" placeholder="First Name">
		 		</div>
				<div class="form-group">
					<input class="input" type="text" name="person[last_name]" placeholder="Last Name">
				</div>
				<div class="form-group">
					<input class="input" type="email" name="person[email]" placeholder="Email">
				</div>
				<div class="form-group">
					<input class="input" type="text" name="person[address]" placeholder="Address">
				</div>
				<div class="form-group">
					<input class="input" type="text" name="person[city]" placeholder="City">
				</div>
				<div class="form-group">
					<input class="input" type="text" name="person[zip_code]" placeholder="ZIP Code">
				</div>
				<div class="form-group">
					<input class="input" type="number" name="person[contact_number]" placeholder="Contact Number: Ex: 09123456789">
				</div>
				<div class="form-group">
					<input class="input" type="password" name="person[password]" placeholder="Password">
				</div>
				<div class="form-group">
					<input class="input" type="password" name="person[confirm_password]" placeholder="Confirm password">
				</div>
    
                <div class="form-group">
                    <div class="form-check"><label class="form-check-label">
                    	<input class="form-check-input" type="checkbox">I agree to the license terms.</label>
                    </div>
                </div>
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Sign Up</button></div><a href="Login.html" class="already">You already have an account? Login here.</a>
				
		</div>
	</div>
</div>
<?php  include(SHARED_PATH . '/public_footer.php'); ?>