<?php

namespace App\Http\Livewire\Sell\Customer;

use App\Models\Customer;
use App\Models\CustomerLedger;
use App\Models\PaymentMethod;
use App\Models\Sell;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerLedgerComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $customer_id, $customer, $invoice, $products, $flag=false, $payment_methods;

    public $paid_amount, $date, $payment_method_id="", $note;

    public $edit_id, $e_note, $e_date;

    public function Store()
    {
        $validatedData = $this->validate([
            'date' => 'required',
            'paid_amount' => 'required',
        ]);

        $sells = self::sell_adjust();

        $last_data = CustomerLedger::where('customer_id',$this->customer_id)->orderBy('id', 'desc')->first();

        $data = new CustomerLedger();

        $data->customer_id = $this->customer_id;
        $data->date = $this->date;
        $data->particulars = 'Payment Receive';
        $data->due_amount = 0;
        $data->payment_amount = $this->paid_amount;
        $data->total_due = ($last_data->total_due + $data->due_amount) - $data->payment_amount;
        $data->payment_method_id = $this->payment_method_id;
        $data->note = $this->note;

        $data->save();

        $customer_info = Customer::find($this->customer_id);

        $customer_info->total_due = $customer_info->total_due - $this->paid_amount;

        $done = $customer_info->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Payment Received Successfuly']);
        }

        $this->emit('storeSomething');

        $this->paid_amount = null;
        $this->date = null;
        $this->payment_method_id = "";
        $this->note = null;
    }

    public function sell_adjust()
    {
        $sells_list = [];
        $temp_paid = $this->paid_amount;

        $sells = Sell::where('customer_id',$this->customer_id)->where('due','>',0)->get();

        foreach ($sells as $key => $value) {
            $data = Sell::find($value->id);

            if ($value->due > $temp_paid) {
                $data->due = $data->due - $temp_paid;
                $data->paid = $data->paid + $temp_paid;
                $temp_paid = 0;
                $data->save();
            }else{
                $temp_paid = $temp_paid - $data->due;
                $data->paid = $data->paid + $data->due;
                $data->due = 0;
                $data->save();
                $sells_list[] = [
                    'bill_no' => $value->bill_no,
                ];
            }
        }

        return $sells_list;
        // dd($sells_list);
    }

    public function getItem($bill_no)
    {
        $this->invoice = Sell::where('bill_no',$bill_no)->first();

        $this->products = json_decode($this->invoice->products);
        // dd($this->invoice , $this->products);
        $this->flag = true;
    }

    public function getItemEdit($id)
    {
        $data = CustomerLedger::find($id);

        $this->edit_id = $id;

        $this->e_note = $data->note;
        $this->e_date = $data->date;
    }

    public function Update()
    {
        $validatedData = $this->validate([
            'e_date' => 'required',
        ]);

        $data = CustomerLedger::find($this->edit_id);

        $data->note = $this->e_note;
        $data->date = $this->e_date;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Payment Updated Successfuly']);
        }

        $this->emit('storeSomething');

        $this->edit_id = null;
        $this->e_note = null;
    }

    public function mount($id)
    {
        $this->customer_id = $id;
        $this->customer = Customer::find($id);

        $this->payment_methods = PaymentMethod::all();
    }

    public function render()
    {
        $ledgers = CustomerLedger::where('customer_id',$this->customer_id)->with('payment_method')->paginate(10);
        $this->customer = Customer::find($this->customer_id);
        return view('livewire.sell.customer.customer-ledger-component',compact('ledgers'))->layout('base.base');
    }
}
