<div>

    @section('title',env('App_NAME') .' | '.'Batch')

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
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Batch</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">Batches</h3>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('add_batch') }}" type="button" class="btn btn-outline-success waves-effect width-md float-right">Add New Batch</a>
                        </div> 
                    </div>             
                </div>

                <div class="card-body">
                    <div class="box-body">
                        <div class="col-12">
                            <div class="card-box">
                                
                                <div class="row">
                                    <label for="paginate" style="margin-top: auto;">Show</label>
                                    <div class="col-sm-2 ">
                                        <select id="paginate" name="paginate" class="form-control input-sm" wire:model="paginate">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>  
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3">
                                        <input type="search" wire:model="search" class="form-control input-sm" placeholder="Search">
                                    </div>
                                </div>
                                <br>

                                <table class="table table-bordered dt-responsive nowrap data-table-categories text-center" width="100%">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Batch Code</th>
                                        <th>Note</th>
                                        <th>Supplier</th>
                                        {{-- <th>Total Cost</th> --}}
                                        <th>Import Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                        @foreach ($allBatches as $key=>$value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->batch_code }}</td>
                                                <td>{{ $value->note }}</td>
                                                <td>{{ $value->supplier->name }}</td>
                                                {{-- <td>{{ $value->supply_price }}</td> --}}
                                                <td>{{ Carbon\Carbon::parse($value->import_date)->format('d F, Y') }}</td>
                                                <td>
                                                    <div class="btn-group dropleft">
                                                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cogs"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        

                                                            <a href="{{ route('batched_products', $value->id) }}" class="dropdown-item btn btn-warning btn-sm" style="color: black"><i class="fas fa-eye"></i> &nbsp;&nbsp;View Products</a>
        
                                                            <a wire:click="getItem('{{ $value->id }}')" data-toggle="modal" data-target="#modalEdit" class="dropdown-item btn btn-warning btn-sm"><i class="fas fa-pen-fancy mr-2"></i>Edit Information</a>
        
                                                            
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                {{ $allBatches->links() }}
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div>


            <!--==========================
              =  Modal window for Edit Content    =
              ===========================-->
            <!-- sample modal content -->
            <div wire:ignore.self id="modalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form role="form" enctype="multipart/form-data" wire:submit.prevent="Update()">
                            @csrf
                            <!--=====================================
                                MODAL HEADER
                            ======================================-->  
                              <div class="modal-header">
                                <h4 class="modal-title">Edit Import</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                
                              </div>
                              <!--=====================================
                                MODAL BODY
                              ======================================-->
                              <div class="modal-body">
                                <div class="box-body">

                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Batch Code:</strong>
                                        <input type="text" class="form-control" name="batch_code" placeholder="Batch Code" required wire:model="batch_code">
                                        @error('batch_code') <span class="error text-danger">{{ $message }}</span> @enderror
                                      </div>
                                    </div>

                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Note:</strong>
                                        <textarea class="form-control" name="note" placeholder="Note" required wire:model="note"></textarea>
                                        @error('note') <span class="error text-danger">{{ $message }}</span> @enderror
                                      </div>
                                    </div>

                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Import Date:</strong>
                                        <input type="date" class="form-control" name="import_date" required wire:model="import_date">
                                        @error('import_date') <span class="error text-danger">{{ $message }}</span> @enderror
                                      </div>
                                    </div>

                                              
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
                              </div>
                              <!--=====================================
                                MODAL FOOTER
                              ======================================-->
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                              </div>
                        </form>
                        
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

</div>
