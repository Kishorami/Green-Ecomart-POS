<div>

    @section('title',env('App_NAME') .' | '.'Refunds')

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
                                <li class="breadcrumb-item active">Refunds</li>
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Refunds</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <div class="row header-title">
                            <div class="col-sm-2">
                                <h4 class="header-title mb-0">Refunds</h4>
                            </div>
                            <div class="col-sm-4 text-center">
                                <div><strong>&nbsp;</strong></div>
                                <a class="btn ntn-sm btn-success text-white" wire:click="today()">Today</a>
                                <a class="btn ntn-sm btn-primary text-white" wire:click="last_seven_days()">last 7 Days</a>
                                <a class="btn ntn-sm btn-purple text-white" wire:click="this_month()">This Month</a>
                            </div>
                            <div class="col-sm-4">
                                <form class="form-inline" enctype="multipart/form-data" wire:submit.prevent="search_by_form()">
                                    @csrf
                                    <div class="col-md-5">
                                        <strong>From</strong>
                                        <input type="date" class="form-control input-sm"  style="width: 100%" wire:model="temp_from">
                                    </div>
                                    <div class="col-md-5">
                                        <strong>To</strong>
                                        <input type="date" class="form-control input-sm"  style="width: 100%" wire:model="temp_to">
                                    </div>
                                    <div class="col-md-2" style="text-align: center">
                                        <div><strong>&nbsp;</strong></div>
                                        <button type="submit" class="btn btn-primary" >View</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-2 text-center">
                                <div><strong>&nbsp;</strong></div>
                                <button type="button" class="btn btn-success waves-effect width-md float-right" data-toggle="modal" data-target="#modalAdd" data-overlaySpeed="200" data-animation="fadein">New Rewfund</button>
                            </div>
                        </div>
                        <hr>

                        @if ($refunds)
                            <div class="card container">

                                <h4 class="header-title mb-2 mt-3 text-center">
                                    Expences of 
                                    <span style="color: red">

                                        {{-- {{ Carbon\Carbon::parse($month)->format('F, Y') }} --}}
                                        @if ($flag === 'today')
                                            Today &nbsp;( {{ Carbon\Carbon::now()->format('d F, Y') }} )
                                        @elseif($flag === 'last_seven_days')
                                            Last 7 Days &nbsp;( From: {{ Carbon\Carbon::now()->subDays(7)->format('d F, Y') }} - To: {{ Carbon\Carbon::now()->format('d F, Y') }} )
                                        @elseif($flag === 'this_month')
                                            {{ Carbon\Carbon::now()->format('F, Y') }}
                                        @else
                                            From: {{ Carbon\Carbon::parse($from)->subDays(7)->format('d F, Y') }} - To: {{ Carbon\Carbon::parse($to)->format('d F, Y') }}
                                        @endif
                                    </span>
                                </h4>

                                <table class="table table-bordered dt-responsive nowrap data-table-categories" width="100%" style="text-align: center">
                                    
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Customer</th>
                                            <th>Bill No</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Updated By</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                
                                    <tbody>
                                        @foreach ($refunds as $key=>$value)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->sell->bill_no }}</td>
                                                <td>{{ $value->description }}</td>
                                                <td style="text-align: right">{{ $value->amount }}</td>
                                                <td>{{ $value->user->name }}</td>
                                                <td>{{ Carbon\Carbon::parse($value->created_at)->format('d F, Y') }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-warning waves-effect btn-sm" data-toggle="modal" data-target="#modalEdit" data-overlaySpeed="200" data-animation="fadein" wire:click="getItem({{ $value->id }})" style="color: white">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                                <td colspan="4" style="text-align: right"><b>Total:</b></td>
                                                <td style="text-align: right"><b>{{ $refund_total }}</b></td>
                                                <td></td>
                                        </tr>
                                    </tbody>
                
                                </table>
                
                            </div>
                        @endif


                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            
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
                            <h4 class="modal-title">Add Category</h4>
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
                                        <strong>Bill No:</strong>
                                        <input type="text" class="form-control" name="bill_no" placeholder="Bill No" required wire:model="bill_no">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Description:</strong>
                                        <textarea class="form-control input-lg" name="description" placeholder="Description" required wire:model="description"></textarea>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Amount:</strong>
                                        <input type="text" class="form-control" name="amount" placeholder="Amount" required wire:model="amount">
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
                            <h4 class="modal-title">Edit Category</h4>
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
                                        <strong>Bill No:</strong>
                                        <input type="text" class="form-control" name="e_bill_no" placeholder="Bill No" required wire:model="e_bill_no">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Description:</strong>
                                        <textarea class="form-control input-lg" name="e_description" placeholder="Description" required wire:model="e_description"></textarea>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                        <strong>Amount:</strong>
                                        <input type="text" class="form-control" name="e_amount" placeholder="Amount" required wire:model="e_amount">
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
