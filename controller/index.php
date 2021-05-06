<?php  require_once('../admin/initialize.php'); 
    //   require_login_redirect_controller();
       include(ADMIN_SHARED . '/header_admin.php');
        $page = 'index';
        include(ADMIN_SHARED . '/menu_admin.php');
        $admin = new admin();
        $order = new order();
        $product = new product();
        $review = new review();
        $count_data = $order->get_all_transaction_data_admin();
        $count_product = $product->find_all();
        $count_review = $review->find_all();

        ?>

    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Dashboard</h4>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                       <!--  This is a simple admin template that can be used for your small project or may be large projects. This is free for personal and commercial use. -->
                    </div>
                </div>

            </div>
            <div class="row">
                 <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-venus dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
  </div>
                           
</div>
                         <h5>Total order <h4><?php echo  count($count_data);  ?></h4> </h5>
                    </div>
                </div>
                 <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-two">
                        <i  class="fa fa-edit dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
  </div>
                           
</div>
                         <h5>Total User<h4> <?=$admin->get_total_user()->total;?></h4>
                             
                         </h5>
                    </div>
                </div>
                 <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-three">
                        <i  class="fa fa-cogs dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
  </div>
                           
</div>
                         <h5>Total Product <h4><?=count($count_product); ?></h4> </h5>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-four">
                        <i  class="fa fa-bell-o dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
  </div>
                           
</div>
                         <h5>Total Comments <h4><?=count($count_review); ?> </h4></h5>
                    </div>
                </div>

            </div>
           
            <div class="row">
                <div class="col-md-6">
                      <div class="notice-board">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                             Recent <b>Transaction</b> Activity of Users
                            </div>
                            <div class="panel-body">
                                <ul id="activity">
                                  
  
                                </ul>
                            </div>
                            <div class="panel-footer">
                                <button id="refresh_activity"  class="btn btn-default btn-block"> <i class="glyphicon glyphicon-repeat"></i> Refesh</button>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center  alert-warning">
                      <br/>
                       <h4>List of item that have <b style="color:red">low stock</b></h4>
                       <br/>
                    </div>
                     
                    <hr />
                     <div class="table-responsive">
                      <?php 
                          $product = new product();
                          $critical_state = $product->product_critical_qty();
                         
                      ?>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Qty</th>
                                            <th># #</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach ($critical_state as $key) { ?>
                                        <tr>
                                            <td><a href="../product-page.php?id=<?=$key->ownder_id?>"><?=$key->name?></a></td>
                                            <td>
                                                 <label class="label label-info">P<?=$key->sale_price?></label>
                                            </td>
                                            <td>
                                                <label class="label label-success"><?=$key->quantity?></label>
                                            </td>           
                                             <td> <a href="#"  class="btn btn-xs btn-danger"  >View</a> </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-danger">
                      <!--   This is a simple admin template that can be used for your small project or may be large projects. This is free for personal and commercial use. -->
                    </div>
                    <hr />
                     <div class="Compose-Message">               
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Compose New Message 
                    </div>
                    <div class="panel-body">
                        
                        <label>Enter Recipient Name : </label>
                        <input type="text" class="form-control" />
                        <label>Enter Subject :  </label>
                        <input type="text" class="form-control" />
                        <label>Enter Message : </label>
                        <textarea rows="9" class="form-control"></textarea>
                        <hr />
                        <a href="#" class="btn btn-warning"><span class="glyphicon glyphicon-envelope"></span> Send Message </a>&nbsp;
                      <a href="#" class="btn btn-success"><span class="glyphicon glyphicon-tags"></span>  Save To Drafts </a>
                    </div>
                    <div class="panel-footer text-muted">
                        <strong>Note : </strong>Please note that we track all messages so don't send any spams.
                    </div>
                </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){

      show_transaction_activity();

      function show_transaction_activity(){

            var condition = 'show_transaction_activity';
            $.ajax({
              url: "ajax.class.php",
              type: "post",
              data: { method:condition},
              success: function (data) {
               var arr = JSON.parse(data);
               var is = 0;
               console.log(data[0].length+'');
               console.log(arr[0].length+'');
                $('#activity').html('');
                
                for(is = 0; is < arr[0].length; is++){
                      
                      var data  =   '<li>';
                      data +=   '<a href="#">';
                      data +=   '<span class="glyphicon glyphicon-user" ></span> ';
                      data +=   '<label class="label label-success">'+arr[1][is]+'</label> buy item that has total of  <label class="label label-info"> P'+arr[0][is]+'</label>';
                      data +=   '<span class="label label-warning" >'+arr[2][is]+' </span>';
                      data +=   '</a></li>';
                      $('#activity').append(data);
                }
           }
        });
      }
      $("#refresh_activity").click(function(){
        show_transaction_activity();
      });
      
    });

    </script>
    <?php  include(ADMIN_SHARED . '/footer_admin.php'); ?>
