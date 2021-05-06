


<hr>
<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10"><h1>Profile</h1></div>
    	<div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive" src="http://www.gravatar.com/avatar/28fd20ccec6865e2d5f0e1f4446eb7bf?s=100"></a></div>
    </div>
    <div class="row">
      <?php $people = new People(); 
      if(isset($_GET['view']) && $_GET['view']){
         $whosthis = $people->legit_find_id($_GET['id']);
       }else{
         $whosthis = $people->legit_find_id(returnID());
       }
         ?>
       
  		<div class="col-sm-3"><!--left col-->
    
          <ul class="list-group">
            <li class="list-group-item text-muted">Profile</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>First Name</strong>
            </span> 
             <b id="legit_fname"> <?php echo $whosthis->first_name;?></b>
            </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Last Name</strong></span>  
             <b id="legit_lname">  <?php echo $whosthis->last_name;?></b>
            </li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Email</strong></span>
              <?php echo $whosthis->email;?></li></li>
            
          </ul> 
       
          <div class="panel panel-default">
            <div class="panel-heading">Orders &nbsp;<i class="text-info"><b>< PENDING ></b></i></div>
            <div class="panel-body"><a href="http://bootnipets.com">bootnipets.com</a></div>
          </div>
          
          
          <ul class="list-group">
            <li class="list-group-item text-muted">Order History <i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Pending</strong></span>
              <?php echo get_count_pending(); ?></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Success</strong></span> 13</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Deny</strong></span> 37</li>
          </ul> 
               
          
        </div><!--/col-3-->

    	<div class="col-sm-9">
          
          <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#home" data-toggle="tab">Orders</a></li>
            <li><a href="#messages" data-toggle="tab">Messages</a></li>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
          </ul>
              
          <div class="tab-content">
            <div class="tab-pane active" id="home">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Transaction</th>
                      <th>Total</th>
                      <th>Payment Type</th>
                      <th>Status</th>
                      <th>Time & Date</th>
                       <th>Modify</th>
                       <th>Pay</th>
                    </tr>
                  </thead>
                  <tbody id="items">
                  <?php 
                   if(isset($_GET['view']) && $_GET['view']){
                     $cart_transaction = get_transactionDUP($_GET['id']);
                   }else{
                     $cart_transaction = get_transaction();
                   }

                  $count = 0;

                  for($es = 0 ; $es < count($cart_transaction); $es++){
                    $timestamp = strtotime($cart_transaction[$count]->date);
                    $date =  date("m/d/Y h:i", $timestamp);
                    $transaction = $cart_transaction[$count]->transaction_code;
                    $paymentID = $cart_transaction[$count]->paymentID ;
                    $payerID =  $cart_transaction[$count]->payerID ;
                    $token = $cart_transaction[$count]->token ;
                  ?>
                    <tr>
                      <td><?=$transaction ?></td>
                      <td>P<?=$cart_transaction[$count]->total ;  ?></td>
                      <td><?=$cart_transaction[$count]->payment_type;?>
                        <span class="badge badge-info">
                          <a href="#" style="color:white"> ? </a>
                        </span>
                      </td>
                       <td><?=$cart_transaction[$count]->status;?>
                        <span class="badge badge-info">
                          <a href="#" style="color:white"> ? </a>
                        </span>
                        </td>
                       <td><?=$date;    ?>
                         
                       </td>
                       <td> 
                      
                        <button type="button" id="myBtn" class="btn btn-primary" data-id="<?=$cart_transaction[$count]->transaction_code ?>"  style="font-size:5px;">VIEW</button> </td>
                         <td>
                        <?php if($cart_transaction[$count]->payment_type == "Paypal System"){?>
                        <?php if(condition_pay($paymentID,$payerID,$token)){ ?>
                        <b style="color:blue">Payed</b>
                            <?php }else{?>
                        <a href="paypalcheckout.php?transaction=<?=$transaction ?>" style="color:red">Pay Now</a>
                                   <?php }?>
                        <?php }else{?>
                                   <a href="contactus.php"> Visit now </a> 
                        <?php } ?>
                          </td>
                    </tr>
                  <?php
                  $count++;
                   }?>
                  </tbody>
                </table>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-md-offset-4 text-center">
                  	<ul class="pagination" id="myPager"></ul>
                  </div>
                </div>
              </div><!--/table-resp-->
              
              <hr>
              
             </div><!--/tab-pane-->
             <div class="tab-pane" id="messages">
               
               <h2></h2>
               
               <ul class="list-group">
                  <li class="list-group-item text-muted">Inbox</li>
                  <li class="list-group-item text-right"><a href="chatbox/" class="pull-left">Click here to visit message</a> v0.1</li>
                  
                </ul> 
               
             </div><!--/tab-pane-->
             <div class="tab-pane" id="settings">
                  <hr>
                  <style type="text/css">
                    .form-group{
                      margin-top:20px;
                    }
                  </style>
                    <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="first_name"><h4>First name</h4></label>
                              <input type="text" class="input" name="first_name"  placeholder="first name" value="<?=$whosthis->first_name;?>" >
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                            <label for="last_name"><h4>Last name</h4></label>
                              <input type="text" class="input" name="last_name"  placeholder="last name"  value="<?=$whosthis->last_name;?>" >
                          </div>
                      </div>
            
      
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <br/>
                              <label for="phone"><h4>Contact Number</h4></label>
                              <input type="text" class="input" name="contact_number" placeholder="Contact Number ex:09123456789"  value="<?=$whosthis->contact_number;?>">
                          </div>
                      </div>
          
                      <div class="form-group">
                          <div class="col-xs-6">
                              <br/>
                             <label for="mobile"><h4>Address</h4></label>
                              <input type="text" class="input" name="address"  placeholder="Address" value="<?=$whosthis->address;?>">
                          </div>
                      </div>

                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <br/>
                              <label for="email"><h4>City</h4></label>
                              <input type="text" class="input" name="city"  placeholder="City" value="<?=$whosthis->city;?>">
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <br/>
                              <label for="email"><h4>Zip code</h4></label>
                              <input type="text" class="input" name="zip_code" placeholder="Zip code" value="<?=$whosthis->zip_code;?>">
                              <input type="hidden" name="email" value="<?=$whosthis->email;?>" />
                              <input type="hidden" name="member_id" value="<?=returnID();?>" />
                              <input type="hidden" name="password" value="<?=$whosthis->password;?>" />
                              <input type="hidden" name="activation_code" value="<?=$whosthis->activation_code;?>" />
                              <input type="hidden" name="activated" value="<?=$whosthis->activated;?>" />
                          </div>
                      </div>
                      <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                              	<button id="update_profile" class="btn btn-lg btn-success" type="submit"></i> Update Information</button>
                                <b id="sucess_info"></b>
                            </div>
                      </div>
              </div>
               
              </div><!--/tab-pane-->
          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->
    <hr/>   
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <table class="table table-hover" id="cart_view"><style> td{align:left;}</style>
    </table>
  </div>

