<?php  require_once('../admin/initialize.php'); 
       //require_login_redirect_controller();
       include(ADMIN_SHARED . '/header_admin.php');
        $page = 'order';
        include(ADMIN_SHARED . '/menu_admin.php');?>


        <div class="content-wrapper">
        <div class="container">
            <div class="row">
                    <h4 class="page-head-line">List of Order by customer</h4>
                    <b style="color:red" id="errors"> </b>
                    	<br/>
                    	<br/>
					<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                          <th>Transaction</th>
                                          <th>Total</th>
                                          <th>Payment Type</th>
                                          <th>Status</th>
                                          <th>Time & Date</th>
                                          <th>Payed</th>
                                           <th>Modify</th>
                                        </tr>
                                    </thead>
                                     <tbody id="items">
                                          <?php $cart_transaction = get_all_transaction_data();
                                          $count = 0;

                                          for($es = 0 ; $es < count($cart_transaction); $es++){
                                            $timestamp = strtotime($cart_transaction[$count]->date);
                                            $date =  date("m/d/Y h:i", $timestamp);
                                          ?>
                                            <tr>
                                              <td><?=$cart_transaction[$count]->transaction_code ?></td>
                                              <td>P<?=$cart_transaction[$count]->total ;  ?></td>
                                              <td><?=$cart_transaction[$count]->payment_type ;  ?></td>
                                               <td><select class="form-control" id="status">
                                                    <option><?=$cart_transaction[$count]->status;?></option>
                                                    <option>PENDING</option>
                                                    <option>REJECT</option>
                                                    <option>CANCEL</option>
                                                    <option>SUCCESS</option>
                                                  </select>
                                            </td>
                                               <td><?=$date;    ?></td>
                                               <td>
                                              <?php if($cart_transaction[$count]->paymentID != ''){?>
                                              <i class="glyphicon glyphicon-ok" style="color:blue"></i>
                                              <?php }else{ ?>
                                              <i class="glyphicon glyphicon-remove" style="color:red"></i>
                                              <?php } ?>
                                              </td>
                                               <td> 
                                                <button type="button" id="myBtn" class="btn btn-primary" data-id="<?=$cart_transaction[$count]->transaction_code ?>"  >VIEW</button>
                                                <button type="button" id="myBtn2" class="btn btn-success" data-id="<?=$cart_transaction[$count]->memberID ?>"  >VIEW CUSTOMER</button>
                                                <button type="button" id="myBtn3" class="btn btn-warning" data-id="<?=$cart_transaction[$count]->transaction_code ?>"  >UPDATE</button>
                                            <?php if($cart_transaction[$count]->payment_type == 'Visit the shop'){?>
                                                <button type="button" id="myBtn4" class="btn btn-info" data-id="<?=$cart_transaction[$count]->transaction_code ?>"  >PAID</button>
                                            <?php } ?>
                                                 </td>

                                            </tr>
                                          <?php
                                          $count++;
                                           }?>
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
    <table class="table table-hover" id="cart_view"><style> td{align:left;}</style>
        <tr>
        <th> image </th>
        <th> name </th>
        <th> price </th>
        <th> qty </th>
        </tr>
    </table>
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
//viewing cart
$("#items").delegate('#myBtn','click',function(e){
      $("#myModal").css('display','block');
      var e = $(this).data("id");
      var condition = 'view_product';
      var transac_id = $(this).data("id");
      $.ajax({
          url: "../ajax_product_cart.php",
          type: "post",
          data: { method:condition,transac:transac_id},
          success: function (data) {
              //console.log(data);
              var arr = JSON.parse(data);
              get_name_image(arr); 
           }
        });

    });
//view customer
$("#items").delegate('#myBtn2','click',function(e){
     $("#myModal").css('display','block');
     $('#cart_view').html('');
      var condition = 'view_customer';
      var viewid = $(this).data("id");

       $.ajax({
          url: "ajax.class.php",
          type: "post",
          data: { method:condition,viewid:viewid},
          success: function (data) {
             var arr = JSON.parse(data);
             get_customer(arr);
           }
        });
});

//update transaction
$("#items").delegate('#myBtn3','click',function(e){
      var condition = 'update_transac';
      var update_transac = $(this).data("id");
      var status = $(this).parent().parent().find('option:selected').text();

       $.ajax({
          url: "ajax.class.php",
          type: "post",
          data: { method:condition,status:status,update_transac:update_transac},
          success: function (data) {
                $('#errors').html('Successfully save the data');
           }
        });
});

//update payed
$("#items").delegate('#myBtn4','click',function(e){
      var condition = 'update_payed';
      var update_transac = $(this).data("id");
      var question = confirm("Are you sure you want update this transaction as payed?");
      var paymentID = '1928';
      var payerID = '1928';
      var token = '1928';

      if(question){
       $.ajax({
          url: "ajax.class.php",
          type: "post",
          data: { method:condition,paymentID:paymentID,payerID:payerID,token:token,update_transac:update_transac},
          success: function (data) {
                $('#errors').html('Successfully save the data');
           }
        });
     }
});


//view cart
function get_name_image(viewcharts){
  
   $.each($(viewcharts),function(key,val){
     var viewcart = '';
     var condition = 'get_name_image';
     var price     =  val.price;
     var quantity  =  val.quantity;
     var prod     =  val.productID;

     $.ajax({
        url: "../ajax_product_cart.php",
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
                     viewcart += '<td><img src="../themefiles/img/products/main/pic/'+loc[0]+'"  height="50px"; /></td>';
                     viewcart += '<td><a href="../product-page.php?id='+prod+'" id="prod_name">'+name+'</a></td>';
                     viewcart += '<td>P '+price+'</td>';
                     viewcart += '<td>'+quantity+'</td>';
                     viewcart += '</tr>';
                    
                  
        }); 

        $('#cart_view').append(viewcart);
                   
        }

      });

                

   });   
}
function get_customer(arr){
    var view_customer = '';
     $.each($(arr),function(key,prod){
                     view_customer += '<tr>';
                     view_customer += '<th>name</th>';
                     view_customer += '<th>email</th>';
                     view_customer += '<th>contact number</th>';
                     view_customer += '<th>address</th>';
                     view_customer += '<th>city</th>';
                     view_customer += '<th>modify</th>';
                     view_customer += '</tr>';
                     view_customer += '<td>'+arr.first_name+' '+arr.last_name+'</td>';    
                     view_customer += '<td>'+arr.email+'</td>';        
                     view_customer += '<td>'+arr.contact_number+'</td>';  
                     view_customer += '<td>'+arr.address+'</td>';  
                     view_customer += '<td>'+arr.city+'</td>';   
                     view_customer += '<td> <a href="../profile.php?view=true&id='+arr.id+'" class="btn btn-primary" >View Profile</a></td>'; 
                     view_customer += '</tr>'; 
    });
      $('#cart_view').append(view_customer);
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



