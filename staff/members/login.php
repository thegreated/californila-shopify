<?php
	
	if(is_post_request()) {

	   $args = $_POST['person'];

	   $people = new People($args);
	   $results = $people->login();
	   if($results){
		   //echo $people->id .' '.$people->email;
		   insert_Session($people->id,$people->email);
		   require_login_redirect();
	   }
	}else{
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
					<input class="form-control" type="email" name="person[email]" placeholder="Email">
				</div>
				<div class="form-group">
					<input class="form-control" type="password" name="person[password]" placeholder="Password" >
				</div>
				 <div class="form-group"><button class="btn category-nav category-header btn-block" type="submit">Log In</button>
				</div>
					 <a href="reset.html" class="forgot">Forgot your email or password?</a>		
		</div>
	</div>
</div>
