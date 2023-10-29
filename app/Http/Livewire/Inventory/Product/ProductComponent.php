<?php

namespace App\Http\Livewire\Inventory\Product;

use Livewire\Component;

use App\Models\BatchedItem;

class ProductComponent extends Component
{
    public $search;

    public $temp_search;
    public $result_name;
    public $temp_input;

    public function search()
    {
        $this->search = $this->temp_search;

        $this->temp_search = null;
    }

    public function goal($goal)
    {
        $sku = explode(':',$goal);
        // dd($sku);
        $this->temp_search = $sku[0];
        $this->result_name = $goal;
    }


    public function render()
    {
        $products = collect();

        if ($this->search != "") {
            $products = BatchedItem::where('stock','>',0)->with('batch')->search(trim($this->search))->get()->groupBy('sku');
        }


        $allProducts = BatchedItem::all();
        return view('livewire.inventory.product.product-component',compact('products','allProducts'))->layout('base.base');
    }
}
