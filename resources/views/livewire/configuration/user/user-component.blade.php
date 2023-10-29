<div>

    @section('title',env('App_NAME') .' | '.'Users')

    <style type="text/css">
       /* The switch - the box around the slider */
        .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
          opacity: 0;
          width: 0;
          height: 0;
        }

        /* The slider */
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        input:checked + .slider {
          /*background-color: #2196F3;*/
          background-color: #0fa83b;
        }

        input:focus + .slider {
          /*box-shadow: 0 0 1px #2196F3;*/
          box-shadow: 0 0 1px #0fa83b;
        }

        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }

        .slider.round:before {
          border-radius: 50%;
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
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Users</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">Users</h3>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-success waves-effect width-md float-right" data-toggle="modal" data-target="#modalAdd" data-overlaySpeed="200" data-animation="fadein">New User</button>
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
                                        <input type="search" wire:model="search" class="form-control input-sm" placeholder="Search By Name, Email, Contatc">
                                    </div>
                                </div>
                                <br>

                                <table class="table table-bordered dt-responsive nowrap" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width:10px">S/N</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Contact</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($users as $row)
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->contact }}</td>
                                            <td>{{ $row->user_type }}</td>
                                            <td class="text-center">
                                                @if($row->id != auth()->user()->id)
                                                    <label class="switch">
                                                      <input type="checkbox" wire:click="toggleActive({{ $row->id }})" @if($row->is_active) checked @endif>
                                                      <span class="slider round"></span>
                                                    </label>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->id != auth()->user()->id)
                                                    <div class="btn-group">
                                                        <a wire:click="getItem({{ $row->id }})" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit" data-overlaySpeed="200" data-animation="fadein" style="color:black;">Edit</a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links() }}
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div>
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->


    <!--==========================
      =  Modal window for Add Users    =
      ===========================-->
    <!-- sample modal content -->
    <div id="modalAdd" wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" wire:submit.prevent="Store()" enctype="multipart/form-data">
                    @csrf
                    <!--=====================================
                        MODAL HEADER
                    ======================================-->  
                      <div class="modal-header" style="color: white">
                        <h4 class="modal-title">User Registration Form</h4>
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
                          <!-- TAKING NAME FOR NEW USER -->
                          <div class="form-group">          
                            <div class="input-group">             
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>&nbsp;&nbsp;
                              <input type="text" class="form-control input-lg" name="name" placeholder="Name" required wire:model="name">
                            </div>
                          </div>
                          
                          <!-- TAKING USER EMAIL FOR NEW USER -->
                          
                          <div class="form-group">      
                            <div class="input-group">                 
                              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>&nbsp;&nbsp;
                              <input type="email" class="form-control input-lg" name="email" placeholder="Email" id="newemail" required wire:model="email">
                            </div>
                          </div>
                          <!-- TAKING PASSWORD FOR NEW USER -->
                          
                          <div class="form-group">
                            <div class="input-group">                 
                              <span class="input-group-addon"><i class="fa fa-lock"></i></span>&nbsp;&nbsp;
                              <input type="password" class="form-control input-lg" name="password" placeholder="Password" required wire:model="password">
                            </div>
                          </div>
                          <!-- TAKING phone FOR NEW USER -->
                          
                          <div class="form-group">
                            <div class="input-group">                 
                              <span class="input-group-addon"><i class="fa fa-phone"></i></span>&nbsp;&nbsp;
                              
                              <textarea class="form-control input-lg" name="phone" placeholder="Contact" wire:model="contact"></textarea>

                            </div>
                          </div>
                          <!-- SELECTING ROLE FOR NEW USER -->             
                          <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>&nbsp;&nbsp;
                                <select class="form-control input-lg" name="user_type" wire:model="user_type">
                                  <option value="" disabled selected>Select Type</option>

                                  @if(auth()->user()->user_type === 'admin')
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                  @endif
                                  
                                  <option value="cashier">Cashier</option>

                                </select>
                              </div>
                            </div>
                            
                        </div>
                      </div>
                      <!--=====================================
                        MODAL FOOTER
                      ======================================-->
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Create</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                </form>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!--==========================
      =  Modal window for Add Users    =
      ===========================-->
    <!-- sample modal content -->
    <div id="modalEdit" wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" wire:submit.prevent="Update()" enctype="multipart/form-data">
                    @csrf
                    <!--=====================================
                        MODAL HEADER
                    ======================================-->  
                      <div class="modal-header" style="color: white">
                        <h4 class="modal-title">User Edit Form</h4>
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
                          <!-- TAKING NAME FOR NEW USER -->
                          <div class="form-group">          
                            <div class="input-group">             
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>&nbsp;&nbsp;
                              <input type="text" class="form-control input-lg" name="e_name" placeholder="Name" required wire:model="e_name">
                            </div>
                          </div>
                          
                          <!-- TAKING USER EMAIL FOR NEW USER -->
                          
                          <div class="form-group">      
                            <div class="input-group">                 
                              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>&nbsp;&nbsp;
                              <input type="email" class="form-control input-lg" name="e_email" placeholder="Email" required wire:model="e_email">
                            </div>
                          </div>
                          <!-- TAKING PASSWORD FOR NEW USER -->
                          
                          <div class="form-group">
                            <div class="input-group">                 
                              <span class="input-group-addon"><i class="fa fa-lock"></i></span>&nbsp;&nbsp;
                              <input type="password" class="form-control input-lg" name="e_password" wire:model="e_password">
                            </div>
                          </div>
                          <!-- TAKING phone FOR NEW USER -->
                          
                          <div class="form-group">
                            <div class="input-group">                 
                              <span class="input-group-addon"><i class="fa fa-phone"></i></span>&nbsp;&nbsp;
                              
                              <textarea class="form-control input-lg" name="e_contact" placeholder="Contact" wire:model="e_contact"></textarea>

                            </div>
                          </div>
                          <!-- SELECTING ROLE FOR NEW USER -->             
                          <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>&nbsp;&nbsp;
                                <select class="form-control input-lg" name="e_user_type" wire:model="e_user_type">
                                  <option value="" disabled selected>Select Type</option>

                                  @if(auth()->user()->user_type === 'admin')
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                  @endif
                                  
                                  <option value="cashier">Cashier</option>

                                </select>
                              </div>
                            </div>
                            
                        </div>
                      </div>
                      <!--=====================================
                        MODAL FOOTER
                      ======================================-->
                      <div class="modal-footer">

                        <p>** If No Need To Change This User's Password. Leave Password Fild Blank.*</p>

                        <button type="submit" class="btn btn-primary waves-effect waves-light"> Update </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                </form>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@push('scripts')
    
@endpush

</div>
