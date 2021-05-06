jQuery(".form-valide").validate({
    ignore:[],
    errorClass:"invalid-feedback animated fadeInDown",
    errorElement:"div",
    errorPlacement:function(e,a){

    jQuery(a).parents(".form-group > div").append(e)},
        highlight:function(e){
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")},
        success:function(e){jQuery(e).closest(".form-group").removeClass("is-invalid"),jQuery(e).remove()},
        rules:{
            "val-warehouse":{required:!0},
            "val-service_type":{required:!0},
            "val-merchant":{required:!0},
            "val-weight":{required:!0,number:!0},
            "val-lenght":{required:!0,number:!0},
            "val-width":{required:!0,number:!0},
            "val-height":{required:!0,number:!0},
            "val-quantity":{required:!0,number:!0},
            "val-description":{required:!0},
            "val-status":{required:!0},
            "val-package_type":{required:!0},
        },

        messages:{
            "val-warehouse":"Please select a warehouse!",
            "val-service_type":"Please select a service type!",
            "val-merchant":"Please select a merchant?",
            "val-weight":"Please select a weight!",
            "val-lenght":"Please enter a lenght!",
            "val-width":"Please enter a width!",
            "val-height":"Please enter a height!",
            "val-quantity":"Please enter only number!",
            "val-description":"Please enter a description!",
            "val-status":"Please enter a status!",
            "val-package_type":"Please enter a package type!",
        },


        submitHandler: function(form) {
            $('.loading_saving_product').css("display", "block");  
            //get form
            save_data('ADD_PRODUCT');
            return false;
        }
    
    
    });

    jQuery(".edit-form-valide").validate({
        ignore:[],
        errorClass:"invalid-feedback animated fadeInDown",
        errorElement:"div",
        errorPlacement:function(e,a){
    
            jQuery(a).parents(".form-group > div").append(e)},
                highlight:function(e){
                jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")},
                success:function(e){jQuery(e).closest(".form-group").removeClass("is-invalid"),jQuery(e).remove()},
                rules:{
                    "edit-val-warehouse":{required:!0},
                    "edit-val-service_type":{required:!0},
                    "edit-val-merchant":{required:!0},
                    "edit-val-weight":{required:!0,number:!0},
                    "edit-val-lenght":{required:!0,number:!0},
                    "edit-val-width":{required:!0,number:!0},
                    "edit-val-height":{required:!0,number:!0},
                    "edit-val-quantity":{required:!0,number:!0},
                    "edit-val-description":{required:!0},
                    "edit-val-status":{required:!0},
                    "edit-val-package_type":{required:!0},
                },
    
                messages:{
                    "edit-val-warehouse":"Please select a warehouse!",
                    "edit-val-service_type":"Please select a service type!",
                    "edit-val-merchant":"Please select a merchant?",
                    "edit-val-weight":"Please select a weight!",
                    "edit-val-lenght":"Please enter a lenght!",
                    "edit-val-width":"Please enter a width!",
                    "edit-val-height":"Please enter a height!",
                    "edit-val-quantity":"Please enter only number!",
                    "edit-val-description":"Please enter a description!",
                    "edit-val-status":"Please enter a status!",
                    "edit-val-package_type":"Please enter a Package type!",
                    
                },
    
    
                submitHandler: function(form) {
                    $('.loading_saving_product').css("display", "block");  
                    //get form
                    save_data('EDIT_PRODUCT');
                    return false;
                }
            
            
            });

function save_data($condition){
    var value = '';
    var imgvalue = '';
    var form_data = new FormData();
    if($condition == "ADD_PRODUCT"){
        value = 'val-';
    }else{
        value = 'edit-val-';
        imgvalue= 'edit';
        form_data.append('product_id',$('#edit-val-pid').val());
    }

    // Read selected files
    var totalfiles = document.getElementById(imgvalue+'uploadFile').files.length;
    if(totalfiles != 0){
        for (var index = 0; index < totalfiles; index++) {
            console.log(document.getElementById(imgvalue+'uploadFile').files[index]);
            form_data.append("files[]", document.getElementById(imgvalue+'uploadFile').files[index]);
        }
    }       

    form_data.append('customer_id',$('#'+value+'customer_id').val());
    form_data.append('warehouse',$('#'+value+'warehouse').val());
    form_data.append('service_type',$('#'+value+'service_type').val());
    form_data.append('merchant',$('#'+value+'merchant').val());
    form_data.append('weight',$('#'+value+'weight').val());
    form_data.append('lenght',$('#'+value+'lenght').val());
    form_data.append('width',$('#'+value+'width').val());
    form_data.append('height',$('#'+value+'height').val());
    form_data.append('quantity',$('#'+value+'quantity').val());
    form_data.append('value',$('#'+value+'value').val());
    form_data.append('status',$('#'+value+'status').val());
    form_data.append('description',$('#'+value+'description').val());
    form_data.append('package_type',$('#'+value+'package_type').val());
    form_data.append('condition',$condition);
    
    $.ajax({
        url: "admin/ajax.file.php",
        type: 'post',
        data: form_data,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            $('.success-info').append('<div class="alert alert-primary">Successfully update the product! Refresh to view the changes.</div>');
            $( ".close" ).trigger( "click" );
        },
        error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert("error"+err.Message);
        }
    });
}