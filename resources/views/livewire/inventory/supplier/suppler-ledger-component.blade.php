<div>

    @section('title',env('App_NAME') .' | '.'Ledger')

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
                                <li class="breadcrumb-item active">Suppliers</li>
                                <li class="breadcrumb-item active">Ledger</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Supplier Ledger</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-2">
                                <h4>Ledger of: {{ $supplier_info->name }}</h4>
                            </div>
                            <div class="col-8">

                            </div>
                            <div class="col-2">
                                <a class="btn btn-success btn-sm float-right text-white" data-toggle="modal" data-target="#modalAdd">New Payment</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            
                            <div class="col-sm-4">
                                <strong>Name:</strong> {{ $supplier_info->name }}<br>
                                <strong>Code:</strong> {{ $supplier_info->code }}<br>
                                <strong>Contact:</strong> {{ $supplier_info->contact }}<br>
                                <strong>Address:</strong> {{ $supplier_info->address }}<br>
                                <strong>Payment Info:</strong> {{ $supplier_info->payment_info }}
                            </div>
                            <div class="col-sm-4">
                                <strong>Payment Info</strong> <br>
                                {{ $supplier_info->payment_info }}
                            </div>

                            <div class="col-sm-4 text-center">
                                <h3 class="m-0" style="color: red;">Total Due BDT</h3> <br>
                                <h3 class="m-0" style="color: red;">{{ $total_due }}</h3>
                            </div>

                        </div> <!-- end row-->
                        <hr>
                        <div>
                            <table id="datatable-makesales" class="table table-bordered table-striped nowrap data-table-makesales" style="overflow-wrap: anywhere;" width="100%">
                                <thead style="text-align: center;">
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Particulars</th>
                                    <th>Batch</th>
                                    <th>Due Amount</th>
                                    <th>Payment Amount</th>
                                    <th>Total Due</th>
                                    <th width="10%">Payment Method</th>
                                    <th width="15%">Note</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
    
                                <tbody>
                                    @foreach($records as $key=>$value)
                                        <tr>
                                            
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->created_at }}</td>
                                            <td>{{ ucfirst($value->particulars) }}</td>
                                            <td>{{ $value->batch->batch_code ?? "" }}</td>
                                            <td style="text-align:right;">{{ $value->due_amount }}</td>
                                            <td style="text-align:right;">{{ $value->payment_amount }}</td>
                                            <td style="text-align:right;">{{ $value->total_due }}</td>
                                            <td>{{ $value->paymentMethod->name }}</td>
                                            <td>{{ $value->note }}</td>
    
                                            <td>
    
                                                @if($value->particulars != "import")
    
                                                    <div class="btn-group dropleft">
                                                        <button class="btn btn-warning dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cogs"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    
                                                        {{-- <a href="{{ route('money_receipt',['id'=>$value->id]) }}" class="dropdown-item btn btn-primary btn-sm" target="_blank"><i class="fas fa-print"></i> Print Money Receipt</a> --}}
    
                                                        <a class="dropdown-item btn btn-warning btn-sm" wire:click="getItem('{{ $value->id }}')" data-toggle="modal" data-target="#modalEdit"><i class="fas fa-pen-fancy"></i> Edit</a>
    
                                                        </div>
                                                    </div>
    
                                                @else
    
                                                    <div class="btn-group dropleft">
                                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cogs"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    
                                                        <a href="{{ route('batched_products',['id'=>$value->batch->id]) }}" class="dropdown-item btn btn-primary btn-sm" target="_blank" style="color: black;"><i class="fas fa-print"></i> View Products</a>
    
                                                        {{-- <a href="{{ route('challan',['bill_no'=>$value->bill_code]) }}" class="dropdown-item btn btn-success btn-sm" target="_blank"><i class="fas fa-print"></i> Print Challan</a> --}}
    
                                                        </div>
                                                    </div>
    
                                                @endif
                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $records->links() }}
                        </div>
                        
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
                            <h4 class="modal-title">Add Payment</h4>
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
                                            <strong>Date:</strong>
                                            <input type="datetime-local" class="form-control" name="date" placeholder="Date" required wire:model="date">
                                        </div>
                                    </div>
                                </div>
                                  
                                <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Particular:</strong>
                                            <input type="text" class="form-control" name="particulars" placeholder="Particular" required wire:model="particulars">
                                        </div>
                                    </div>
                                </div>

                                  
                                <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Payment Amount:</strong>
                                            <input type="number" class="form-control" name="payment_amount" placeholder="Payment Amount" required wire:model="payment_amount">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Payment Method:</strong>
                                            <select id="select-payment-method" class="form-control" name="payment_method_id" required wire:model="payment_method_id">
                                                <option value="">Select Payment Method</option>
                                                @foreach ($payment_methods as $key=>$value)
                                                    <option value="{{ $value->id }}">{{ $value->id }} : {{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Note:</strong>
                                            <textarea class="form-control" name="note" placeholder="Note"  wire:model="note"></textarea>
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
          =  Modal window for edit Content    =
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
                            <h4 class="modal-title">Edit Payment Info</h4>
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
                                            <strong>Date:</strong>
                                            <input type="datetime-local" class="form-control" name="e_date" placeholder="Date" required wire:model="e_date">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Particular:</strong>
                                            <input type="text" class="form-control" name="e_particulars" placeholder="Particular" required wire:model="e_particulars">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Payment Method:</strong>
                                            <select id="select-payment-method" class="form-control" name="e_payment_method_id" required wire:model="e_payment_method_id">
                                                <option value="">Select Payment Method</option>
                                                @foreach ($payment_methods as $key=>$value)
                                                    <option value="{{ $value->id }}">{{ $value->id }} : {{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" wire:ignore>          
                                    <div class="input-group">             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Note:</strong>
                                            <textarea class="form-control" name="e_note" placeholder="Note"  wire:model="e_note"></textarea>
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
