<?php

namespace App\Http\Livewire\Expences\Expences;

use Livewire\Component;

use App\Models\Expence;

class AddExpencesComponent extends Component
{
    public $date, $details, $remarks, $amount;

    public function Store()
    {
        $validatedData = $this->validate([
            'date' => 'required',
            'details' => 'required',
            'amount' => 'required',
        ]);

        $data = new Expence();

        $data->date = $this->date;
        $data->details = $this->details;
        $data->remarks = $this->remarks;
        $data->amount = $this->amount;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Expence Added Successfuly']);
        }

        $this->date = null;
        $this->details = null;
        $this->remarks = null;
        $this->amount = null;

        $this->emit('storeSomething');
    }

    public function render()
    {
        return view('livewire.expences.expences.add-expences-component')->layout('base.base');
    }
}
