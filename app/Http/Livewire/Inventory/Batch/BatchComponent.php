<?php

namespace App\Http\Livewire\Inventory\Batch;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Batch;
use App\Models\Supplier;
use App\Models\SupplierLedger;
use Illuminate\Validation\Rule;

class BatchComponent extends Component
{
    
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";
    public $sortBy = "id";
    public $sortDirection = "asc";

    public $edit_id, $batch_code, $note, $import_date, $supplier_id, $previous_supplier_id;


    public function getItem($id)
    {
        $this->edit_id = $id;

        $data = Batch::find($id);

        $this->batch_code = $data->batch_code;
        $this->note = $data->note;
        $this->import_date = $data->import_date;
        $this->supplier_id = $data->supplier_id;
        $this->previous_supplier_id = $data->supplier_id;

    }

    public function Update()
    {
        $this->validate([
            
            'import_date' => 'required',
            'batch_code'=>[
                'required',
                Rule::unique('batches', 'batch_code')->ignore($this->edit_id)
                ],
        ]);


        $data = Batch::find($this->edit_id);

        $data->batch_code = $this->batch_code;
        $data->note = $this->note;
        $data->import_date = $this->import_date;
        $data->supplier_id = $this->supplier_id;

        $done = $data->save();

        $supplier_ledger = SupplierLedger::where('batch_id',$this->edit_id)->first();
        $supplier_ledger->supplier_id = $this->supplier_id;
        $supplier_ledger->save();

        self::ledger_correction($supplier_ledger->id, $supplier_ledger->supplier_id, $this->previous_supplier_id);

        if ($done) {

            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Batch Information Updated Successfuly']);

            $this->emit('storeSomething');
        }
        $this->edit_id = null;
        $this->batch_code = null;
        $this->note = null;
        $this->import_date = null;
        $this->previous_supplier_id = $this->supplier_id;
        $this->supplier_id = null;
    }

    public function ledger_correction($id, $supplier_id, $previous_supplier_id)
    {
        
        $info = SupplierLedger::where('supplier_id',$supplier_id)->where('id','<',$id)->orderBy('id', 'desc')->first();
        
        if ($info) {
            $current_info = SupplierLedger::where('supplier_id',$supplier_id)->where('id',$id)->first();
            $current_info->total_due =  $info->total_due + ($current_info->due_amount - $current_info->payment_amount);
            $current_info->save();

            $next_info = SupplierLedger::where('supplier_id',$supplier_id)->where('id','>',$id)->first();

            if($next_info){
                self::rest_current_suppliers_entry_currection($id, $supplier_id, $current_info->total_due);
                self::rest_previous_suppliers_entry_currection($id, $previous_supplier_id);
            }else{
                self::rest_previous_suppliers_entry_currection($id, $previous_supplier_id);
            }

        }else{

            $info = SupplierLedger::where('supplier_id',$supplier_id)->where('id',$id)->first();
            $next_info = SupplierLedger::where('supplier_id',$supplier_id)->where('id','>',$id)->first();

            if($next_info){
                $info->total_due = $info->due_amount - $info->payment_amount;
                $info->save();
                self::rest_current_suppliers_entry_currection($id, $supplier_id, $info->total_due);
                self::rest_previous_suppliers_entry_currection($id, $previous_supplier_id);
            }else{
                $info->total_due = $info->due_amount - $info->payment_amount;
                $info->save();
                self::rest_previous_suppliers_entry_currection($id, $previous_supplier_id);
            }
        }
        // dd($rest_of_the_collection);
    }

    public function rest_current_suppliers_entry_currection($id, $supplier_id, $c_due)
    {
        $rest_of_the_collection = SupplierLedger::where('supplier_id',$supplier_id)->where('id','>',$id)->get();
        $current_due = $c_due;
        
        foreach ($rest_of_the_collection as $key => $value) {
            $value->total_due = $current_due + ($value->due_amount - $value->payment_amount);
            $value->save();
            $current_due = $value->total_due;
        }
    }
    public function rest_previous_suppliers_entry_currection($id, $previous_supplier_id)
    {
        $previous_info = SupplierLedger::where('supplier_id',$previous_supplier_id)->where('id','<',$id)->orderBy('id', 'desc')->first();
        $rest_of_the_collection = SupplierLedger::where('supplier_id',$previous_supplier_id)->where('id','>',$id)->get();

        if($previous_info){
            $current_due = $previous_info->total_due;
        }else{
            $current_due = 0;
        }

        foreach ($rest_of_the_collection as $key => $value) {
            $value->total_due = $current_due + ($value->due_amount - $value->payment_amount);
            $value->save();
            $current_due = $value->total_due;
        }
    }

    public function sortBy($field)
    {
        if ($this->sortDirection == "asc") {
            $this->sortDirection = "desc";
        }
        else
        {
            $this->sortDirection = "asc";
        }

        return $this->sortBy = $field;
    }

    public function render()
    {
        $allBatches = Batch::with('supplier')->orderBy($this->sortBy,$this->sortDirection)->search(trim($this->search))->paginate($this->paginate);
        $suppliers = Supplier::all();
        return view('livewire.inventory.batch.batch-component',compact('allBatches','suppliers'))->layout('base.base');
    }
}
