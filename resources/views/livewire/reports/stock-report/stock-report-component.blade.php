<div>

    @section('title',env('App_NAME') .' | '.'Stock Reports')

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
                                <li class="breadcrumb-item active">Stock Reports</li>
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Stock Reports</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="header-title mb-0">Products Stock</h4>

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
                                                    <option value="1">1</option>
                                                </select>
                                            </div>  
                                            <div class="col-sm-6" style="text-align: center">
                                                <a href="{{ route('stock_report_pdf',['data' =>$search]) }}" class="btn btn-sm btn-danger ml-2" target="_blank">Print To PDF</a>
                                                <a href="{{ route('stock_report_excel',['data' =>$search]) }}" class="btn btn-sm btn-success ml-2" target="_blank">Print To Excel</a>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="search" wire:model="search" class="form-control input-sm" placeholder="Search Product">
                                            </div>
                                        </div>
                                        <br>
                                        
                                        <div class="d-flex justify-content-between">
                                        <h4 style="color: red">Total Stock Cost Value: {{ all_stock_cost_value($products_collection) }}</h4>
                                        <h4 style="color: red">Total Stock Sell Value: {{ all_stock_sell_value($products_collection) }}</h4>
                                        </div>

                                        <table class="table table-bordered dt-responsive nowrap data-table-customers" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Batch Code</th>
                                                    {{-- <th>Category</th> --}}
                                                    <th>Item : SKU</th>
                                                    {{-- <th>SKU</th> --}}
                                                    <th>Unit</th>
                                                    <th>Unit Price/Cost</th>
                                                    <th>Sell Price</th>
                                                    {{-- <th>QTY</th> --}}
                                                    <th>Sold</th>
                                                    <th>Stock</th>
                                                    <th>Stock Cost value</th>
                                                    <th>Stock Sell value</th>
                                                </tr>
                                            </thead>
        
                                            <tbody>
                                                @foreach ($products as $product)
                                                    @foreach($product as $key=>$value)
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>{{ $value->batch->batch_code }}</td>
                                                            {{-- <td>{{ $value->category->name }}</td> --}}
                                                            <td>{{ $value->item_description }} : {{ $value->sku }}</td>
                                                            {{-- <td>{{ $value->sku }}</td> --}}
                                                            <td>{{ $value->unit->name }}</td>
                                                            <td style="text-align: right">{{ $value->unit_price }}</td>
                                                            <td style="text-align: right">{{ $value->sell_price }}</td>
                                                            {{-- <td style="text-align: right">{{ $value->quantity }}</td> --}}
                                                            <td style="text-align: right">{{ $value->sold }}</td>
                                                            <td style="text-align: right">{{ $value->stock }}</td>
                                                            <td style="text-align: right">{{ $value->stock * $value->unit_price}}</td>
                                                            <td style="text-align: right">{{ $value->stock * $value->sell_price}}</td>
                                                        </tr>
                        
                                                    @endforeach
                                                    <tr style="color:red">
                                                        <th colspan="6" style="text-align:right;">Total</th>
                                                        {{-- <th style="text-align: right">{{ stock_info($product)['unit_price_total'] }}</th> --}}
                                                        {{-- <th style="text-align: right">{{ stock_info($product)['sell_price_total'] }}</th> --}}
                                                        {{-- <th style="text-align: right">{{ stock_info($product)['quantity_total'] }}</th> --}}
                                                        <th style="text-align: right">{{ stock_info($product)['sold_total'] }}</th>
                                                        <th style="text-align: right">{{ stock_info($product)['stock_total'] }}</th>
                                                        <th style="text-align: right">{{ stock_cost_value($product) }}</th>
                                                        <th style="text-align: right">{{ stock_sell_value($product) }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="12" style="text-align:right;"></th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $products->links() }}
                                    </div> <!-- end card-box -->
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div>
                        
                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

</div>
