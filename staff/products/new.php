



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="form-valide" action="#" method="post"  enctype="multipart/form-data">
            <div class="modal-body row">

     
                <div class="col-sm-12 col-md-5">
                    <div class="form-group">
                      
                            <input type="file" id="uploadFile" name="uploadFile[]" multiple/>
                         
                     
                         <hr/>
                        <div id="image_preview"></div>
                    </div>
                    <hr/>
                </div> 
                <div class="col-sm-12  col-md-7">
                <input type="hidden" class="form-control" id="val-customer_id" name="val-customer_id" value="<?=$customerId?>" >
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-warehouse">Warehouse<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                    <select class="custom-select" id="val-warehouse" name="val-warehouse">
                                    <option selected></option>
                                        <option value="us-warehouse" >Us Warehouse</option>
                                        <option value="ph-warehouse" >PH Warehouse</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                        <input type="hidden" class="form-control" id="val-id" name="val-id" value="<?=$customerId?>" >
                            <label class="col-lg-4 col-form-label" for="val-service_type">Service type<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                    <select class="custom-select" id="val-service_type" name="val-service_type">
                                        <option value="personal-shopper">Personal Shopper</option>
                                        <option value="consolidation">Consolidation</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-package_type">Package type<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                    <select class="custom-select" id="val-package_type" name="val-package_type">
                                        <option value="normal" selected>Normal</option>
                                        <option value="electronics">Electronics</option>
                                        <option value="fragile-items">Fragile Items</option>
                                        <option value="automotive-parts">Automotive Parts</option>
                                        <option value="irregular-sized-packages">Irregular-Sized Packages</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-merchant">Merchant<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="text" class="form-control" id="val-merchant" name="val-merchant" placeholder="Amazon" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-weight">Weight (kg)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="val-weight" name="val-weight" placeholder="" >
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-height">Height (cm)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="val-height" name="val-height" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-width">Width< (cm)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="val-width" name="val-width" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-lenght">Lenght (cm)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="val-lenght" name="val-lenght" placeholder="" >
                            </div>
                        </div>
                      
                       
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-quantity">Quantity<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="val-quantity" name="val-quantity" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-value">Value ($)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="val-value" name="val-value" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-description">Description
                            </label>
                            <div class="col-lg-6">
                            <input type="text" class="form-control" id="val-description" name="val-description" placeholder="" >
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-status">Status
                             </label>
                            <div class="col-lg-6">
                                    <select class="custom-select" id="val-status" name="val-status">
                                        <option selected></option>
                                        <option value="1">Missing Values</option>
                                        <option value="2">Arrive on Warehouse</option>
                                        <option value="3">Ready for Shipment</option>
                                    </select>
                            </div>
                            </div>
            
                </div>
            </div>
            <div class="modal-footer">
        
           
        
        <!-- Loading gif --><span class="spinner-border spinner-border-sm loading_saving_product" role="status" aria-hidden="true" style="display:none"></span>
                <button type="submit" class="btn btn-primary">  Add Product</button>
          
            </div>
            </form>
            
               
        </div>
    </div>
    </div>