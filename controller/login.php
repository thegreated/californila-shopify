<?php  require_once('../admin/initialize.php'); 
       include(ADMIN_SHARED . '/header_admin.php');
        //require_login_redirect_controller();

    if(returnID_controller() != ''){
        redirect_to(url_for('controller/admin.php'));
    }
    if(is_post_request()) {

      $args = $_POST['admin'];
       $admin = new Admin();
       $results = $admin->login();
    }

        ?>


    <!-- LOGO HEADER END-->
   
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Please Login To Enter </h4>

                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <hr />
                     <h4>Login with <strong>Zontal Account  :</strong></h4>
                     <?php echo returnID_controller(); ?>
                    <b id="erorrs" style="color:red"> </b> 
                    <br />
                        <label>Username : </label>
                        <input type="text" name='admin[username]' class="form-control" />
                        <label>Password :  </label>
                        <input type="password"  name='admin[password]' c class="form-control" />
                        <hr />
                        <button id="login_admin" href="index.html" class="btn btn-info"><span class="glyphicon glyphicon-user"></span> &nbsp;Log Me In </a>&nbsp;
                        
                </div>
                <div class="col-md-6">
                    <div class="alert alert-info">
                        This is a free bootstrap admin template with basic pages you need to craft your project. 
                        Use this template for free to use for personal and commercial use.
                        <br />
                         <strong> Some of its features are given below :</strong>
                        <ul>
                            <li>
                                Responsive Design Framework Used
                            </li>
                            <li>
                                Easy to use and customize
                            </li>
                            <li>
                                Font awesome icons included
                            </li>
                            <li>
                                Clean and light code used.
                            </li>
                        </ul>
                       
                    </div>
                    <div class="alert alert-success">
                         <strong> Instructions To Use:</strong>
                        <ul>
                            <li>
                               Lorem ipsum dolor sit amet ipsum dolor sit ame
                            </li>
                            <li>
                                 Aamet ipsum dolor sit ame
                            </li>
                            <li>
                               Lorem ipsum dolor sit amet ipsum dolor
                            </li>
                            <li>
                                 Cpsum dolor sit ame
                            </li>
                        </ul>
                       
                    </div>
                </div>

            </div>
        </div>
    </div>
<script>
      $("#login_admin").click(function(){
        var condition = 'login_admin';
        var username = $("input[name='admin[username]']").val();
        var password = $("input[name='admin[password]']").val();
        var data = {
            username:username,
            password:password
        }
        ajax_method(condition,data);
      });

    function ajax_method(condition,datas){

         $.ajax({
            url: "ajax.class.php",
            type: "post",
            data: {method:condition, arr:datas},
            success: function (data) {
               show_error('erorrs',data.trim());
                
            },
            error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert("error"+err.Message);
            }
        });

    }
    function show_error(id,message){
        if(message == 'false'){
            $('#'+id).html('Username or password must be incorrect');
        }else{
            var url = window.location;
            window.location = url + "/admin.php";
        }


    }
</script>
    <?php  include(ADMIN_SHARED . '/footer_admin.php'); ?>
    