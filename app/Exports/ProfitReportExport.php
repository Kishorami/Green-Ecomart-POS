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

class ProfitReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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

        foreach ($this->data['reports'] as $key => $value) {
            $temp = collect();

            $temp['id'] = $value->id;
            $temp['bill_no'] = $value->bill_no;
            $temp['customer_id'] = $value->customer->name .' : '. $value->customer->code;
            $temp['total_price'] = $value->total_price;
            $temp['profit'] = $value->profit;
            $temp['created_at'] = $value->created_at;

            $data->push($temp);
        }

            $temp = collect();

            $temp['id'] = '';
            $temp['bill_no'] = '';
            $temp['customer_id'] = 'Total';
            $temp['total_price'] = $this->data['sell_total'];
            $temp['profit'] = $this->data['profit_total'];
            $temp['created_at'] = '';

            $data->push($temp);

        // dd($data);

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A4:W4'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
             
            },
        ];
    }
    
    //function header in excel
     public function headings(): array
     {
         return [
            [
                'Profit Report of '.$this->data['day'],
            ],
            [
                'Created Date: '.Carbon::now(),
            ],
            [],
            [
                'Id',
                'Bill No',
                'Customer',
                'Total Price',
                'Profit',
                'Sell Date'
            ]
        ];
    }
}
