



<div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="editProduct" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProduct">Edit Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="edit-form-valide" action="#" method="post"  enctype="multipart/form-data">
            <div class="modal-body row">

     
                <div class="col-sm-12 col-md-5">
                    <div class="form-group">
                      
                            <input type="file" id="edituploadFile" name="edituploadFile[]" multiple/>
                         
                         <hr/>
                        <div id="editimage_preview"></div>
                    </div>
                    <hr/>
                </div> 
                <div class="col-sm-12  col-md-7">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-warehouse">Warehouse<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                    <select class="custom-select" id="edit-val-warehouse" name="edit-val-warehouse">
                                        <option selected></option>
                                        <option value="us-warehouse" >US Warehouse</option>
                                        <option value="ph-warehouse" >Ph Warehouse</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                        <input type="hidden" class="form-control" id="edit-val-pid" name="edit-val-pid" value="" >
                        <input type="hidden" class="form-control" id="edit-val-customer_id" name="edit-val-customer_id" value="<?=$customerId?>" >
                            <label class="col-lg-4 col-form-label" for="val-service_type">Service type<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                    <select class="custom-select" id="edit-val-service_type" name="edit-val-service_type">
                                    <option value="personal-shopper">Personal Shopper</option>
                                        <option value="consolidation">Consolidation</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-package_type">Package type<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                    <select class="custom-select" id="edit-val-package_type" name="edit-val-package_type">
                                        <option value="normal" selected>Normal</option>
                                        <option value="electronics">Electronics</option>
                                        <option value="fragile-items">Fragile Items</option>
                                        <option value="automotive-parts">Automotive Parts</option>
                                        <option value="irregular-sized-packages">Irregular-Sized Packages</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-merchant">Merchant<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="text" class="form-control" id="edit-val-merchant" name="edit-val-merchant" placeholder="Amazon" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-weight">Weight (kg)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="edit-val-weight" name="edit-val-weight" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-height">Height (cm)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="edit-val-height" name="edit-val-height" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-width">Width< (cm)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="edit-val-width" name="edit-val-width" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-lenght">Lenght (cm)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="edit-val-lenght" name="edit-val-lenght" placeholder="" >
                            </div>
                        </div>
                    
                      
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-quantity">Quantity<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="edit-val-quantity" name="edit-val-quantity" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-value">Value ($)<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="number" class="form-control" id="edit-val-value" name="edit-val-value" placeholder="" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-description">Description<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                            <input type="text" class="form-control" id="edit-val-description" name="edit-val-description" placeholder="" >
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="edit-val-status">Status
                            </label>
                            <div class="col-lg-6">
                                    <select class="custom-select" id="edit-val-status" name="edit-val-status">
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
                <button type="submit" class="btn btn-primary">  Edit Product</button>
          
            </div>
            </form>
            
               
        </div>
    </div>
    </div>