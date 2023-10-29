<div>

    @section('title',env('App_NAME') .' | '.'Suppliers')

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
                                <li class="breadcrumb-item active">Supplier</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Supplier</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">Suppliers</h3>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-success waves-effect width-md float-right" data-toggle="modal" data-target="#modalAdd" data-overlaySpeed="200" data-animation="fadein">New Supplier</button>
                        </div> 
                    </div>             
                </div>
                <div class="card-body">
                    <div class="box-body">
                        <div class="col-12">
                            <div class="card-box">
                                
                                <div class="row">
                                    <label for="paginate" style="margin-top: auto;">Show</label>
                                    <div class="col-sm-2">
                                        <select id="paginate" name="paginate" class="form-control input-sm" wire:model="paginate">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>  
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3">
                                        <input type="search" wire:model="search" class="form-control input-sm" placeholder="Search By Name, Code, Contact">
                                    </div>
                                </div>
                                <br>

                                <table class="table table-bordered dt-responsive nowrap data-table-categories" width="100%" style="text-align: center">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Payent Info</th>
                                        <th>Note</th>
                                        <th>Modified By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                        @foreach ($suppliers as $key=>$value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->code }}</td>
                                                <td>{{ $value->contact }}</td>
                                                <td>{{ $value->address }}</td>
                                                <td>{{ $value->payment_info }}</td>
                                                <td>{{ $value->note }}</td>
                                                <td>{{ $value->user->name }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                      <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cogs"></i>
                                                      </button>
                                                      <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('suppliers_ledger',['id'=>$value->id]) }}" class="btn btn-warning btn-sm dropdown-item" 
                                                        style="color: black;"><i class=" mdi mdi-book"></i>&nbsp;&nbsp;&nbsp;&nbsp;Ledger</a>
                                                        <a class="btn btn-warning btn-sm dropdown-item"
                                                        data-toggle="modal" data-target="#modalEdit" data-overlaySpeed="200" data-animation="fadein" 
                                                        style="color: black;" wire:click="getItem({{ $value->id }})"><i class="fas fa-pen-fancy"></i>&nbsp;&nbsp;&nbsp;&nbsp;Edit</a>
                                                      </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                {{ $suppliers->links() }}
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div>
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->



        <!--==========================
          =  Modal window for Add Content    =
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
                            <h4 class="modal-title">Add Supplier</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            
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
                                        <strong>Name:</strong>
                                        <input type="text" class="form-control" name="name" placeholder="Name" required wire:model="name">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Code:</strong>
                                        <input type="text" class="form-control" name="code" placeholder="Code" required wire:model="code">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Contact:</strong>
                                        <textarea class="form-control input-lg" name="contact" placeholder="Contact" required wire:model="contact"></textarea>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Address:</strong>
                                        <textarea class="form-control input-lg" name="address" placeholder="Address" required wire:model="address"></textarea>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Paymet Info:</strong>
                                        <textarea class="form-control input-lg" name="payment_info" placeholder="Paymet Info" wire:model="payment_info"></textarea>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Note:</strong>
                                        <textarea class="form-control input-lg" name="note" placeholder="Note" wire:model="note"></textarea>
                                      </div>
                                    </div>
                                  </div>
                              
                            </div>
                          </div>
                          <!--=====================================
                            MODAL FOOTER
                          ======================================-->
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Add</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            
                          </div>
                    </form>
                    
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!--==========================
          =  Modal window for Add Content    =
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
                            <h4 class="modal-title">Edit Supplier</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            
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
                                        <strong>Name:</strong>
                                        <input type="text" class="form-control" name="e_name" placeholder="Name" required wire:model="e_name">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Code:</strong>
                                        <input type="text" class="form-control" name="e_code" placeholder="Code" required wire:model="e_code">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Contact:</strong>
                                        <textarea class="form-control input-lg" name="e_contact" placeholder="Contact" required wire:model="e_contact"></textarea>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Address:</strong>
                                        <textarea class="form-control input-lg" name="e_address" placeholder="Address" required wire:model="e_address"></textarea>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Paymet Info:</strong>
                                        <textarea class="form-control input-lg" name="e_payment_info" placeholder="Paymet Info" wire:model="e_payment_info"></textarea>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Note:</strong>
                                        <textarea class="form-control input-lg" name="e_note" placeholder="Note" wire:model="e_note"></textarea>
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            
                          </div>
                    </form>
                    
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->




</div>


        