</div>
<style type="text/css">
  /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
    <script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
$("#items").delegate('#myBtn,#myBtn2','click',function(e){
  $("#myModal").css('display','block');
  var e = $(this).data("id");
  var condition = 'view_product';
  var transac_id = $(this).data("id");
  $.ajax({
      url: "ajax_product_cart.php",
      type: "post",
      data: { method:condition,transac:transac_id},
      success: function (data) {
          //console.log(data);
          var arr = JSON.parse(data);
          get_name_image(arr); 
       }
    });

});
//get name image in profile product view
function get_name_image(viewcharts){
  
   $.each($(viewcharts),function(key,val){
     var viewcart = '';
     var condition = 'get_name_image';
     var price     =  val.price;
     var quantity  =  val.quantity;
     var prod     =  val.productID;

     $.ajax({
        url: "ajax_product_cart.php",
        type: "post",
        data: { method:condition,product:prod},
        success: function (data) {
             var arr = JSON.parse(data);

               $.each($(arr),function(key,prod){
                  var name     = prod.name; 
                  var location = prod.location;
                  var loc      = location.split(',');
                  var prod     =  val.productID;
                  console.log(prod);
                     viewcart += '<tr>';
                     viewcart += '<td><img src="themefiles/img/products/main/pic/'+loc[0]+'"  height="50px"; /></td>';
                     viewcart += '<td><a href="product-page.php?id='+prod+'" id="prod_name">'+name+'</a></td>';
                     viewcart += '<td>P '+price+'</td>';
                     viewcart += '<td>'+quantity+'</td>';
                     viewcart += '</tr>';
                    
                  
        }); 
        $('#cart_view').append(viewcart);
                   
        }

      });

                
       console.log(viewcart);
    $('#cart_view').html(viewcart);
   });
    
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }

}
  function update_profile(){

  }
  $("#settings").delegate('#update_profile', "click", function() {    
    var fname           =  $("input[name=first_name]").val();
    var lname           =  $("input[name=last_name]").val();
    var cnumber         =  $("input[name=contact_number]").val();
    var address         =  $("input[name=address]").val();
    var city            =  $("input[name=city]").val();
    var zip_code        =  $("input[name=zip_code]").val();
    var email           =  $("input[name=email]").val();
    var ids             =  $("input[name=member_id]").val();
    var password        =  $("input[name=password]").val();
    var activation_code =  $("input[name=activation_code]").val();
    var activated       =  $("input[name=activated]").val();


    var data = 'update_profile';
    var profile_update = { 
          id: ids,
          first_name:fname,
          last_name:lname,
          email:email,
          address:address,
          city:city,
          zip_code:zip_code,
          contact_number:cnumber
          
    }
    console.log(profile_update);
     $.ajax({
                    url: "ajax_product_cart.php",
                    type: "post",
                    data: {update:profile_update,datas:data},
                    success: function (ord) {
                      $('#legit_fname').html(fname);
                      $('#legit_lname').html(lname);
                      $('#sucess_info').html('data is already updated');
                    },
                    error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert("error"+err.Message);
              }
          });
  });
</script>                               