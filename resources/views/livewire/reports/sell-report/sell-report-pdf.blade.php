<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sell Report</title>
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
    <h4>Sell Report of {{ $day }}</h4>
    <h5>Created Date: {{ Carbon\Carbon::now() }}</h5>

    <table class="table table-bordered dt-responsive nowrap data-table-categories" width="100%" style="text-align: center">
                                    
        <thead>
            <tr>
                <th>S/N</th>
                <th>Sell Date</th>
                <th>Bill No</th>
                <th>Customer</th>
                <th>Total Amount</th>
                {{-- <th>Total Profit</th> --}}
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
                    {{-- <td style="text-align: right">{{ $value->profit }}</td> --}}
                    
                </tr>
            @endforeach
            <tr>
                    <td colspan="4" style="text-align: right"><b>Total:</b></td>
                    <td style="text-align: right"><b>{{ $sell_total }}</b></td>
                    {{-- <td style="text-align: right"><b>{{ $profit_total }}</b></td> --}}
                    
            </tr>
        </tbody>

    </table>
    
</body>
</html>