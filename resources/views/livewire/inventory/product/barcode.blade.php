<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }} Barcode</title>
</head>
<body>
    
    <div class="text-center">     
	    {{-- <h3>Product: {{ $product->name }}</h3>  --}}
	    Product:{{ $product->sku }}
	    {!! $barcode !!}
	</div>
  
    {{-- {{ dd($product->name) }} --}}

</body>
</html>