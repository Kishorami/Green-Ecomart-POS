<?php

namespace App\Http\Livewire\Reports\StockReport;

use App\Models\BatchedItem;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class StockReportComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";

    // public $stock_info;

    // public function stock_calculation()
    // {
    //    $this->stock_info = BatchedItem::where('stock','>',0)->with('batch')->search(trim($this->search))->paginate($this->paginate)->groupBy('sku');

    // //    dd($this->stock_info);
    // }

    public function render()
    {

        $products_collection = BatchedItem::where('stock','>',0)->with('batch')->search(trim($this->search))->get()->groupBy('sku');

        $products = collect($products_collection)->paginate($this->paginate); //need packe "Laravel collection macros"

        return view('livewire.reports.stock-report.stock-report-component',compact('products','products_collection'))->layout('base.base');
    }
}
