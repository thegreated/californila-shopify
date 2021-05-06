<?php  require_once('../admin/initialize.php'); 
      // require_login_redirect_controller();
       include(ADMIN_SHARED . '/header_admin.php');
        $page = 'admin_controller';
        include(ADMIN_SHARED . '/menu_admin.php');?>


        <div class="content-wrapper">
        <div class="container">
            <div class="row">
                    <h4 class="page-head-line">List of administrator user</h4>
                    	<button type="button" id="myBtn"  class="btn btn-success" data-id="35">Add Administrator</button>
                    	<br/>
                    	<br/>
					<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $admin = new admin();
                                        $all_admin =   $admin->find_all();
                                        foreach($all_admin as $admin) {?>
                                        <tr>
                                            <td>1</td>
                                    
                                                    <td><?=$admin->name; ?> </td>
                                                    <td><?=$admin->username; ?> </td>
                                          
                                            <td>
                                            	<button type="button" id="myBtn2" class="btn btn-danger" data-id="35">Delete</button>
                                            </td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                            </div>
         </div>
     </div>
 </div>
 <!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    
                    <br />
                        <label>Name : </label>
                        <input type="text" name='admin[name]' class="form-control" />
                        <label>Username : </label>
                        <input type="text" name='admin[username]' class="form-control" />
                        <label>Password :  </label>
                        <input type="password"  name='admin[password]' c class="form-control" />
                        <label>Confirm Paassword :  </label>
                        <input type="password"  name='admin[confirm_password]' c class="form-control" />
                        <hr />
                        <button  id="add_admin"class="btn btn-info"><span class="glyphicon glyphicon-user"></span> &nbsp;Create An admin </button>&nbsp;
                        <b id="error" style="color:red"> </b>

  </div>

</div>

<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }


    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
       modal.style.display = "none";
       return false;
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
         modal.style.display = "none";
        }
    }

    $("#add_admin").click(function(){
        var name = $("input[name='admin[name]']").val();
        var username = $("input[name='admin[username]']").val();
        var password = $("input[name='admin[password]']").val();
        var Cpassword = $("input[name='admin[confirm_password]']").val();
        var error = 'error';

        var admin = {
            name:name,
            username:username,
            password:password
        };
        console.log(admin);

        if(username == '' || password == '' ||  Cpassword == ''|| name == ''){
            show_error(error,'You must fill out all the information to proceed');
        }else if(password != Cpassword){
           show_error(error,'Password and Confirm Password must be the same');
        }else if(username.length < 6 ){
            show_error(error,'Username must be greater than 6 characters');
        }else if(username.password < 6 ){
            show_error(error,'Password must be greater than 6 characters');
        }
        var condition = 'add_admin';
        ajax_method(condition,admin);


    });

    function show_error(id,message){
        $('#'+id).html(message);
    }

    function ajax_method(condition,datas){

         $.ajax({
            url: "ajax.class.php",
            type: "post",
            data: {method:condition, arr:datas},
            success: function (data) {
                database_error(data);
            },
            error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert("error"+err.Message);
            }
        });
    }

    function database_error(data){
         var error = 'error';
        if(data.trim() == 'error'){
            show_error(error,'Username is already in registered');
        }else{
            show_error(error,'You successfully save the data');
        }
    }
</script>
<style type="text/css">
	
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
    <?php  include(ADMIN_SHARED . '/footer_admin.php'); ?>



