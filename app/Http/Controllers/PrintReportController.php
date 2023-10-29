<?php

namespace App\Http\Controllers;

use App\Models\BatchedItem;
use App\Models\Sell;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
class PrintReportController extends Controller
{
    public function stock_report($data="")
    {
        $products_collection = BatchedItem::where('stock','>',0)->with('batch')->search(trim($data))->get()->groupBy('sku');
        // dd($products_collection);

        $data = [
            'products_collection' => $products_collection,
        ];

        $pdf = PDF::loadView('livewire.reports.stock-report.stock_report_pdf', $data);

        return $pdf->stream(Carbon::now().'_stock_report.pdf');
    }

    public function sell_report($from,$to,$flag='')
    {
        $reports = Sell::whereBetween('created_at', [$from, Carbon::parse($to)->addDays(1)])->with('customer')->get();

        $data = self::make_data($reports,$from,$to,$flag);

        $pdf = PDF::loadView('livewire.reports.sell-report.sell-report-pdf', $data);

        return $pdf->stream(Carbon::now().'_sell_report.pdf');
    }

    public function due_sell_report($from,$to,$flag='')
    {
        $reports = Sell::whereBetween('created_at', [$from, Carbon::parse($to)->addDays(1)])->where('due','>', 0)->with('customer')->get();

        $data = self::make_data($reports,$from,$to,$flag);

        $pdf = PDF::loadView('livewire.reports.due-sells-report.due-sell-report-pdf', $data);

        return $pdf->stream(Carbon::now().'_due_sell_report.pdf');
    }



    public function profit_loss_report($from,$to,$flag='')
    {
        $reports = Sell::whereBetween('created_at', [$from, Carbon::parse($to)->addDays(1)])->with('customer')->get();

        $data = self::make_data($reports,$from,$to,$flag);

        $pdf = PDF::loadView('livewire.reports.profit-loss-report.profit-loss-report-pdf', $data);

        return $pdf->stream(Carbon::now().'_profit_loss_report.pdf');
    }

    public function get_day($from,$to,$flag)
    {
        $day='';
        if ($flag === 'today'){
            $day= 'Today '. '(' . Carbon::now()->format('d F, Y') . ')';
        }
        elseif($flag === 'last_seven_days'){
            $day= 'Last 7 Days' . '( From:'. Carbon::now()->subDays(7)->format('d F, Y') .'- To:'. Carbon::now()->format('d F, Y') .' )';
        }
        elseif($flag === 'previous_month'){
            $day= Carbon::now()->subMonth()->format('F, Y');
        }
        elseif($flag === 'this_month'){
            $day= Carbon::now()->format('F, Y');
        }
        else{
            $day= '(From:'. Carbon::parse($from)->subDays(7)->format('d F, Y') .'- To:'.Carbon::parse($to)->format('d F, Y').')';
        }

        return $day;
    }

    public function make_data($reports,$from,$to,$flag)
    {
        
        $day=self::get_day($from,$to,$flag);

        $sell_total = 0;
        $profit_total = 0;
        $due_total = 0;
        $paid_total = 0;

        if ($reports) {
            foreach ($reports as $key => $value) {
                $sell_total = $sell_total + $value->total_price;
                $profit_total = $profit_total + $value->profit;
                $due_total = $due_total + $value->due;
                $paid_total = $paid_total + $value->paid;
            }
        }

        $data = [
            'reports' => $reports,
            'day'=>$day,
            'sell_total'=>$sell_total,
            'profit_total'=>$profit_total,
            'due_total'=>$due_total,
            'paid_total'=>$paid_total,
        ];

        return $data;
    }

}
