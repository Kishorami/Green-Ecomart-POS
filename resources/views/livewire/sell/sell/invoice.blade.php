
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $shop_info->company_name }}_invoice_no_{{ $sell_info->bill_no }}</title>

    <style>
        #invoice-POS {
        border: 1px solid #ddd;
        padding: 2mm;
        margin: 0 auto;
        width: 44mm;
        background: #FFF;
        }
        #invoice-POS ::selection {
        background: #f31544;
        color: #FFF;
        }
        #invoice-POS ::moz-selection {
        background: #f31544;
        color: #FFF;
        }
        #invoice-POS h1 {
        font-size: 1.5em;
        color: #222;
        }
        #invoice-POS h2 {
        font-size: 0.9em;
        }
        #invoice-POS h3 {
        font-size: 1.2em;
        font-weight: 300;
        line-height: 2em;
        }
        #invoice-POS p {
        font-size: 0.7em;
        color: #666;
        line-height: 1.2em;
        }
        #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
        /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
        }
        #invoice-POS #top {
        min-height: 100px;
        }
        #invoice-POS #mid {
        min-height: 80px;
        }
        #invoice-POS #bot {
        min-height: 50px;
        }
        #invoice-POS #top .logo {
        height: 50px;
        width: 50px;
        /* background: url(https://codeforui.com/posts/dummylogo.png) no-repeat; */
        /* background: url({{ asset('assets/images/') }}/{{ $shop_info->logo_sm }}) no-repeat; */
        background: url({{ public_path('assets\images') }}\{{ $shop_info->logo_sm }}) no-repeat;
        background-size: 50px 50px;
        }
        #invoice-POS .info {
        display: block;
        margin-left: 0;
        }
        #invoice-POS .title {
        float: right;
        }
        #invoice-POS .title p {
        text-align: right;
        }
        #invoice-POS table {
        width: 100%;
        border-collapse: collapse;
        }
        #invoice-POS .tabletitle {
        font-size: 0.5em;
        background: #EEE;
        }
        #invoice-POS .service {
        border-bottom: 1px solid #EEE;
        }
        #invoice-POS .item {
        width: 24mm;
        }
        #invoice-POS .itemtext {
        font-size: 0.5em;
        }
        #invoice-POS #legalcopy {
        margin-top: 5mm;
        }
    </style>

</head>
<body>
    
    
    <div id="invoice-POS">
    
        <center id="top">
        <div class="logo"><img class="logo" src="{{ asset('assets/images/') }}/{{ $shop_info->logo_sm }}" alt="logo"></div>
        <div class="info"> 
            {{-- <h2>{{ $shop_info->company_name }}</h2> --}}
            <p class="legal">
                <strong>{{ $shop_info->company_name }}</strong> <br>
                {{ $shop_info->address_line_1 }} {{ $shop_info->address_line_2 }} <br>
                {{ $shop_info->phone }}
            </p>
          </div>
        </center>
        
        <div id="mid">
          <div class="info">
            {{-- <strong>Customer Info</strong> --}}
            <p class="legal"> 
                <strong>Customer Info</strong><br>
                Name : {{ $customer_info->name }}</br>
                @if($customer_info->id !=1)
                Phone   : {{ $customer_info->phone }}</br>
                Reward Points   : {{ $customer_info->points }} (While Printing this Invoice)</br>
                @endif
            </p>
          </div>
        </div><!--End Invoice Mid-->
        <div>
            <div class="info">
              <p class="legal"> 
                  <strong>Invoice No: {{ $sell_info->bill_no }}</strong><br>
                  Date : {{ Carbon\Carbon::parse($sell_info->created_at)->format('jS, F Y h:i:s A') }}
              </p>
            </div>
        </div><!--End Invoice Mid-->
        
        <div id="bot">
    
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item"><h2>Item</h2></td>
                        <td class="Hours"><h2>Qty</h2></td>
                        <td class="Rate"><h2>Price</h2></td>
                        <td class="Rate"><h2>Total</h2></td>
                    </tr>

                    @foreach ($products as $key=>$value)
                        <tr class="service">
                            <td class="tableitem"><p class="itemtext">{{ $value->name }}</p></td>
                            <td class="tableitem"><p class="itemtext">{{ $value->quantity }}</p></td>
                            <td class="tableitem"><p class="itemtext">{{ number_format((float)$value->price, 2, '.', '') }}</p></td>
                            <td class="tableitem"><p class="itemtext">{{ number_format((float)$value->price, 2, '.', '') }}</p></td>
                        </tr>
                    @endforeach
                    
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Sub Total</h2></td>
                        <td class="payment"><h2>{{ number_format((float)$sell_info->net_price, 2, '.', '') }}</h2></td>
                    </tr>
                    @if ($sell_info->vat_percent > 0)
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>VAT/Tax({{ $sell_info->vat_percent }}%):</h2></td>
                        <td class="payment"><h2>{{ number_format((float)$sell_info->vat_amount, 2, '.', '') }}</h2></td>
                    </tr>
                    @endif
                    @if ($sell_info->points_used > 0)
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Reward Points Used({{ $sell_info->points_used }}):</h2></td>
                        <td class="payment"><h2>{{ number_format((float)$sell_info->points_discount, 2, '.', '') }}</h2></td>
                    </tr>
                    @endif
                    

                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Grand Total (Payable)</h2></td>
                        <td class="payment"><h2>{{ number_format((float)$sell_info->total_price, 2, '.', '') }}</h2></td>
                    </tr>

                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Paid Amount</h2></td>
                        <td class="payment"><h2>{{ number_format((float)$sell_info->paid, 2, '.', '') }}</h2></td>
                    </tr>
                    @if ($sell_info->paid > $sell_info->total_price)
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Change</h2></td>
                        <td class="payment"><h2>{{ number_format((float)($sell_info->paid - $sell_info->total_price), 2, '.', '') }}</h2></td>
                    </tr>
                    @elseif($sell_info->paid > 0)
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Due Amount</h2></td>
                        <td class="payment"><h2>{{ number_format((float)($sell_info->due), 2, '.', '') }}</h2></td>
                    </tr>
                    @endif

                </table>
            </div>
            <div>
                <p class="legal">
                    Reward Points Earned: {{ $sell_info->points_earned }} <br>
                    (This reward points can be used on your next Purchase.)

                </p>
            </div>
            {{-- <div id="legalcopy">
                <p class="legal"><strong>Thank you for your business!</strong>  Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices. 
                </p>
            </div> --}}
            <div id="legalcopy">
                <p class="legal"><strong>Thank you for your Purchase!</strong> 
                </p>
            </div>

        </div>
      </div>





    <script>
        window.onload= function() {
            window.print(); //This will print the invoice
            window.onafterprint = function(event) {
                window.location.href = '{{ route('make_sell')}}'
            }
        }
    </script>
</body>
</html>