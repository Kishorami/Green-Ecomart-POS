<div>

    @section('title',env('App_NAME') .' | '.'Profit/Loss Report')

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
                                <li class="breadcrumb-item active">Profit/Loss Report</li>
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Profit/Loss Report</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <div class="row header-title">
                            <div class="col-sm-4">
                                <h4 class="header-title mb-0">Profit/Loss Report</h4>
                            </div>
                            <div class="col-sm-4 text-center">
                                <div><strong>&nbsp;</strong></div>
                                <a class="btn ntn-sm btn-success text-white" wire:click="today()">Today</a>
                                <a class="btn ntn-sm btn-primary text-white" wire:click="last_seven_days()">last 7 Days</a>
                                <a class="btn ntn-sm btn-secondary text-white" wire:click="previous_month()">Previous Month</a>
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
                        </div>
                        <hr>

                        @if ($reports)
                            <div class="card container">

                                <h4 class="header-title mb-2 mt-3 text-center">
                                    Profit/Loss of 
                                    <span style="color: red">

                                        {{-- {{ Carbon\Carbon::parse($month)->format('F, Y') }} --}}
                                        @if ($flag === 'today')
                                            Today &nbsp;( {{ Carbon\Carbon::now()->format('d F, Y') }} )
                                        @elseif($flag === 'last_seven_days')
                                            Last 7 Days &nbsp;( From: {{ Carbon\Carbon::now()->subDays(7)->format('d F, Y') }} - To: {{ Carbon\Carbon::now()->format('d F, Y') }} )
                                        @elseif($flag === 'previous_month')
                                            {{ Carbon\Carbon::now()->subMonth()->format('F, Y') }}
                                        @elseif($flag === 'this_month')
                                            {{ Carbon\Carbon::now()->format('F, Y') }}
                                        @else
                                            From: {{ Carbon\Carbon::parse($from)->subDays(7)->format('d F, Y') }} - To: {{ Carbon\Carbon::parse($to)->format('d F, Y') }}
                                        @endif
                                    </span>
                                    <a href="{{ route('profit_loss_report_pdf',['from' =>$from,'to'=>$to,'flag'=>$flag ?? 'day']) }}" class="btn btn-sm btn-danger float-right ml-2" target="_blank">Print To PDF</a>
                                    <a href="{{ route('profit_loss_report_excel',['from' =>$from,'to'=>$to,'flag'=>$flag ?? 'day']) }}" class="btn btn-sm btn-success float-right ml-2" target="_blank">Print To Excel</a>
                                </h4>

                                <table class="table table-bordered dt-responsive nowrap data-table-categories" width="100%" style="text-align: center">
                                    
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Sell Date</th>
                                            <th>Bill No</th>
                                            <th>Customer</th>
                                            <th>Total Amount</th>
                                            <th>Total Profit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                
                                    <tbody>
                                        @foreach ($reports as $key=>$value)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $value->created_at }}</td>
                                                <td>{{ $value->bill_no }}</td>
                                                <td>{{ $value->customer->name }} : {{ $value->customer->code }}</td>
                                                <td style="text-align: right">{{ $value->total_price }}</td>
                                                <td style="text-align: right">{{ $value->profit }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-warning waves-effect btn-sm" data-toggle="modal" data-target="#modalView" data-overlaySpeed="200" data-animation="fadein" wire:click="get_item({{ $value->id }})" style="color: white">View Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style="color: red">
                                                <td colspan="4" style="text-align: right"><b>Total:</b></td>
                                                <td style="text-align: right"><b>{{ $sell_total }}</b></td>
                                                <td style="text-align: right"><b>{{ $profit_total }}</b></td>
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
        <div wire:ignore.self id="modalView" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    {{-- <form role="form" enctype="multipart/form-data" wire:submit.prevent="Store()">
                        @csrf --}}
                        <!--=====================================
                            MODAL HEADER
                        ======================================-->  
                          <div class="modal-header">
                            <h4 class="modal-title">Bill No: {{ $bill_no }}, <b style="color: red">Profit: {{ $profit }}</b></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            
                          </div>
                          <!--=====================================
                            MODAL BODY
                          ======================================-->
                          <div class="modal-body">
                            <div class="box-body">
                                

                                <table class="table table-bordered table-striped dt-responsive tables" width="100%">
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
                                        @if($sell)
                                          @foreach (json_decode($sell->products) as $key=>$value)
                                  
                                              <tr>
                                                  <th scope="row">{{ $key+1 }}</th>
                                                  <td>{{ $value->name }}</td>
                                                  <td align="right">{{ $value->quantity }}</td>
                                                  <td align="right">{{ $value->price }}</td>
                                                  <td align="right">{{ $value->quantity * $value->price }}</td>
                                              </tr>
                                  
                                          @endforeach
                                        @endif
                                      </tbody>
                                  
                                      {{-- <tfoot>
                                          <tr>
                                              <td colspan="3"></td>
                                              <td align="right">Subtotal BDT</td>
                                              <td align="right">{{ $invoice->net_price }}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="3"></td>
                                              <td align="right">Tax BDT</td>
                                              <td align="right">{{ $invoice->vat_amount }}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="3"></td>
                                              <td align="right">Total BDT({{ $invoice->vat_percent }}%)</td>
                                              <td align="right" class="gray">{{ $invoice->total_price }}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="3"></td>
                                              <td align="right">Paid BDT</td>
                                              <td align="right">{{ $invoice->paid }}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="3"></td>
                                              <td align="right">Due BDT</td>
                                              <td align="right">{{ $invoice->due }}</td>
                                          </tr>
                                      </tfoot> --}}
                                </table> 
                                  
                              
                            </div>
                          </div>
                          <!--=====================================
                            MODAL FOOTER
                          ======================================-->
                          <div class="modal-footer">
                            {{-- <button type="submit" class="btn btn-success waves-effect waves-light">Add</button> --}}
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            
                          </div>
                    {{-- </form> --}}
                    
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

</div>
