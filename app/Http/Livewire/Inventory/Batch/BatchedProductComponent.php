<?php

namespace App\Http\Livewire\Inventory\Batch;

use App\Models\Batch;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\BatchedItem;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Validation\Rule;

class BatchedProductComponent extends Component
{
    use WithPagination;
    public $batch_id;

    public $search = "";

    public $item_description, $category_id = "", $sku, $unit_id="", $quantity, $unit_price, $sell_price;

    public function Store()
    {
        $this->validate([
            'item_description' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'sell_price' => 'required',
            'sku'=>[
                'required',
                // Rule::unique('products', 'sku')->ignore($this->product_id)
                Rule::unique('batched_items', 'sku')->where(function ($query) { 
                                                    $query->where('sku', $this->sku)
                                                            ->where('batch_id', $this->batch_id); 
                                                })
                ],
        ]);


        $data = new BatchedItem();

        $data->batch_id = $this->batch_id;
        $data->category_id = $this->category_id;
        $data->item_description = $this->item_description;
        $data->sku = $this->sku;
        $data->unit_id = $this->unit_id;
        $data->quantity = $this->quantity;
        $data->stock = $this->quantity;
        $data->sold = 0;
        $data->unit_price = $this->unit_price;
        $data->sell_price = $this->sell_price;

        $done = $data->save();

        if ($done) {            

            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Product Added Successfuly']);
            
            $this->emit('storeSomething');
        }

        $this->item_description = null;
        $this->category_id = "";
        $this->sku = null;
        $this->unit_id = "";
        $this->quantity = null;
        $this->unit_price = null;
        $this->sell_price = null;

    }

    public function mount($id)
    {
        $this->batch_id = $id;
    }

    public function render()
    {
        $batch_info = Batch::find($this->batch_id);
        $batchedProducts = BatchedItem::where('batch_id',$this->batch_id)->with('batch','unit','category')->search(trim($this->search))->paginate(10);
        $units = Unit::all();
        $categories = Category::all();
        return view('livewire.inventory.batch.batched-product-component', compact('batchedProducts','units','categories','batch_info'))->layout('base.base');
    }
}
