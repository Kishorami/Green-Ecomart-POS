<div>

    @section('title',env('App_NAME') .' | '.'Add New Batch')

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
                                <li class="breadcrumb-item active">Batch</li>
                                <li class="breadcrumb-item active">Add New Batch</li>
                                
                            </ol>
                        </div>
                        <h4 class="page-title">Add New Batch</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card-box">
                        <h4 class="header-title mb-2">Batch Information</h4>

                        <form role="form" enctype="multipart/form-data" wire:submit.prevent="Store()">
                            @csrf

                            {{-- Batch Information --}}

                            <div class="row">
                                <div class="col-md-6">

                                <div class="form-group">          
                                    <div class="input-group">             
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Batch Code:</strong>
                                        <input type="text" class="form-control" name="batch_code" placeholder="Batch Code" required wire:model="batch_code">
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group">          
                                    <div class="input-group">             
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Import Date:</strong>
                                        <input type="date" class="form-control" name="import_date" placeholder="Import Date" required wire:model="import_date">
                                    </div>
                                    </div>
                                </div>

                                
                                </div>

                                <div class="col-md-6">

                                <div class="form-group">          
                                    <div class="input-group">             
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Note:</strong>
                                        <textarea class="form-control" name="Note" placeholder="Note" wire:model="note"></textarea>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group">          
                                    <div class="input-group">             
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Product Input Type:</strong>
                                        <select class="form-control" name="product_input_type" required wire:model="product_input_type">
                                            
                                            <option value="" disabled>Select Type</option>
                                            <option value="from_excel">From Excel</option>
                                            <option value="menual">Menual</option>

                                        </select>
                                    </div>
                                    </div>
                                </div>

                                @if($product_input_type === 'from_excel')

                                <div class="form-group">          
                                    <div class="input-group">             
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Select Excel:</strong>
                                        <input type="file" required wire:model="product_list_excel">
                                    </div>
                                    </div>
                                </div>

                                @endif

                                </div>

                            </div>

                            {{-- Excel Sample --}}
                            @if($product_input_type === 'from_excel')    
                            <div class="card container">
                                <div class="container-fluid">

                                <div class="modal-header">
                                    <h4 class="modal-title">Sample Excel Format</h4>                    
                                </div>

                                <table class="table table-bordered" style="text-align:center;">
                                    <thead>
                                    <tr>
                                        <th>A</th>
                                        <th>B</th>
                                        <th>C</th>
                                        <th>D</th>
                                        <th>E</th>
                                        <th>F</th>
                                        <th>G</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>Category ID</th>
                                        <th>Product Description</th>
                                        <th>SKU</th>
                                        <th>Unit ID</th>
                                        <th>Quantity</th>
                                        <th>Cost Per Unit</th>
                                        <th>Sell Price</th>
                                    </tr>
                                    </tbody>
                                </table>

                                </div>
                            </div>
                            @endif  


                            {{-- Supplier Info --}}
                            <h4 class="header-title mb-2 mt-2">Supply Information</h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">          
                                        <div class="input-group">             
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <strong>Supplier:</strong>
                                                <select class="form-control" name="supply_amount" wire:model="supplier_id" required>
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($suppliers as $key=>$value)
                                                        <option value="{{ $value->id }}">{{ $value->name }} : {{ $value->code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="form-group">          
                                        <div class="input-group">             
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <strong>Supply Bill:</strong>
                                                <input type="number" class="form-control" name="supply_price" placeholder="Supply Price"  wire:model="supply_price" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">          
                                        <div class="input-group">             
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <strong>Payed Amount:</strong>
                                                <input type="number" class="form-control" name="paid_amount" placeholder="Payed Amount" wire:model="paid_amount">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">          
                                        <div class="input-group">             
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <strong>Payment Method:</strong>
                                                <select class="form-control" name="payment_method_id" wire:model="payment_method_id" required>
                                                    <option value="">Select Payment Method</option>
                                                    @foreach ($payment_methods as $key=>$value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">          
                                <div class="input-group">             
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Ledger Note:</strong>
                                    <textarea class="form-control" name="note" placeholder="Ledger Note" wire:model="ledger_note"></textarea>
                                </div>
                                </div>
                            </div>

                            


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Store</button>
                              </div>
                        </form>
                        
                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

</div>
