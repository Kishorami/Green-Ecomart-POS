<?php

namespace App\Http\Livewire\Sell\Payment;

use Livewire\Component;

use App\Models\PaymentMethod;

class PaymentMethodComponent extends Component
{
    public $name;

    public $edit_id, $e_name;

    public function Store()
    {
        $validatedData = $this->validate([
            'name' => 'required',
        ]);

        $data = new PaymentMethod();

        $data->name = $this->name;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Payment Method Added Successfuly']);
        }

        $this->name = null;

        $this->emit('storeSomething');
    }

    public function getItem($id)
    {
        $this->edit_id = $id;
        $data = PaymentMethod::find($id);

        $this->e_name = $data->name;
    }

    public function Update()
    {
        $validatedData = $this->validate([
            'e_name' => 'required',
        ]);

        $data = PaymentMethod::find($this->edit_id);

        $data->name = $this->e_name;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Payment Method Updated Successfuly']);
        }

        $this->edit_id = null;
        $this->e_name = null;

        $this->emit('storeSomething');
    }
    public function render()
    {
        $payment_methods = PaymentMethod::all();
        return view('livewire.sell.payment.payment-method-component',compact('payment_methods'))->layout('base.base');
    }
}
