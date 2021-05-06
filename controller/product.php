<?php  require_once('../admin/initialize.php'); 
      //  require_login_redirect_controller();
       include(ADMIN_SHARED . '/header_admin.php');
        $page = 'product';
        include(ADMIN_SHARED . '/menu_admin.php');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Product  <a class="btn btn-primary" href="productadd.php">ADD</a></h4>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                     <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Picture</th>
                                            <th>Name</th>
											<th>Price</th>
											<th>Sale</th>
											<th>Category</th>
                                            <th>Qty</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product_list">
									<?php
									ini_set('display_errors', 1);
									ini_set('display_startup_errors', 1);
									error_reporting(E_ALL);

										  $product = new Product(); 
										  $all_product = $product->find_all();
										  foreach($all_product as $prod) {
											  $myString =  $prod->location;
										      $myArray = explode(',', $myString); 
											  ?>
										 
                                        <tr>
                                            <td id="product_id"><?php echo $prod->ownder_id; ?> </td>
                                            <td><img src="<?php echo '../themefiles/img/products/main/pic/'.$myArray[0]; ?>" height="80px"  /></td>
                                            <td><?php echo $prod->name; ?></td>
											<td>P<?php echo $prod->price; ?></td>
											<td>P<?php echo $prod->sale_price; ?></td>
                                            <td><?php echo $prod->category; ?></td>
											<td><?php echo $prod->quantity; ?></td>
                                            <td>
											<button type="button" id="myBtn" class="btn btn-primary" data-id="<?=$prod->ownder_id ?>">View</button>
											<button type="button" id="myBtn2" class="btn btn-success" data-id="<?=$prod->ownder_id ?>">Edit</button>
											<button type="button" id="myBtn3" class="btn btn-danger"  data-id="<?=$prod->ownder_id ?>">Delete</button>
											</td>
                                        </tr>
										  <?php  } ?>
                                       
                                    </tbody>
                                </table>
                </div>

            </div>
        </div>
    </div>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content" id="modal_content">
    <span class="close">&times;</span>
    <p>Some text in the Modal..</p>
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
$("#product_list").delegate('#myBtn,#myBtn2,#myBtn3','click',function(e){
     var condition = 'view_product_admin';
     var transac_id = $(this).data("id");
     var condition = $(this).attr("id");

     if(condition == 'myBtn3'){
        ConfirmDialog('Are you sure',transac_id);
     }else if(condition == 'myBtn2'){
       
       $("#myModal").css('display','block');
        $("#modal_content").html(edit_peoduct());

     }else if(condition == 'myBtn'){
         alert('view');
     }
    //$("#myModal").css('display','block');

    //  $.ajax({
    //   url: "ajax.class.php",
    //   type: "post",
    //   data: { method:condition,transac:transac_id},
    //   success: function (data) {
    //       console.log(data);
    //       var arr = JSON.parse(data);
    //       console.log(arr);
    //    }
    // });
});

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

function ConfirmDialog(message,transac_id) {
   var del = confirm("Are you sure you want to delte this data?!");
   var condition = 'view_product_admin';
   //alert(transac_id);
   if(del){

     $.ajax({
      url: "ajax.class.php",
      type: "post",
      data: { method:condition,transac:transac_id},
      success: function (data) {
            var trash_data = data;
            //console.log(trash_data);
            save_trash_data(trash_data,transac_id);
       }

    });

   }else{
    alert('Good decision');
   }
}

//--edit method
function edit_product(){
               var edit =' <div class="container"><form method="post">';
                   edit += '<div class="section-title">';
                   edit += '<h3 class="title">Edit Product</h3>';
                   edit +='</div>';
                   edit +='<div class="form-group">';
                   edit +=   '<input class="input" type="text" name="product[name]" placeholder="name">';
                   edit += '</div>';
                   edit +=  ' <div class="form-group">';
                  edit +=    ' <input class="input" type="text" name="person[description]" placeholder="description">';
                  edit += '</div>';
                edit += '<div class="form-group">';
               edit +=   '  <input class="input" type="email" name="person[category]" placeholder="category">';
              edit += ' </div>';
              edit += ' <div class="form-group">';
               edit +=    ' <input class="input" type="text" name="person[originated]" placeholder="originated">';
               edit +=' </div>';
               edit +=' <div class="form-group">';
               edit +='     <input class="input" type="text" name="person[price]" placeholder="price">';
               edit +=' </div>';
               edit +=' <div class="form-group">';
               edit +='     <input class="input" type="text" name="person[sale_price]" placeholder="sale_price">';
               edit +=' </div>';
               edit +=' <div class="form-group">';
               edit +='     <input class="input" type="number" name="person[quantity]" placeholder="quantity">';
               edit +=' </div>';
               edit +=' <div class="form-group">';
               edit +='     <input class="input" type="password" name="person[location]" placeholder="location">';
               edit +=' </div>';
               edit +=' <div class="form-group">';
               edit +='     <input class="input" type="password" name="person[thumb_location]" placeholder="thumb_location">';
               edit +=' </div>';
              edit +='  <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Sign Up</button></div>
                edit +='</form> </div>';
        return edit;
}

//------- delete method
function delete_product(id){
    var condition = 'trash_product';

     $.ajax({
      url: "ajax.class.php",
      type: "post",
      data: { method:condition,transac:id},
      success: function (data) {
          console.log('success fully delete product');
          console.log(data);
       }

    });
 }
function save_trash_data(data,id){
    var arr = JSON.parse(data);
    var condition = 'save_trash_product';

     $.ajax({
      url: "ajax.class.php",
      type: "post",
      data: { method:condition,transac:id,arrays:arr},
      success: function (data) {
         // alert('success fully delete product');
          console.log('success add product to trash');
          delete_product(id);
       }

    });
}
</script>


    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; 2015 YourCompany | By : <a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap</a>
                </div>

            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
