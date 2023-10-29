<div>
  @section('title',env('App_NAME') .' | '.'Payment Method')
  
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
                              <li class="breadcrumb-item active">Payment Method</li>
                          </ol>
                      </div>
                      <h4 class="page-title">Payment Method</h4>
                  </div>
              </div>
          </div>     
          <!-- end page title --> 

          <!-- stert Content -->
          <div class="card col-md-8 offset-md-2">
              <div class="card-header">
                  <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">Payment Methods</h3>
                      </div>
                      <div class="col-6">
                          <button type="button" class="btn btn-success waves-effect width-md float-right" data-toggle="modal" data-target="#modalAdd" data-overlaySpeed="200" data-animation="fadein">New Payment Method</button>
                      </div> 
                  </div>             
              </div>
              <div class="card-body">
                  <div class="box-body">
                      <div class="col-12">
                          <div class="card-box">
                              {{-- <h4 class="header-title">All Users</h4> --}}

                              <table class="table table-bordered dt-responsive nowrap data-table-categories text-center" width="100%">
                                  <thead>
                                  <tr>
                                      <th>S/N</th>
                                      <th>Name</th>
                                      <th>Action</th>
                                  </tr>
                                  </thead>
                                      @foreach ($payment_methods as $key=>$value)
                                          <tr>
                                              <td>{{ $value->id }}</td>
                                              <td>{{ $value->name }}</td>
                                              <td>
                                                  <a type="button" class="btn btn-warning waves-effect btn-sm" data-toggle="modal" data-target="#modalEdit" data-overlaySpeed="200" data-animation="fadein" wire:click="getItem({{ $value->id }})" style="color: white">Edit</a>
                                              </td>
                                          </tr>
                                      @endforeach
                                  <tbody>
                                      
                                  </tbody>
                              </table>
                          </div> <!-- end card-box -->
                      </div> <!-- end col -->
                  </div> <!-- end row -->
              </div>
          </div>
          
          <!-- end Content -->

      </div> <!-- container -->

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
                          <h4 class="modal-title">Add Payment Method</h4>
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
                          <h4 class="modal-title">Edit Payment Method</h4>
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

  </div> <!-- content -->

</div>



    
