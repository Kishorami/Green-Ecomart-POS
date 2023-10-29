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

class SellReportExport implements FromCollection, WithHeadings, WithEvents
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
            $temp['products'] = $value->products;
            $temp['bill_no'] = $value->bill_no;
            $temp['customer_id'] = $value->customer->name .' : '. $value->customer->code;
            $temp['user_id'] = $value->user->name;
            $temp['payment_method_id'] = $value->payment_method->name;
            $temp['net_price'] = $value->net_price;
            $temp['paid'] = $value->paid;
            $temp['due'] = $value->due;
            $temp['vat_percent'] = $value->vat_percent;
            $temp['vat_amount'] = $value->vat_amount;
            $temp['points_earned'] = $value->points_earned;
            $temp['points_used'] = $value->points_used;
            $temp['points_discount'] = $value->points_discount;
            $temp['total_price'] = $value->total_price;
            $temp['profit'] = $value->profit;
            $temp['created_at'] = $value->created_at;

            $data->push($temp);
        }

            $temp = collect();

            $temp['id'] = '';
            $temp['products'] = '';
            $temp['bill_no'] = '';
            $temp['customer_id'] = '';
            $temp['user_id'] = '';
            $temp['payment_method_id'] = '';
            $temp['net_price'] = '';
            $temp['paid'] = '';
            $temp['due'] = '';
            $temp['vat_percent'] = '';
            $temp['vat_amount'] = '';
            $temp['points_earned'] = '';
            $temp['points_used'] = '';
            $temp['points_discount'] = 'Total';
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
                'Sell Report of '.$this->data['day'],
            ],
            [
                'Created Date: '.Carbon::now(),
            ],
            [],
            [
                'Id',
                'Products',
                'Bill No',
                'Customer',
                'Seller',
                'Payment Method',
                'Net Price',
                'Paid',
                'Due',
                'Vat Percent',
                'Vat Amount',
                'Points Earned',
                'Points Used',
                'Points Discount',
                'Total Price',
                'Profit',
                'Sell Date'
            ]
        ];
    }
}
