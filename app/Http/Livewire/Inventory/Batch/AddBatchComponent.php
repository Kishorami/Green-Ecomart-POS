<?php

namespace App\Http\Livewire\Inventory\Batch;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Batch;

use App\Imports\ProductsImport;
use App\Models\PaymentMethod;
use App\Models\Supplier;
use App\Models\SupplierLedger;
use Maatwebsite\Excel\Facades\Excel;

class AddBatchComponent extends Component
{
    use WithFileUploads;

    public $batch_code, $note, $import_date, $product_input_type = "";

    public $product_list_excel;

    public $supplier_id, $supply_price, $paid_amount, $payment_method_id, $ledger_note;

    public function Store($value='')
    {
        $validatedData = $this->validate([
            'batch_code' => 'required',
            'import_date' => 'required',
            'supply_price' => 'required',
            'paid_amount' => 'required',
        ]);

        // batch table insert-------------------------
        $data = new Batch();

        $data->batch_code = $this->batch_code;
        $data->note = $this->note;
        $data->import_date = $this->import_date;
        $data->supplier_id = $this->supplier_id;
        $data->supply_price = $this->supply_price;

        $done = $data->save();
        // batch table insert-------------------------

        // ledger table insert-------------------------
        $ledger_data = new SupplierLedger();
        
        $ledger_info = SupplierLedger::where('supplier_id',$this->supplier_id)->orderBy('id', 'desc')->first();

        $ledger_data->supplier_id = $this->supplier_id;
        $ledger_data->date = $this->import_date;
        $ledger_data->particulars = 'import';
        $ledger_data->batch_id = $data->id;
        $ledger_data->due_amount = $this->supply_price;
        $ledger_data->payment_amount = $this->paid_amount;

        if($ledger_info){
            $ledger_data->total_due = $ledger_info->total_due + ($this->supply_price - $this->paid_amount);
        }else{
            $ledger_data->total_due = 0 + ($this->supply_price - $this->paid_amount);
        }

        $ledger_data->payment_method_id = $this->payment_method_id;
        $ledger_data->note = $this->ledger_note;

        $ledger_data->save();
        // ledger table insert-------------------------

        if ($done) {


            if ($this->product_input_type === 'from_excel') {
                $import = Excel::import(new ProductsImport($data->id), $this->product_list_excel);
            }

            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Batch Created Successfuly']);
        }

        $this->batch_code = null;
        $this->note = null;
        $this->import_date = null;
        $this->product_input_type = "";
        $this->product_list_excel = null;
        $this->supplier_id = null;
        $this->supply_price = null;
        $this->paid_amount = null;
        $this->payment_method_id = null;
        $this->ledger_note = null;
    }


    public function render()
    {
        $suppliers = Supplier::all();
        $payment_methods = PaymentMethod::all();
        return view('livewire.inventory.batch.add-batch-component', compact('suppliers','payment_methods'))->layout('base.base');
    }
}
