<?php

namespace App\Http\Controllers;

use App\Models\BatchedItem;
use PDF;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function index(Request $request,$id)
    {

        $product = BatchedItem::find($id);

        $generatorHTML = new BarcodeGeneratorHTML();
        $barcode = $generatorHTML->getBarcode($product->sku, $generatorHTML::TYPE_CODE_128,2,70);

        // $data['barcode'] = $barcode;TYPE_CODE_128_C
        $data = [
            'barcode' => $barcode,
            'product' =>$product
        ];

        // dd($product);

        $customPaper = array(0,0,150.00,250.00);

        $pdf = PDF::loadView('livewire.inventory.product.barcode', $data)->setPaper($customPaper, 'landscape');

        // dd($pdf);

        // return $pdf->download($product->name.'_barcode.pdf');
        return $pdf->stream($product->name.'_barcode.pdf');
    }
}
