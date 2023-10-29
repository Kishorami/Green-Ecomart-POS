<?php

namespace App\Http\Livewire\Reports\SellReport;

use Livewire\Component;

use App\Models\Sell;
use Carbon\Carbon;

class SellReportComponent extends Component
{
    public $reports;
    public $from, $to, $flag='';
    public $temp_from, $temp_to;
    public $sell_total, $profit_total;

    public $sell, $bill_no, $profit;

    public function today()
    {
        $this->from = Carbon::now()->format('Y-m-d');
        $this->to = Carbon::now()->format('Y-m-d');
        $this->flag = 'today';
        self::search_by_date();
    }

    public function last_seven_days()
    {
        $this->from = Carbon::now()->subDays(7)->format('Y-m-d');
        $this->to = Carbon::now()->format('Y-m-d');
        $this->flag = 'last_seven_days';
        self::search_by_date();
    }

    public function previous_month()
    {
        $this->from = new Carbon('first day of last month');
        $this->to = new Carbon('last day of last month');
        $this->from = $this->from->format('Y-m-d');
        $this->to = $this->to->format('Y-m-d');
        $this->flag = 'previous_month';
        self::search_by_date();
    }

    public function this_month()
    {
        $this->from = new Carbon('first day of this month');
        $this->to = new Carbon('last day of this month');
        $this->from = $this->from->format('Y-m-d');
        $this->to = $this->to->format('Y-m-d');
        $this->flag = 'this_month';
        self::search_by_date();
    }

    public function search_by_form()
    {
        $this->from = $this->temp_from;
        $this->to = $this->temp_to;
        $this->flag = '';
        self::search_by_date();
    }

    public function search_by_date()
    {
        $this->sell_total = 0;
        $this->profit_total = 0;

        $this->reports = Sell::whereBetween('created_at', [$this->from, Carbon::parse($this->to)->addDays(1)])->with('customer')->get();

        if ($this->reports) {
            foreach ($this->reports as $key => $value) {
                $this->sell_total = $this->sell_total + $value->total_price;
                $this->profit_total = $this->profit_total + $value->profit;
            }
        }
    }

    public function get_item($id)
    {
        $this->sell = Sell::find($id);

        $this->bill_no = $this->sell->bill_no;
        $this->profit = $this->sell->profit;

    }

    public function render()
    {
        return view('livewire.reports.sell-report.sell-report-component')->layout('base.base');
    }
}
