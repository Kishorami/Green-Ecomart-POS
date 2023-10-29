<div class="col-lg-12">
    <div class="card card-inverse text-white" style="background-color: #222b13; border-color: #222b13;">
        <div class="card-body">
            <blockquote class="card-bodyquote mb-0">
                <strong style="font-size: 1rem">Top Sold Products</strong>
                <table class="table table-bordered dt-responsive nowrap text-white">
                    <thead class="mb-0">
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Sold (QTY)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($top_sold_products as $key=>$value)
                            <tr style="text-align: center">
                                <td>{{ $value['product'] }}</td>
                                <td>{{ $value['sku'] }}</td>
                                <td>{{ $value['sold_qty'] }}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </blockquote>
        </div>
    </div> <!-- end card-box-->
</div>