<?php

namespace App\Http\Livewire\Sell\Refund;

use Livewire\Component;

use App\Models\Refund;
use App\Models\Sell;
use Carbon\Carbon;

class RefundComponent extends Component
{
    public $name, $bill_no, $description, $amount;

    public $edit_id, $e_name, $e_bill_no, $e_description, $e_amount;

    public $refunds, $refund_total;
    public $from, $to, $flag;
    public $temp_from, $temp_to;

    public function Store()
    {
        $sell_data = Sell::where('bill_no',$this->bill_no)->first();
        
        if(!$sell_data){
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'error',  'message' => 'No Sell Found With Bill No ' . $this->bill_no]);
            $this->emit('storeSomething');
            return;
        }

        $data = new Refund();

        $data->name = $this->name;
        $data->description = $this->description;
        $data->amount = $this->amount;
        $data->sell_id = $sell_data->id;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Refund Added Successfuly']);
        }

        $this->name = null;
        $this->bill_no = null;
        $this->description = null;
        $this->amount = null;

        $this->refunds = null;

        $this->emit('storeSomething');
    }

    public function getItem($id)
    {
        $this->edit_id = $id;
        $data = Refund::where('id',$id)->with('sell')->first();

        $this->e_name = $data->name;
        $this->e_description = $data->description;
        $this->e_bill_no = $data->sell->bill_no;
        $this->e_amount = $data->amount;
    }


    public function Update()
    {
        $sell_data = Sell::where('bill_no',$this->e_bill_no)->first();
        
        if(!$sell_data){
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'error',  'message' => 'No Sell Found With Bill No ' . $this->bill_no]);
            $this->emit('storeSomething');
            return;
        }

        $data = Refund::find($this->edit_id);

        $data->name = $this->e_name;
        $data->description = $this->e_description;
        $data->amount = $this->e_amount;
        $data->sell_id = $sell_data->id;
        $data->user_id = auth()->user()->id;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Refund Updated Successfuly']);
        }

        $this->edit_id = null;
        $this->e_name = null;
        $this->e_bill_no = null;
        $this->e_description = null;
        $this->e_amount = null;
        $this->refunds = null;

        $this->emit('storeSomething');
    }


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
        $this->temp_from = null;
        $this->temp_to = null;

        $this->refund_total = 0;

        $this->refunds = Refund::whereBetween('created_at', [$this->from, Carbon::parse($this->to)->addDays(1)])->with('user')->get();

        if ($this->refunds) {
            foreach ($this->refunds as $key => $value) {
                $this->refund_total = $this->refund_total + $value->amount;
            }
        }
    }

    public function render()
    {
        return view('livewire.sell.refund.refund-component')->layout('base.base');
    }
}
