<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock Report</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h4>Stock Report</h4>
    <h5>Date: {{ Carbon\Carbon::now() }}</h5>
    <h3 style="color: red">Total Stock Cost Value: {{ all_stock_cost_value($products_collection) }}</h3>
    <h3 style="color: red">Total Stock Sell Value: {{ all_stock_sell_value($products_collection) }}</h3>
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
            @foreach ($products_collection as $product)
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
                <tr>
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
                <br>
            @endforeach
        </tbody>
    </table>
</body>
</html>