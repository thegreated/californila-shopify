$(".sweet-hide").on('click', function(i){
   var parents =  $(this);
   var productId = $(this).data("id");
    (function(){
        
        swal({title:"Are you sure to hide product ?",
        text:"The product will be hide on user dashboard !!",
        type:"warning",showCancelButton:!0,
        confirmButtonColor:"#DD6B55",
        confirmButtonText:"Yes, Hide it !!",
        cancelButtonText:"No, cancel it !!",
        closeOnConfirm:!1,
        closeOnCancel:!1
        },
        function(e){
            
            if(e){

                $.ajax({
                    url: "admin/ajax.controller.php",
                    type: "post",
                    data: {
                        method:'HIDE_PRODUCTS',
                        product_id : productId
                    },
                    success: function (data) {
                        
                        parents.parents('tr').css("background","#C2C2C2");
                        swal("Hidden !!","The product is successfully hide !!","success");
                        location.reload();

                    },
                    error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert("error"+err.Message);
                    }

                });

               
            }else{
                 swal("Cancelled !!","","error");
            }
        })
    
    })(i);
});


$(".sweet-unhide").on('click', function(i){
    var parents =  $(this);
    var productId = $(this).data("id");
     (function(){
         
         swal({title:"Are you sure to show product ?",
         text:"The product will be show on user dashboard !!",
         type:"warning",showCancelButton:!0,
         confirmButtonColor:"#DD6B55",
         confirmButtonText:"Yes, show it !!",
         cancelButtonText:"No, cancel it !!",
         closeOnConfirm:!1,
         closeOnCancel:!1
         },
         function(e){
             console.log(productId);
             if(e){
 
                 $.ajax({
                     url: "admin/ajax.controller.php",
                     type: "post",
                     data: {
                         method:'UNHIDE_PRODUCTS',
                         product_id : productId
                     },
                     success: function (data) {
                         parents.parents('tr').css("background","");
                         swal("Hidden !!","The product is successfully show !!","success");
                         location.reload();
                        
 
                     },
                     error: function(xhr, status, error) {
                     var err = eval("(" + xhr.responseText + ")");
                     alert("error"+err.Message);
                     }
 
                 });
 
                
             }else{
                  swal("Cancelled !!","","error");
             }
         })
     
     })(i);
 });
