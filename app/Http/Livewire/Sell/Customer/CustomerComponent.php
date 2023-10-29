<?php

namespace App\Http\Livewire\Sell\Customer;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Customer;
use Illuminate\Validation\Rule;

class CustomerComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";

    public $name, $phone;

    public $edit_id, $e_name, $e_phone;


    public function Store()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'phone' => 'required|numeric|unique:customers',
        ]);

        $data = new Customer();

        $data->name = $this->name;
        $data->code = self::make_code($data);
        $data->phone = $this->phone;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Customer Added Successfuly']);
        }

        $this->name = null;
        $this->phone = null;

        $this->emit('storeSomething');
    }

    public function getItem($id)
    {
        $this->edit_id = $id;
        $data = Customer::find($id);

        $this->e_name = $data->name;
        $this->e_phone = $data->phone;
    }

    public function Update()
    {
        $validatedData = $this->validate([
            'e_name' => 'required',
            'e_phone' => [
                'required','numeric',
                    Rule::unique('customers', 'phone')->ignore($this->edit_id)
                ],
        ]);

        $data = Customer::find($this->edit_id);

        $data->name = $this->e_name;
        $data->phone = $this->e_phone;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Curtomer Info Updated Successfuly']);
        }

        $this->edit_id = null;
        $this->e_name = null;
        $this->e_phone = null;

        $this->emit('storeSomething');
    }

    public function make_code($data)
    {
        $lastInvoiceID = $data->orderBy('id', 'DESC')->pluck('id')->first();
        $newInvoiceID = $lastInvoiceID + 1;

        // str_pad($newInvoiceID, 6, '0', STR_PAD_LEFT);

        return str_pad($newInvoiceID, 6, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        $customers = Customer::with('user')->search(trim($this->search))->paginate($this->paginate);
        return view('livewire.sell.customer.customer-component',compact('customers'))->layout('base.base');
    }
}
