<div>

    @section('title',env('App_NAME') .' | '.'Customers')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ env('App_NAME') }}</a></li>Customers</li>
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Customers</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">Customers</h3>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-success waves-effect width-md float-right" data-toggle="modal" data-target="#modalAdd" data-overlaySpeed="200" data-animation="fadein">New Customer</button>
                        </div> 
                    </div>             
                </div>

                  <!-- /.card-header -->
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
                                        <input type="search" wire:model="search" class="form-control input-sm" placeholder="Search By Name, Code, Phone">
                                    </div>
                                </div>
                                <br>

                                <table class="table table-bordered dt-responsive nowrap data-table-customers" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="5%">S/N</th>
                                        <th width="35%">Name</th>
                                        <th width="15%">Code</th>
                                        <th width="40%">Phone</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($customers as $key=>$value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->code }}</td>
                                                <td>{{ $value->phone }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                      <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cogs"></i>
                                                      </button>
                                                      <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('customers_ledger',['id'=>$value->id]) }}" class="btn btn-warning btn-sm dropdown-item" 
                                                         style="color: black;"><i class=" mdi mdi-cash"></i>&nbsp;&nbsp;&nbsp;&nbsp;Ledger</a>
                                                        <a class="btn btn-warning btn-sm dropdown-item"
                                                         data-toggle="modal" data-target="#modalEdit" data-overlaySpeed="200" data-animation="fadein" 
                                                         style="color: black;" wire:click="getItem({{ $value->id }})"><i class="fas fa-pen-fancy"></i>&nbsp;&nbsp;&nbsp;&nbsp;Edit</a>
                                                      </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $customers->links() }}
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div>
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

    <!--==========================
      =  Modal window for Add Customers    =
      ===========================-->
    <!-- sample modal content -->
    <div wire:ignore.self id="modalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" wire:submit.prevent="Store()" enctype="multipart/form-data">
                    @csrf
                    <!--=====================================
                        MODAL HEADER
                    ======================================-->  
                      <div class="modal-header" style="color: white">
                        <h4 class="modal-title">Add Customer Form</h4>
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

                             <div class="form-group">          
                                <div class="input-group">             
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Name:</strong>
                                    <input type="text" class="form-control input-lg" name="name" placeholder="Name" required wire:model="name">
                                  </div>
                                </div>
                              </div>
                              <!-- TAKING Amount -->
                              
                              <div class="form-group">      
                                <div class="input-group">                 
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Phone:</strong>
                                    <input type="text" class="form-control input-lg" name="phone" placeholder="Phone" required wire:model="phone">
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
      =  Modal window for Edit Customers    =
      ===========================-->
    <!-- sample modal content -->
    <div wire:ignore.self id="modalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" wire:submit.prevent="Update()" enctype="multipart/form-data">
                    @csrf
                    <!--=====================================
                        MODAL HEADER
                    ======================================-->  
                      <div class="modal-header" style="color: white">
                        <h4 class="modal-title">Edit Customer Form</h4>
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

                             <div class="form-group">          
                                <div class="input-group">             
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Name:</strong>
                                    <input type="text" class="form-control input-lg" name="e_name" placeholder="Name" required wire:model="e_name">
                                  </div>
                                </div>
                              </div>
                              <!-- TAKING Amount -->
                              
                              <div class="form-group">      
                                <div class="input-group">                 
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Phone:</strong>
                                    <input type="text" class="form-control input-lg" name="e_phone" placeholder="Phone" required wire:model="e_phone">
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
