<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Sell;
use Illuminate\Http\Request;
use PDF;
class InvoiceController extends Controller
{
    public function old_invoice($sell_id)
    {
        $sell_info = Sell::where('id',$sell_id)->with('user','customer','payment_method')->first();

        $shop_info = Configuration::where('id',1)->select('company_name','address_line_1','address_line_2','phone','logo_sm')->first();

        $data = [
            'shop_info' => $shop_info,
            'sell_info' => $sell_info,
            'customer_info' => $sell_info->customer,
            'products'=> json_decode($sell_info->products),
        ];

        // dd($sell_info);
        // return view('livewire.sell.sell.old_invoice',$data);
        $pdf = PDF::loadView('livewire.sell.sell.old_invoice', $data);

        return $pdf->stream($shop_info->company_name.'_invoice_no_'. $sell_info->bill_no.'.pdf');
    }

    public function new_invoice($sell_id)
    {
        $sell_info = Sell::where('id',$sell_id)->with('user','customer','payment_method')->first();

        $shop_info = Configuration::where('id',1)->select('company_name','address_line_1','address_line_2','phone','logo_sm')->first();

        $data = [
            'shop_info' => $shop_info,
            'sell_info' => $sell_info,
            'customer_info' => $sell_info->customer,
            'products'=> json_decode($sell_info->products),
        ];

        // dd($sell_info);
        return view('livewire.sell.sell.invoice',$data);
    }
}
