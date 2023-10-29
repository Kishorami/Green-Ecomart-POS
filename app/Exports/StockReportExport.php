<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class StockReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public  $data;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data)
     {
        $this->data = $data;
     }
    public function collection()
    {
        $data = collect();    

        foreach($this->data['products_collection'] as $product){
            foreach ($product as $key => $value) {
                $temp = collect();

                $temp['id'] = $key+1;
                $temp['batch'] = $value->batch->batch_code;
                $temp['item'] = $value->item_description .' : '. $value->sku;
                $temp['unit'] = $value->unit->name;
                $temp['unit_price'] = $value->unit_price;
                $temp['sell_price'] = $value->sell_price ;
                $temp['sold'] = $value->sold ;
                $temp['stock'] = $value->stock ;
                $temp['stock_cost_value'] = $value->stock * $value->unit_price ;
                $temp['stock_sell_value'] = $value->stock * $value->sell_price ;

                $data->push($temp);
            }

                $temp = collect();

                $temp['id'] = '';
                $temp['batch'] = '';
                $temp['item'] = '';
                $temp['unit'] = '';
                $temp['unit_price'] = '';
                $temp['sell_price'] = 'Total';
                $temp['sold'] = stock_info($product)['sold_total'];
                $temp['stock'] = stock_info($product)['stock_total'];
                $temp['stock_cost_value'] = stock_cost_value($product);
                $temp['stock_sell_value'] = stock_sell_value($product);

                $data->push($temp);

                for ($i=0; $i < 2; $i++) { 
                    $temp = collect();

                    $temp['id'] = '';
                    $temp['batch'] = '';
                    $temp['item'] = '';
                    $temp['unit'] = '';
                    $temp['unit_price'] = '';
                    $temp['sell_price'] = '';
                    $temp['sold'] = '';
                    $temp['stock'] = '';
                    $temp['stock_cost_value'] = '';
                    $temp['stock_sell_value'] = '';

                    $data->push($temp);
                }

            
        }
                
        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A6:W6'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
             
            },
        ];
    }
    
    //function header in excel
     public function headings(): array
     {
         return [
            [
                'Stock Report',
            ],
            [
                'Created Date: '.Carbon::now(),
            ],
            [
                'Total Stock Cost Value: '.all_stock_cost_value($this->data['products_collection']),
            ],
            [
                'Total Stock Sell Value: '.all_stock_sell_value($this->data['products_collection']),
            ],
            [],
            [
                'S/N',
                'Batch Code',
                'Item : SKU',
                'Unit',
                'Unit Price/Cost',
                'Sell Price ',
                'Sold',
                'Stock',
                'Stock Cost Value',
                'Stock Sell Value',
            ]
        ];
    }
}
