
<?php require_once('admin/initialize.php');
    if(isset($_GET['customer']) || $_GET['customer'] != ''){
        
        $customerId = $_GET['customer'];
        $args['id'] = $customerId;
        $product = new Shopify();
        $count = $product->productCount($customerId);
        $args['condition'] = 'SELECT_ONE_CUSTOMER';
        $data_table = new Data_table($args);
        $customerData = $data_table->mainGenerator();
        $customerAddress = '';
        foreach($customerData['customer']['addresses'] as $customerAd){
            if($customerAd['default']){
               $customerAddress = $customerAd['address1'].' '.$customerAd['address2'].' '.$customerAd['city'].' '.$customerAd['province'].' '.$customerAd['country'].' '.$customerAd['zip'];

            }
        }
       
    }else{
      
        header('Location: '.CURRENTLINK);
    }
?>



<?php include(SHARED_PATH . '/public_header.php'); ?>


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

     
        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content clearfix">
                
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
             
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-email-outline"></i>
                                <!-- <span class="badge gradient-1 badge-pill badge-primary">3</span> -->
                            </a>
                            <!-- <div class="drop-down animated fadeIn dropdown-menu">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">3 New Messages</span>  
                                    
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/1.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Saiful Islam</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/2.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Adam Smith</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Can you do me a favour?</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/3.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Barak Obama</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="float-left mr-3 avatar-img" src="images/avatar/4.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Hilari Clinton</div>
                                                    <div class="notification-timestamp">08 Hours ago</div>
                                                    <div class="notification-text">Hello</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div> -->
                        </li>
                        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                                <!-- <span class="badge badge-pill gradient-2 badge-primary">3</span> -->
                            </a>
                            <!-- <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">2 New Notifications</span>  
                                    
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events near you</h6>
                                                    <span class="notification-text">Within next 5 days</span> 
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Started</h6>
                                                    <span class="notification-text">One hour ago</span> 
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Ended Successfully</h6>
                                                    <span class="notification-text">One hour ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events to Join</h6>
                                                    <span class="notification-text">After two days</span> 
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div> -->
                        </li>
                     
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php include(SHARED_PATH . '/public_navigation.php'); ?>	
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
        <?php if(!isset($_GET['product'])){ ?>
                <div class="col-lg-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="media align-items-center mb-4">
                                   <!-- <img class="mr-3" src="#" width="80" height="80" alt=""> -->
                                    <div class="media-body">
                                        <h3 class="mb-0"><?=$customerData['customer']['first_name']?> <?=$customerData['customer']['last_name']?> </h3>
                                        <p class="text-muted mb-0">#</p>
                                    </div>
                                </div>
                                
                                <div class="row mb-5">
                                    <div class="col">
                                        <div class="card card-profile text-center">
                                            <span class="mb-1 text-primary"><i class="icon-social-dropbox"></i></span>
                                            <h3 class="mb-0"><?=$count ?></h3>
                                            <p class="text-muted px-4">Warehouse</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card card-profile text-center">
                                            <span class="mb-1 text-warning"><i class="icon-paper-plane"></i></span>
                                            <h3 class="mb-0">0</h3>
                                            <p class="text-muted">Sent Package</p>
                                        </div>
                                    </div>
                                     <div class="col-12 text-center">
                                        <button class="btn btn-danger px-5"  type="button" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add Product</button>
                                    </div> 
                                </div>
              
                                <h4>Default Address </h4>
                                <p class="text-muted"><?=$customerAddress?></p>
                                <ul class="card-profile__info">
                                    <li class="mb-1"><strong class="text-dark mr-4">Mobile</strong> <span><?=$customerData['customer']['phone']?></span></li>
                                    <li><strong class="text-dark mr-4">Email</strong> <span><?=$customerData['customer']['email']?></span></li>
                                </ul>
                            </div>
                        </div>  
                    </div>

                    <div class="col-8">
                    <div class="success-info"></div>
                    <?php if(isset($_GET['success'])){ ?>
                    <div class="alert alert-primary __web-inspector-hide-shortcut__"><strong>Successfully </strong> save the Product!</div>
                    <?php } ?>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">List of Product on Warehouse</h4> 
                                <div class="table-responsive">
                                  <?php
                                  
                                    $args['id'] = $customerId;
                                    $args['condition'] = 'SELECT_PRODUCT_SHOPIFY';
                                    $data_table = new Data_table($args);
                                    $data = $data_table->sqlGenerator();
                                    echo $data;
                                 
                                      
                                  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">List of Package sent</h4>
                                <div class="table-responsive">
                                  <?php
                                    //   $args['condition'] = "SELECT_CUSTOMER";
                                    //   $data_table = new Data_table($args);
                                    //   $data = $data_table->mainGenerator();

                                      
                                  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
         <?php }else if(isset($_GET['product'])){    
                $productView = $product->legit_find_id($_GET['product']);  
                include(STAFF_PATH.'//products/view.php');
          } ?>
            </div>
            <!-- #/ container -->
           </div>
        <!--**********************************
            Content body end
        ***********************************-->
        <!-- Modal -->
     
        <?php include(STAFF_PATH . '/products/new.php'); ?>	
        <?php include(STAFF_PATH . '/products/edit.php'); ?>	
        <!-- Modal End -->
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
 

    
    
