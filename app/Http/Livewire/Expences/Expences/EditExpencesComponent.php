<?php

namespace App\Http\Livewire\Expences\Expences;

use Livewire\Component;

use App\Models\Expence;

class EditExpencesComponent extends Component
{
    public $edit_id, $date, $details, $remarks, $amount;

    public function Store()
    {
        $validatedData = $this->validate([
            'date' => 'required',
            'details' => 'required',
            'amount' => 'required',
        ]);

        $data = Expence::find($this->edit_id);

        $data->date = $this->date;
        $data->details = $this->details;
        $data->remarks = $this->remarks;
        $data->amount = $this->amount;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Expence Update Successfuly']);
        }

        $this->date = null;
        $this->details = null;
        $this->remarks = null;
        $this->amount = null;

        $this->emit('storeSomething');
    }

    public function mount($id)
    {
        $this->edit_id = $id;

        $data = Expence::find($this->edit_id);

        $this->date = $data->date;
        $this->details = $data->details;
        $this->remarks = $data->remarks;
        $this->amount = $data->amount;
    }

    public function render()
    {
        return view('livewire.expences.expences.edit-expences-component')->layout('base.base');
    }
}
