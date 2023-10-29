<div>

    @section('title',env('App_NAME') .' | '.'Batched Products')

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
                                <li class="breadcrumb-item active">Batched Products</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Batched Products</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">Batch : {{ $batch_info->batch_code }}</h3>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-success waves-effect width-md float-right" data-toggle="modal" data-target="#modalAdd" data-overlaySpeed="200" data-animation="fadein">Add New Product</button>
                        </div> 
                    </div>             
                </div>

                <div class="card-body">
                    <div class="box-body">
                        <div class="col-12">
                            <div class="card-box">
                                
                                <div class="row">
                                    {{-- <label for="paginate" style="margin-top: auto;">Show</label> --}}
                                    <div class="col-sm-2 ">
                                        {{-- <select id="paginate" name="paginate" class="form-control input-sm" wire:model="paginate">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> --}}
                                    </div>  
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3">
                                        <input type="search" wire:model="search" class="form-control input-sm" placeholder="Search By Description, SKU">
                                    </div>
                                </div>
                                <br>

                                <table class="table table-bordered dt-responsive nowrap data-table-categories" width="100%" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Batch Code</th>
                                            <th>Category</th>
                                            <th>Item Description</th>
                                            <th>SKU</th>
                                            <th>Unit</th>
                                            <th>QTY</th>
                                            <th>Stock</th>
                                            <th>Sold</th>
                                            <th>Unit Price</th>
                                            <th>Sell Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                        @foreach ($batchedProducts as $key=>$value)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $value->batch->batch_code }}</td>
                                                <td>{{ $value->category->name }}</td>
                                                <td>{{ $value->item_description }}</td>
                                                <td>{{ $value->sku }}</td>
                                                <td>{{ $value->unit->name }}</td>
                                                <td>{{ $value->quantity }}</td>
                                                <td>{{ $value->stock }}</td>
                                                <td>{{ $value->sold }}</td>
                                                <td>{{ $value->unit_price }}</td>
                                                <td>{{ $value->sell_price }}</td>
                                                <td>
                                                  <div class="btn-group dropleft">
                                                      <button class="btn btn-warning btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      <i class="fas fa-cogs"></i>
                                                      </button>
                                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      

                                                          <a href="{{ route('barcode', $value->id) }}" class="dropdown-item btn btn-warning btn-sm" style="color: black" target="_blank"><i class="fas fa-barcode"></i> &nbsp;&nbsp;Barcode</a>
      
                                                          <a href="{{ route('edit_batched_products', $value->id) }}" class="dropdown-item btn btn-warning btn-sm" style="color: black"><i class="fas fa-pen-fancy mr-2"></i>Edit Information</a>
      
                                                          
                                                      </div>
                                                  </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                {{ $batchedProducts->links() }}
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div>

            <!--==========================
              =  Modal window for Edit Content    =
              ===========================-->
            <!-- sample modal content -->
            <div wire:ignore.self id="modalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form role="form" enctype="multipart/form-data" wire:submit.prevent="Store()">
                            @csrf
                            <!--=====================================
                                MODAL HEADER
                            ======================================-->  
                              <div class="modal-header">
                                <h4 class="modal-title">Add Product</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                
                              </div>
                              <!--=====================================
                                MODAL BODY
                              ======================================-->
                              <div class="modal-body">
                                <div class="box-body">

                                      <div class="form-group">          
                                        <div class="input-group">             
                                          <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Item Description:</strong>
                                            <input type="text" class="form-control" name="item_description" placeholder="Item Description" required wire:model="item_description">
                                            @error('item_description') <span class="error" style="color: red">{{ $message }}</span> @enderror
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">

                                        <div class="col-sm-6">

                                            <div class="input-group">             
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                  <strong>Category</strong>
  
                                                  <select class="form-control" name="category_id" required wire:model="category_id">
                                                      
                                                      <option value="" disabled>Select Category</option>
  
                                                      @foreach ($categories as $key=>$value)
                                                          <option value="{{ $value->id }}">{{ $value->id }} : {{ $value->name }}</option>
                                                      @endforeach
  
                                                  </select>
                                                  @error('category_id') <span class="error" style="color: red">{{ $message }}</span> @enderror
  
                                                </div>
                                              </div>
                                            
                                            <div class="input-group">             
                                              <div class="col-xs-12 col-sm-12 col-md-12">
                                                <strong>SKU</strong>
                                                <input type="text" class="form-control" name="sku" placeholder="SKU" required wire:model="sku">
                                                @error('sku') <span class="error text-danger">{{ $message }}</span> @enderror
                                              </div>
                                            </div>

                                            <div class="input-group">             
                                              <div class="col-xs-12 col-sm-12 col-md-12">
                                                <strong>Unit</strong>

                                                <select class="form-control" name="unit_id" required wire:model="unit_id">
                                                    
                                                    <option value="" disabled>Select Unit</option>

                                                    @foreach ($units as $key=>$value)
                                                        <option value="{{ $value->id }}">{{ $value->id }} : {{ $value->name }}</option>
                                                    @endforeach

                                                </select>
                                                @error('unit_id') <span class="error text-danger">{{ $message }}</span> @enderror

                                              </div>
                                            </div>

                                            

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="input-group">             
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                  <strong>Quantity</strong>
                                                  <input type="text" class="form-control" name="quantity" placeholder="Quantity" required wire:model="quantity">
                                                  @error('quantity') <span class="error text-danger">{{ $message }}</span> @enderror
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

                                      
                                  
                                </div>
                              </div>
                              <!--=====================================
                                MODAL FOOTER
                              ======================================-->
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success waves-effect waves-light">Add</button>
                              </div>
                        </form>
                        
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

</div>
