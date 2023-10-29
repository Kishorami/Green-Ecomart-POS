<?php

namespace App\Http\Livewire\Inventory\Batch;

use Livewire\Component;

use App\Models\Batch;
use App\Models\BatchedItem;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Validation\Rule;

class EditBatchedProductComponent extends Component
{
    public $edit_id, $batches, $categories, $units;

    public $batch_id, $category_id, $item_description, $sku, $unit_id, $quantity, $unit_price, $sell_price, $stock, $new_stock;

    public function Update()
    {
        $this->validate([
            'item_description' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
            'unit_price' => 'required',
            'sell_price' => 'required',
            'sku'=>[
                'required',
                // Rule::unique('products', 'sku')->ignore($this->product_id)
                Rule::unique('batched_items', 'sku')->where(function ($query) { 
                                                    $query->where('sku', $this->sku)
                                                            ->where('batch_id', $this->batch_id); 
                                                })->ignore($this->edit_id)
                ],
        ]);

        $data = BatchedItem::find($this->edit_id);

        $data->batch_id = $this->batch_id;
        $data->category_id = $this->category_id;
        $data->item_description = $this->item_description;
        $data->sku = $this->sku;
        $data->unit_id = $this->unit_id;
        $data->quantity = $data->quantity + $this->new_stock;
        $data->unit_price = $this->unit_price;
        $data->sell_price = $this->sell_price;
        $data->stock = $data->stock + $this->new_stock;

        $done = $data->save();

        if ($done) {            

            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Product Updated Successfuly']);
            
        }

        self::variable_setup();
        
    }

    public function variable_setup()
    {
        $data = BatchedItem::find($this->edit_id);

        $this->batch_id = $data->batch_id;
        $this->category_id = $data->category_id;
        $this->item_description =$data->item_description;
        $this->sku =$data->sku;
        $this->unit_id =$data->unit_id;
        $this->quantity =$data->quantity;
        $this->unit_price =$data->unit_price;
        $this->sell_price =$data->sell_price;
        $this->stock =$data->stock;
        $this->new_stock = 0;
    }

    public function mount($id)
    {
        $this->edit_id = $id;

        $this->batches = Batch::all();

        $this->categories = Category::all();

        $this->units = Unit::all();

        self::variable_setup();
    }

    public function render()
    {
        return view('livewire.inventory.batch.edit-batched-product-component')->layout('base.base');
    }
}
