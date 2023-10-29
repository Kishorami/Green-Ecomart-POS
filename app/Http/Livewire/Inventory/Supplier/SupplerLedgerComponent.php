<?php

namespace App\Http\Livewire\Inventory\Supplier;

use App\Models\PaymentMethod;
use App\Models\Supplier;
use App\Models\SupplierLedger;
use Livewire\Component;
use Livewire\WithPagination;

class SupplerLedgerComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";
    public $sortBy = "id";
    public $sortDirection = "asc";

    public $supplier_id;

    public $date, $particulars, $payment_amount, $payment_method_id="", $note;

    public $edit_id, $e_date, $e_particulars, $e_note, $e_payment_method_id;

    public function Store()
    {

        $this->validate([
            'date' => 'required',
            'particulars' => 'required',
            'payment_amount' => 'required',
            'payment_method_id' => 'required',
        ]);

        $supplier_total_due = (SupplierLedger::where('supplier_id',$this->supplier_id)->orderBy('id', 'desc')->first())->total_due;

        $ledger = new SupplierLedger();

        $ledger->supplier_id = $this->supplier_id;
        $ledger->date = $this->date;
        $ledger->particulars = $this->particulars;
        $ledger->payment_amount = $this->payment_amount;
        $ledger->total_due = $supplier_total_due - $this->payment_amount;
        $ledger->payment_method_id = $this->payment_method_id;
        $ledger->note = $this->note;


        $ledger->save();

        $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Payment Added Successfuly']);
                    
        $this->emit('storeSomething');

        $this->date = null;
        $this->particulars = null;
        $this->payment_amount = null;
        $this->payment_method_id = "";
        $this->note = null;
    }    

    public function getItem($id)
    {
        $this->edit_id = $id;

        $data = SupplierLedger::find($id);

        $this->e_date = $data->date;
        $this->e_particulars = $data->particulars;
        $this->e_payment_method_id = $data->payment_method_id;
        $this->e_note = $data->note;
    }

    public function Update()
    {
        $data = SupplierLedger::find($this->edit_id);

        $data->date = $this->e_date;
        $data->particulars = $this->e_particulars;
        $data->note = $this->e_note;

        $data->save();

        $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Payment Update Successfully']);

        $this->emit('storeSomething');

        $this->e_date = null;
        $this->e_particulars = null;
        $this->e_note = null;
        $this->e_payment_method_id = null;
        $this->edit_id = null;

    }

    public function mount($id)
    {
        $this->supplier_id = $id;
    }

    public function render()
    {
        $records = SupplierLedger::orderBy($this->sortBy,$this->sortDirection)->where('supplier_id',$this->supplier_id)->with('paymentMethod','batch')->search(trim($this->search))->paginate($this->paginate);
        $supplier_info = Supplier::find($this->supplier_id);
        $payment_methods = PaymentMethod::all();

        $total_due = (SupplierLedger::where('supplier_id',$this->supplier_id)->orderBy('id', 'desc')->first())->total_due;

        return view('livewire.inventory.supplier.suppler-ledger-component',compact('records','supplier_info','payment_methods','total_due'))->layout('base.base');
    }
}
