<div>

    @section('title',env('App_NAME') .' | '.'Customer Ledger')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ env('App_NAME') }}</li>
                                <li class="breadcrumb-item">Customers</li>
                                <li class="breadcrumb-item active">Customer Ledger</li>
                                
                            </ol>
                        </div>
                        <h4 class="page-title">Customer Ledger</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="header-title mb-1">Customer Information</h4>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <strong>Name: {{ $customer->name }}</strong><br>
                                <strong>Phone: {{ $customer->phone }}</strong>
                            </div>
                            <div class="col-sm-6 text-right">
                                <h3 style="color: red">Total Due: {{ number_format((float)($customer->total_due), 2, '.', '') }}</h3>
                                <a class="btn btn-success"
                                    data-toggle="modal" data-target="#modalAdd" data-overlaySpeed="200" data-animation="fadein" 
                                    style="color: white;">
                                    Receive Payment
                                </a>
                            </div>
                        </div>
                        
                        <hr>
                        

                        <div class="row">
                            
                            <div class="col-sm-12">
                                <h4 class="header-title mb-0">Records</h4>
                                <hr>

                                <table class="table table-bordered dt-responsive nowrap data-table-customers" width="100%">
                                    <thead>
                                    <tr style="text-align: center;">
                                        <th width="5%">S/N</th>
                                        <th width="5%">Particulars</th>
                                        <th width="10%">Bill No</th>
                                        <th width="10%">Due</th>
                                        <th width="10%">Paid</th>
                                        <th width="10%">Total Due</th>
                                        <th width="5%">Payment Method</th>
                                        <th width="15%">Note</th>
                                        <th width="10%">Date</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($ledgers as $key=>$value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->particulars }}</td>
                                                <td style="text-align: center;">{{ $value->bill_no }}</td>
                                                <td style="text-align: right">{{ number_format((float)($value->due_amount), 2, '.', '') }}</td>
                                                <td style="text-align: right">{{ number_format((float)($value->payment_amount), 2, '.', '') }}</td>
                                                <td style="text-align: right">{{ number_format((float)($value->total_due), 2, '.', '') }}</td>
                                                <td style="text-align: center;">{{ $value->payment_method->name }}</td>
                                                <td>{{ $value->note }}</td>
                                                <td style="text-align: center;">{{ Carbon\Carbon::parse($value->created_at)->format('d F, Y') }}</td>
                                                <td style="text-align: center;">
                                                    @if($value->particulars === 'Bill')
                                                    <a class="btn btn-primary btn-sm"
                                                         data-toggle="modal" data-target="#modalDetails" data-overlaySpeed="200" data-animation="fadein" 
                                                         style="color: white;" wire:click="getItem({{ $value->bill_no }})">Details</a>
                                                    @else
                                                    <a class="btn btn-warning btn-sm"
                                                         data-toggle="modal" data-target="#modalEdit" data-overlaySpeed="200" data-animation="fadein" 
                                                         style="color: white;" wire:click="getItemEdit({{ $value->id }})">Edit</a>
                                                    
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $ledgers->links() }}
                            </div>

                            

                        </div> <!-- end row-->
                        
                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

    <!--==========================
      =  Modal window for Details    =
      ===========================-->
    <!-- sample modal content -->
    <div wire:ignore.self id="modalDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <!--=====================================
                        MODAL HEADER
                    ======================================-->  
                    <div class="modal-header" style="color: white">
                        <h4 class="modal-title">Sell Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                      <!--=====================================
                        MODAL BODY
                      ======================================-->
                    <div class="modal-body">
                        <div class="box-body">
                            <table class="table table-bordered dt-responsive nowrap data-table-customers" width="100%">
                                @if ($flag)

                                <h3>Date: {{ $invoice->updated_at }}</h3>
                                <h5>Bill No: {{ $invoice->bill_no }}</h5>
                                    <thead style="background-color: lightgray;">
                                        <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price BDT</th>
                                        <th>Total BDT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                
                                        @foreach ($products as $key=>$value)
                                
                                            <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>{{ $value->name }}</td>
                                                <td align="center">{{ $value->quantity }}</td>
                                                <td align="right">{{ number_format((float)($value->price), 2, '.', '') }}</td>
                                                <td align="right">{{ number_format((float)($value->quantity * $value->price), 2, '.', '') }}</td>
                                            </tr>
                                
                                        @endforeach
                                
                                    </tbody>
                                    
                                    
                                    <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td align="right">Subtotal BDT</td>
                                                <td align="right">{{ number_format((float)($invoice->net_price), 2, '.', '') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td align="right">Tax BDT</td>
                                                <td align="right">{{ number_format((float)($invoice->vat_amount), 2, '.', '') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td align="right">Reward Point Discount</td>
                                                <td align="right">{{ number_format((float)($invoice->points_discount), 2, '.', '') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td align="right">Total BDT({{ $invoice->vat_percent }}%)</td>
                                                <td align="right" class="gray">{{ number_format((float)($invoice->total_price), 2, '.', '') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td align="right">Paid BDT</td>
                                                <td align="right">{{ number_format((float)($invoice->paid), 2, '.', '') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td align="right">Due BDT</td>
                                                <td align="right">{{ number_format((float)($invoice->due), 2, '.', '') }}</td>
                                            </tr>
                                    </tfoot>
                                @endif
                                  
                            </table>
                        </div>
                    </div>


                <!--=====================================
                MODAL FOOTER
                ======================================-->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


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
                        <h4 class="modal-title">Receive Payment</h4>
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
                                        <strong>Payment Date:</strong>
                                        <input type="date" class="form-control input-lg" name="date" required wire:model="date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">          
                                <div class="input-group">             
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Amount:</strong>
                                    <input type="number" class="form-control input-lg" name="paid_amount" placeholder="Amount" required wire:model="paid_amount" autocomplete="off">
                                  </div>
                                </div>
                            </div>

                            <div class="form-group">          
                                <div class="input-group">             
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Payment Method:</strong>
                                    <select class="form-control input-lg" name="payment_method_id" required wire:model="payment_method_id">
                                        <option value="">Select Payment Method</option>
                                        @foreach ($payment_methods as $key=>$value)
                                        <option value="{{ $value->id }}">{{ $value->id }} : {{ $value->name }}</option>
                                        @endforeach
                                    </select>
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
      =  Modal window for Add Customers    =
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
                        <h4 class="modal-title">Edit Payment</h4>
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
                                        <strong>Payment Date:</strong>
                                        <input type="datetime-local" class="form-control input-lg" name="date" required wire:model="e_date">
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
