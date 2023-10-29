<!-- Products -->
<div class="col-md-5">

    <div class="card card-olive card-outline">
        <div class="card-header">
            <h3 class="card-title mb-0 mt-0">Products</h3>
        </div>
        <div class="card-body">

            <div>
                
                <input class="form-control mb-3"type="search" list="datalistOptions" id="exampleDataList" placeholder="Product Name/SKU/Barcode" autofocus  wire:keydown.enter="addWithBarcode($event.target.value)" wire:model="barcode" autocomplete="off">

                @if (strlen($barcode) >2)
                
                   <datalist id="datalistOptions">
                    
                        @foreach ($allProducts as $key=>$value)
                            {{-- <option value="{{ $value->sku }} : {{ $value->item_description }}"> --}}
                            <option value="{{ $value->sku }}">{{ $value->item_description }}</option>
                        @endforeach
                        
                    </datalist> 
                    
                @endif
            </div>

            <div class="d-flex justify-content-between">
                {{-- <input type="text" name="barcode" class="form-control col-md-3" placeholder="Barcode / SKU" autofocus  wire:keydown.enter="addWithBarcode($event.target.value)" wire:model="barcode"> --}}
                <strong>Search Products</strong>
                <input type="search" wire:model.debounce.300ms="search" class="form-control" placeholder="Search Products">
            </div>
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Desc.</th>
                        <th>Batch Code</th>
                        <th>SKU</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        @foreach($product as $key=>$value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->item_description }}</td>
                                <td>{{ $value->batch->batch_code }}</td>
                                <td>{{ $value->sku }}</td>
                                <td style="text-align: right">{{ $value->stock }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" wire:click="addToList('{{ $value->id }}')" style="color: white">Add</a>
                                </td>
                            </tr>

                        @endforeach
                        <tr>
                            <th colspan="4" style="text-align:right;">Total Stock</th>
                            <th style="text-align: right">{{ stock_info($product)['stock_total'] }}</th>
                            <th></th>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- Products -->