<?php include(SHARED_PATH . '/public_footer.php'); ?>	
<script src="themefiles/js/jquery.validate-init.js"></script>
<script src="themefiles/plugins/sweetalert/js/sweetalert.min.js"></script>
    <script src="themefiles/js/sweet.js"></script>
    

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>


  <script type="text/javascript">

$(document).on("click", ".editProductBtn", function(event){
      clearProduct();
       var product_id =  $(this).data('id');
       
       $.ajax({
                url: "admin/ajax.controller.php",
                type: 'post',
                data: {
                    method: 'SHOW_EDIT_PRODUCTS_SHOPIFY',
                    product_id: product_id
                },
                success: function (data) {
                console.log(data)
                var parsed_data = JSON.parse(data);
                $('#edit-val-pid').val(product_id);
                $('#edit-val-warehouse').val(parsed_data.warehouse_id);
                $('#edit-val-service_type').val(parsed_data.service_type);
                $('#edit-val-merchant').val(parsed_data.merchant_info);
                $('#edit-val-weight').val(parsed_data.weight);
                $('#edit-val-lenght').val(parsed_data.lenght);
                $('#edit-val-width').val(parsed_data.width);
                $('#edit-val-height').val(parsed_data.height);
                $('#edit-val-quantity').val(parsed_data.qty);
                $('#edit-val-value').val(parsed_data.value);
                $('#edit-val-status').val(parsed_data.status);
                $('#edit-val-description').val(parsed_data.description);
                $('#edit-val-package_type').val(parsed_data.package_type);
                $('.loading_saving_product').css("display", "none");  
                if(parsed_data.imagesList != ""){
                    var images = parsed_data.imagesList.split(','); 
                    console.log(images)
                    for(var i = 0 ; i < images.length;i++){
                        $('#editimage_preview').append("<img src='."+parsed_data.imagesLocation+""+images[i]+"' height='150px'>");
                    }
                }
                },
                error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert("error"+err.Message);
                }
            });

});
  

  $("#uploadFile").change(function(){
     $('#image_preview').html("");
     var total_file=document.getElementById("uploadFile").files.length;
     for(var i=0;i<total_file;i++)
     {
        $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' height='150px'>");
     }
  });
  $("#edituploadFile").change(function(){
     $('#editimage_preview').html("");
     var total_file=document.getElementById("edituploadFile").files.length;
     for(var i=0;i<total_file;i++)
     {
        $('#editimage_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' width='150px'>");
     }
  });

  function clearProduct(){
        $('#editimage_preview').html('');
        $('.loading_saving_product').css("color", "red");
        $('.loading_saving_product').css("display", "block");  
        $('#edit-val-pid').val('');
        $('#edit-val-warehouse').val('');
        $('#edit-val-service_type').val('');
        $('#edit-val-merchant').val('');
        $('#edit-val-weight').val('');
        $('#edit-val-lenght').val('');
        $('#edit-val-width').val('');
        $('#edit-val-height').val('');
        $('#edit-val-quantity').val('');
        $('#edit-val-value').val('');
        $('#edit-val-status').val('');
        $('#edit-val-description').val('');
  }


</script>

    </body>

</html>
<?php exit(); ?>

