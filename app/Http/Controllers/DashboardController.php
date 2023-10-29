<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BatchedItem;
use App\Models\Expence;
use App\Models\Refund;
use App\Models\Sell;
use App\Models\SoldItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        $imported_items = BatchedItem::where('stock','>',0)->get();

        $imported_items_sold = BatchedItem::where('sold','>',0)->get();

        $data = [
                    'product_stock' => self::product_stock($imported_items->groupBy('sku')),
                    'fast_to_slow' => self::fast_to_slow(),
                    'sell_this_month' => self::sell_this_month(),
                    'sell_today' => self::sell_today(),
                    'today_total_received' => self::today_total_received(),
                    'expences_this_month' => self::expences_this_month(),
                    'refund_this_month' => self::refund_this_month(),
                    'due_this_month' => self::due_this_month(),
                    'top_sold_products' => self::top_sold_products($imported_items_sold->groupBy('sku')),
                    // 'fast_to_slow_with_profit' => self::fast_to_slow_with_profit(),
                    // 'customer_by_profit' => self::customer_by_profit(),
                    // 'customer_by_balance' => self::customer_by_balance(),
                ];

        return view('livewire.dashboard.dashboard',$data);
    }

    public function due_this_month()
    {
        $from = new Carbon('first day of this month');
        $to = new Carbon('last day of this month');
        $from = $from->format('Y-m-d');
        $to = $to->format('Y-m-d');

        $sells = Sell::whereBetween('created_at', [$from, Carbon::parse($to)->addDays(1)])->get();

        $due_total=0;
        foreach ($sells as $key => $value) {
            $due_total = $due_total + $value->due;
        }

        return $due_total;
    }

    public function refund_this_month()
    {
        $refund_total = 0;

        $date = Carbon::now();
        $month = Carbon::parse($date)->format('m');
        $year = Carbon::parse($date)->format('Y');
        
        $refunds = Refund::whereMonth('created_at',$month)->whereYear('created_at',$year)->get();

        if ($refunds) {
            foreach ($refunds as $key => $value) {
                $refund_total = $refund_total + $value->amount;
            }
        }

        return $refund_total;
    }

    public function today_total_received()
    {
        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        $sells = Sell::whereBetween('created_at', [$from, Carbon::parse($to)->addDays(1)])->get();

        $sell_total=0;
        foreach ($sells as $key => $value) {
            if ($value->total_price >= $value->paid) {
                $sell_total = $sell_total + $value->paid;
            }else{
                $sell_total = $sell_total + ($value->paid - $value->total_price);
            }
        }

        return $sell_total;
    }
    
    public function expences_this_month()
    {
        $expence_total = 0;

        $date = Carbon::now();
        $month = Carbon::parse($date)->format('m');
        $year = Carbon::parse($date)->format('Y');
        
        $expences = Expence::whereMonth('date',$month)->whereYear('date',$year)->with('user')->orderBy('date','ASC')->get();

        if ($expences) {
            foreach ($expences as $key => $value) {
                $expence_total = $expence_total + $value->amount;
            }
        }

        return $expence_total;
    }

    public function sell_today()
    {
        $from = Carbon::now()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        $sells = Sell::whereBetween('created_at', [$from, Carbon::parse($to)->addDays(1)])->get();

        $sell_total=0;
        foreach ($sells as $key => $value) {
            $sell_total = $sell_total + $value->total_price;
        }

        return $sell_total;
    }

    public function sell_this_month()
    {
        $from = new Carbon('first day of this month');
        $to = new Carbon('last day of this month');
        $from = $from->format('Y-m-d');
        $to = $to->format('Y-m-d');

        $sells = Sell::whereBetween('created_at', [$from, Carbon::parse($to)->addDays(1)])->get();

        $sell_total=0;
        foreach ($sells as $key => $value) {
            $sell_total = $sell_total + $value->total_price;
        }

        return $sell_total;
    }

    public function top_sold_products($data)
    {
        // dd($data);
        $temp = array();
        foreach ($data as $key => $value) {
            $info = stock_info($value)['sold_total'];
            
            $temp[$value[0]->item_description .':'. $value[0]->sku] = $info;
        }

        arsort($temp);

        $info = array();
        $count = 0;
        foreach ($temp as $key => $value) {
            $lebel = explode(':',$key);
            array_push($info, [
                'product'=>$lebel[0],
                'sku'=>$lebel[1],
                'sold_qty'=>$value,
            ]);

            if($count == 5){
                break;
            }

            $count++;
        }
        return $info;
    }

    public function product_stock($data)
    {
        // dd($data);
        $temp = array();
        foreach ($data as $key => $value) {
            $info = stock_info($value)['stock_total'];
            
            $temp[$value[0]->item_description .':'. $value[0]->sku] = $info;
        }

        $labels = array();
        $datas = array();
        foreach ($temp as $key => $value) {
            array_push($labels, $key);
            array_push($datas, $value);
        }

        $info = [
                    'labels' => $labels,
                    'data' => $datas,
                ];

        // dd($info,$temp);
        return $info;
    }

    public function fast_to_slow()
    {
        $sold_items = SoldItem::with('product')->get()->groupBy('batched_item_id');

        $temp = array();

        foreach ($sold_items as $key_s => $value_s) {
            
            $product; $days; $sold=0;
            foreach ($value_s as $key => $value) {
                
                $product = $value->product->item_description .':'. $value->product->sku;
                $sold = $sold + $value->quantity;
                // $days = ($value->product->created_at)->diffInDays($value->created_at);
                $days = ($value->product->created_at)->diffInDays(Carbon::now());
            }

            $info = [
                        'ratio' => 0,
                        'sold' => $sold,
                        'days' => $days+1,
                    ];


            if (array_key_exists($product, $temp)) {
                $temp[$product]['sold'] = $temp[$product]['sold'] + $info['sold'];
                if ($temp[$product]['days'] < $info['days']) {
                    $temp[$product]['days'] = $info['days'];
                }
            } else {
                $temp[$product] = $info;
            }
        }

        foreach ($temp as $key => $value) {
            $temp[$key]['ratio'] = $temp[$key]['sold']/$temp[$key]['days'];
        }

        arsort($temp);

        $labels = array();
        $datas = array();
        foreach ($temp as $key => $value) {
            array_push($labels, $key);
            array_push($datas, [
                'y'=>number_format($value['ratio'],2),
                'sold'=>$value['sold'],
                'days' => $value['days'],
                ]);

        }

        $info = [
                    'labels' => $labels,
                    'data' => $datas,
                ];

        return $info;
    }
}
