<div>

    @section('title',env('App_NAME') .' | '.'Sell Settings')

    <style>
        .custom-switch.custom-switch-lg .custom-control-label {
            padding-left: 3rem;
            padding-bottom: 2rem;
        }

        .custom-switch.custom-switch-lg .custom-control-label::before {
            height: 2rem;
            width: calc(3rem + 0.75rem);
            border-radius: 4rem;
        }

        .custom-switch.custom-switch-lg .custom-control-label::after {
            width: calc(2rem - 4px);
            height: calc(2rem - 4px);
            border-radius: calc(3rem - (2rem / 2));
        }

        .custom-switch.custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(calc(2rem - 0.25rem));
        }
    </style>

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ env('App_NAME') }}</a></li>
                                <li class="breadcrumb-item active">Sell Settings</li>
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Sell Settings</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card-box">
                        <h4 class="header-title mb-0">Sell settings</h4>

                        <div class="row">
                            <div class="col-sm-12">
                                <form role="form" wire:submit.prevent="Update()" enctype="multipart/form-data">
                                    @csrf
                                    <!--=====================================
                                        MODAL HEADER
                                    ======================================-->  
                                    <div class="modal-header" style="color: white">
                                    
                                    </div>
                                    <!--=====================================
                                        MODAL BODY
                                    ======================================-->
                                    <div class="modal-body">
                                        <div class="box-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            
                                            <div class="form-group" wire:ignore>          
                                                <div class="input-group">             
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <strong>Vat/Tax %:</strong>
                                                    <input type="number" class="form-control" name="vat" placeholder="Vat/Tax %" required wire:model="vat">
                                                    <small style="color:red"> *Set Vat/Tax % fild to 0 (zero) if not needed.*</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="d-flex">
                                                <strong style="color:red">If Switch</strong> &nbsp;
                                                <div class="custom-control custom-switch">
                                                    
                                                    <input type="checkbox" class="custom-control-input" disabled id="customSwitch2">
                                                    <label class="custom-control-label" for="customSwitch2" style="color:red">Redeem points Disabled, </label>
                                                </div>
                                                &nbsp;<strong style="color:red">If Switch</strong> &nbsp;
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" checked disabled id="customSwitch2">
                                                    <label class="custom-control-label" for="customSwitch2" style="color:red">Redeem points Enabled</label>
                                                </div>
                                                &nbsp;<strong style="color:red">( * Disable Redeem points if do not want to use in sell.)</strong>
                                            </div>
                                            <hr class="mt-1 mb-1">
                                            <div class="custom-control custom-switch custom-switch-lg" style="font-size: 1.5rem">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch5" role="switch" wire:model.lazy="enable_points" @if($enable_points) checked  @endif>
                                                <label class="custom-control-label" for="customSwitch5">Enable/Disable Redeem Points for Sell</label>
                                            </div>

                                            <div><h4>Earning Points Settings:</h4></div>

                                            <div class="row">
                                                
                                                <div class="col-sm-4">
                                                    <div class="form-group">      
                                                            <strong>Number of Points:</strong>          
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="earning_points" placeholder="Amount of Points" required wire:model="earning_points" step="any">
                                                        </div>
                                                        <small style="color:red">* set value indecates that, the number of points will be given.*</small>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">      
                                                            <strong>Points Given For Purchasing Per Amount:</strong>          
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="per_amount" placeholder="Points Given Per Amount" required wire:model="per_amount" step="any">
                                                        </div>
                                                        <small style="color:red">*points will be given for every given value.*</small>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">      
                                                            <strong>Maximum Points Given Per Invoice:</strong>          
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="max_point_per_invoice" placeholder="Max Points Per Invoice" required wire:model="max_point_per_invoice" step="any">
                                                        </div>
                                                        <small style="color:red">*Maximum number of points one invoice can get. If this field is set to 0 (zero) user can use all their reward points.*</small>
                                                    </div>
                                                </div>

                                            </div>

                                            <div><h4>Redeem Points Settings:</h4></div>

                                            <div class="row">
                                                
                                                <div class="col-sm-4">
                                                    <div class="form-group">      
                                                            <strong>Discount/Money Per Points:</strong>          
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="money_per_point" placeholder="Discount/Amount of Points" required wire:model="money_per_point" step="any">
                                                        </div>
                                                        <small style="color:red">*Discount value for 1 point.*</small>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">      
                                                            <strong>Minimum Order Total to Redeem Points:</strong>          
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="min_amount_to_use_points" placeholder="Minimum Order Total to Redeem Points" required wire:model="min_amount_to_use_points" step="any">
                                                        </div>
                                                        <small style="color:red">*Minimum invoice value(sub total) to use redeem points.*</small>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">      
                                                        <strong>Redeem 1 point per Amount:</strong>          
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="use_points_per_amount" placeholder="Redeem 1 point per Amount" required wire:model="use_points_per_amount" step="any">
                                                        </div>
                                                        <small style="color:red">*1 point will be used for every given amount.*</small>
                                                    </div>
                                                </div>

                                            </div>
                                        
                                        </div>
                                    </div>
                                    <!--=====================================
                                        MODAL FOOTER
                                    ======================================-->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                                    </div>
                                </form>
                            </div>
                            
                            

                        </div> <!-- end row-->
                        
                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->


</div>
