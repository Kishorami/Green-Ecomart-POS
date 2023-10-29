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
                                <li class="breadcrumb-item active">Products</li>
                                <li class="breadcrumb-item active">Edit Products</li>
                                
                            </ol>
                        </div>
                        <h4 class="page-title">Edit Products</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card-box">
                        <h4 class="header-title mb-2">Product Information</h4>

                        <form role="form" enctype="multipart/form-data" wire:submit.prevent="Update()">
                            @csrf

                            {{-- product Information --}}

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">          
                                        <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Batch:</strong>
                                            <select class="form-control" name="batch_id" required wire:model="batch_id">
                                                @foreach ($batches as $key=>$value)
                                                    <option value="{{ $value->id }}">{{ $value->batch_code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </div>
                                    </div>

                                
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">          
                                        <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Category:</strong>
                                            <select class="form-control" name="category_id" required wire:model="category_id">
                                                @foreach ($categories as $key=>$value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            
                            <hr>

                            <div class="row mb-3">

                                <div class="col-md-12">
                                    <div class="form-group">          
                                        <div class="input-group">             
                                            <div class="col-xs-12 col-sm-12 col-md-12" width="100%">
                                                <strong>Item Description:</strong>
                                                <input type="text" class="form-control" name="item_description" placeholder="Item Description" required wire:model="item_description">
                                                @error('item_description') <span class="error" style="color: red">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>SKU</strong>
                                            <input type="text" class="form-control" name="sku" placeholder="SKU" required wire:model="sku">
                                            @error('sku') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Quantity</strong>
                                            <input type="text" class="form-control" name="quantity" placeholder="Quantity" required wire:model="quantity" readonly>
                                            @error('quantity') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Stock</strong>
                                            <input type="text" class="form-control" name="stock" placeholder="Stock" required wire:model="stock" readonly>
                                            @error('stock') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>New Stock Quantity</strong>
                                            <input type="text" class="form-control" name="new_stock" placeholder="New Stock Quantity" wire:model="new_stock">
                                            @error('new_stock') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-6">

                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Unit</strong>

                                            <select class="form-control" name="unit_id" required wire:model="unit_id">
                                                @foreach ($units as $key=>$value)
                                                    <option value="{{ $value->id }}">{{ $value->id }} : {{ $value->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('unit_id') <span class="error text-danger">{{ $message }}</span> @enderror

                                        </div>
                                    </div>

                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Unit Price</strong>
                                            <input type="number" step="any" class="form-control" name="unit_price" placeholder="Unit Price" required wire:model="unit_price">
                                            @error('unit_price') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Sell Price</strong>
                                            <input type="number" step="any" class="form-control" name="sell_price" placeholder="Cost Per Unit" required wire:model="sell_price">
                                            @error('sell_price') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
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
