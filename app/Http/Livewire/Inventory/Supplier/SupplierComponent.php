<?php

namespace App\Http\Livewire\Inventory\Supplier;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Validation\Rule;
use App\Models\Supplier;

class SupplierComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";

    public $name, $code, $contact, $address, $payment_info, $note;

    public $edit_id, $e_name, $e_code, $e_contact, $e_address, $e_payment_info, $e_note;


    public function Store()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'code' => 'required',
            'contact' => 'required',
            'address' => 'required',
        ]);

        $data = new Supplier();

        $data->name = $this->name;
        $data->code = $this->code;
        $data->contact = $this->contact;
        $data->address = $this->address;
        $data->payment_info = $this->payment_info;
        $data->note = $this->note;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Supplier Added Successfuly']);
        }

        $this->name =null;
        $this->code =null;
        $this->contact =null;
        $this->address =null;
        $this->payment_info =null;
        $this->note =null;

        $this->emit('storeSomething');
    }

    public function getItem($id)
    {
        $this->edit_id = $id;
        $data = Supplier::find($id);

        $this->e_name = $data->name;
        $this->e_code = $data->code;
        $this->e_contact = $data->contact;
        $this->e_address = $data->address;
        $this->e_payment_info = $data->payment_info;
        $this->e_note = $data->note;
    }


    public function Update()
    {
        $validatedData = $this->validate([
            'e_name' => 'required',
            'e_code' => [
                'required',
                Rule::unique('suppliers', 'code')->ignore($this->edit_id)
                ],
            'e_contact' => 'required',
            'e_address' => 'required',
        ]);

        $data = Supplier::find($this->edit_id);

        $data->name = $this->e_name;
        $data->code = $this->e_code;
        $data->contact = $this->e_contact;
        $data->address = $this->e_address;
        $data->payment_info = $this->e_payment_info;
        $data->note = $this->e_note;
        $data->user_id = auth()->user()->id;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Supplier Info Updated Successfuly']);
        }

        $this->e_name = null;
        $this->e_code = null;
        $this->e_contact = null;
        $this->e_address = null;
        $this->e_payment_info = null;
        $this->e_note = null;
        $this->edit_id = null;

        $this->emit('storeSomething');
    }


    public function render()
    {
        $suppliers = Supplier::with('user')->search(trim($this->search))->paginate($this->paginate);
        return view('livewire.inventory.supplier.supplier-component',compact('suppliers'))->layout('base.base');
    }
}
