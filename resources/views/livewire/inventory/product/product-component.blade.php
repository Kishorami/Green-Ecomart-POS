<div>


    @section('title',env('App_NAME') .' | '.'Product Information')

    @push('styles')
        <style>
            #exampleDataList::-webkit-calendar-picker-indicator {
                display: none !important;
            }
        </style>
    @endpush

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
                                <li class="breadcrumb-item active">Product Information</li>
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Product Information</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="header-title mb-4">Search Products</h4>

                        <div class="col-md-8 offset-md-2">

                            <div class="card container">
                                <form class="form-inline" enctype="multipart/form-data" wire:submit.prevent="search()">
                                    @csrf
                                    
                                    
                                    <div class="col-md-8">
                                        <input class="form-control" type="search" autocomplete="off"  list="datalistOptions" id="exampleDataList" placeholder="Type to search..." style="width: 100%" wire:change="goal($event.target.value)" wire:model="temp_input">
                                        @if (strlen($temp_input) >= 3)
                                           <datalist id="datalistOptions">
                                            
                                                @foreach ($allProducts as $key=>$value)
                                                    <option value="{{ $value->sku }} : {{ $value->item_description }}">{{ $value->sku }} : {{ $value->item_description }}
                                                        </option>
                                                @endforeach
                                                
                                            </datalist> 
                                        @endif
                                        
                                    </div>

                                    
                                    <div class="col-md-4" style="text-align: center">
                                        <button type="submit" class="btn btn-primary" >Search</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                        
                        <div class="col-md-12">
                            @if($search)
                                <h4 class="header-title mb-2 mt-2" style="text-align: center">Search Result For "<span style="color: red">{{ $result_name }}</span>"</h4>
                            @else
                                <h4 class="header-title mb-2 mt-2" style="text-align: center"></h4>
                            @endif
                        </div>

                        <div class="card container">

                            <table class="table table-bordered dt-responsive nowrap data-table-categories" width="100%" style="text-align: center">
                                
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Batch Code</th>
                                        <th>Category</th>
                                        <th>Item Description</th>
                                        <th>SKU</th>
                                        <th>Unit</th>
                                        <th>Unit Price</th>
                                        <th>Sell Price</th>
                                        <th>QTY</th>
                                        <th>Sold</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
            
                                <tbody>
                                    @if (count($products)==0 && $search != "")
                                        <tr>
                                            <td colspan="12" class="text-center">
                                                <h3 style="color: red;">No Product Found</h3>
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach ($products as $product)
                                        @foreach($product as $key=>$value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->batch->batch_code }}</td>
                                                <td>{{ $value->category->name }}</td>
                                                <td>{{ $value->item_description }}</td>
                                                <td>{{ $value->sku }}</td>
                                                <td>{{ $value->unit->name }}</td>
                                                <td>{{ $value->unit_price }}</td>
                                                <td>{{ $value->sell_price }}</td>
                                                <td>{{ $value->quantity }}</td>
                                                <td>{{ $value->sold }}</td>
                                                <td>{{ $value->stock }}</td>
                                                <td>
                                                    <a href="{{ route('barcode', $value->id) }}" class="btn btn-primary btn-sm mr-1" style="color: black" target="_blank"><i class="fas fa-barcode mr-2"></i>Barcode</a>

                                                    <a href="{{ route('edit_batched_products', $value->id) }}" class="btn btn-warning btn-sm" style="color: black"><i class="fas fa-pen-fancy mr-2"></i>Edit</a>
                                                </td>
                                            </tr>
            
                                        @endforeach
                                        <tr>
                                            <th colspan="10" style="text-align:right;">Total Stock</th>
                                            <th>{{ stock_info($product)['stock_total'] }}</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="12" style="text-align:right;"></th>
                                        </tr>
                                    @endforeach
                                </tbody>
            
                            </table>
            
                        </div>

                        
                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

            
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->


</div>
