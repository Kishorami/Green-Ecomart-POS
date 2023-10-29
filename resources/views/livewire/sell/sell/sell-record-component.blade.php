<div>

    @section('title',env('App_NAME') .' | '.'Sell Record')

    {{-- overflow-y:scroll;
    height:200px; --}}

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
                                <li class="breadcrumb-item active">Sell Record</li>
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Sell Record</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title mb-0">Sales</h3>
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
                                        <input type="search" wire:model="search" class="form-control input-sm" placeholder="Search Bill Code, Customer, Customer Code, Seller">
                                    </div>
                                </div>
                                <br>
                                
                                <table class="table table-bordered dt-responsive nowrap data-table-sales text-center" width="100%">
                                    <thead>
                                     <tr id="" style="text-align: center;">
                                        <th>S/N</th>
                                        <th>Bill Code</th>
                                        <th>Customer</th>
                                        <th>Customer Code</th>
                                        <th>Seller</th>
                                        <th>Total</th>
                                        <th>Grand Total</th>
                                        <th>Method</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                     </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($sells as $key=>$value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->bill_no }}</td>
                                                <td>{{ $value->customer->name }}</td>
                                                <td>{{ $value->customer->code }}</td>
                                                <td>{{ $value->user->name }}</td>
                                                <td style="text-align: right">{{ number_format((float)($value->net_price), 2, '.', '') }}</td>
                                                <td style="text-align: right">{{ number_format((float)($value->total_price), 2, '.', '') }}</td>
                                                <td>{{ $value->payment_method->name }}</td>
                                                <td style="text-align: right">{{ number_format((float)($value->paid), 2, '.', '') }}</td>
                                                <td style="text-align: right">{{ number_format((float)($value->due), 2, '.', '') }}</td>
                                                <td>{{ Carbon\Carbon::parse($value->created_at)->format('d F, Y') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                      <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cogs"></i>
                                                      </button>
                                                      <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('old_invoice', $value->id) }}" class="btn btn-info btn-sm dropdown-item" target="_blank" style="color: black"><i class="fas fa-print"></i>&nbsp; Print Invoice</a>

                                                        {{-- {{ auth()->user()->user_type }} --}}

                                                        {{-- @if(!(auth()->user()->user_type === 'cashier')) --}}
                                                        {{-- <a class="btn btn-success btn-sm dropdown-item" data-toggle="modal" data-target="#modalEdit" wire:click="getItem({{ $value->id }})"><i class="fas fa-arrow-up"></i>&nbsp; Due Adjust</a> --}}

                                                        {{-- <a href="{{ route('sell_edit', $value->id) }}" class="btn btn-warning btn-sm dropdown-item" ><i class="fas fa-pen-fancy"></i>&nbsp; Edit Sale</a> --}}
                                                        {{-- @endif --}}

                                                      </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                                {{ $sells->links() }}
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div>
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

</div>
