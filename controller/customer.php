<?php  require_once('../admin/initialize.php'); 
      // require_login_redirect_controller();
       include(ADMIN_SHARED . '/header_admin.php');
        $page = 'customer';
        include(ADMIN_SHARED . '/menu_admin.php');?>


        <div class="content-wrapper">
        <div class="container">
            <div class="row">
                    <h4 class="page-head-line">List of customer user</h4>
                    	<button type="button" id="myBtn"  class="btn btn-success" data-id="35">View Trash</button>
                    	<br/>
                    	<br/>
					<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Contact Number</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customer">
                                    <?php 
                                        $people = new people();
                                        $all_people =   $people->find_all();
                                        foreach($all_people as $people) {?>
                                        <tr>
                                                    <td><?=$people->id;?></td>
                                                    <td><?=$people->first_name;?> <?=$people->last_name;?></td>
                                                    <td><?=$people->email;?></td>
                                                    <td><?=$people->address;?></td>
                                                    <td><?=$people->city;?></td>
                                                    <td><?=$people->contact_number;?></td>
                                            <td>
                                                <a href="#" id="myBtn" class="btn btn-primary" >View Profile</a>
                                            	<button type="button" id="trashbtn" class="btn btn-danger" data-id="<?=$people->email;?>">Move to trash</button>
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
  <div class="modal-content" >
    <span class="close">&times;</span>
        <table class="table table-hover" id="trash_customer"><style> td{align:left;}</style>
                        <tr>
                         <th>name</th>
                         <th>email</th>';
                         <th>contact number</th>
                         <th>address</th>
                         <th>city</th>
                         </tr>
    </table>
    
                  
  </div>

</div>

<script>
    get_all_trash();
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

//trash admin
//add admin
$("#customer").delegate('#trashbtn','click',function(e){
        var email = $(this).attr("data-id");
        var question = confirm("Are you sure you want to delete this member?");
        var condition = 'trash_user';
        if(question){

             $.ajax({
            url: "ajax.class.php",
            type: "post",
            data: {method:condition, email:email},
            success: function (data) {
                alert(data);
            },
            error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert("error"+err.Message);
            }
        });

        }

   });

    function get_all_trash(){
       var condition = 'view_trash';
       $.ajax({
                url: "ajax.class.php",
                type: "post",
                data: {method:condition},
                success: function (data) {
                   // alert(data);
                    var arr = JSON.parse(data);
                    get_customer(arr);
                },
                error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert("error"+err.Message);
                }
        });

    }
    function get_customer(arr){
        var view_customer = '';
         $.each($(arr),function(key,prod){

                         view_customer += '<tr>';
                         view_customer += '<td>'+prod.first_name+' '+prod.last_name+'</td>';    
                         view_customer += '<td>'+prod.email+'</td>';        
                         view_customer += '<td>'+prod.contact_number+'</td>';  
                         view_customer += '<td>'+prod.address+'</td>';  
                         view_customer += '<td>'+prod.city+'</td>';   
                         view_customer += '</tr>'; 
        });
          $('#trash_customer').append(view_customer);
    }

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



