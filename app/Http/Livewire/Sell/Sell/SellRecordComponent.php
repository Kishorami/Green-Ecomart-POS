<?php

namespace App\Http\Livewire\Sell\Sell;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Sell;

class SellRecordComponent extends Component
{
    
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";
    public function render()
    {
        $sells = Sell::with('user','customer','payment_method')->orderBy('id','desc')->search(trim($this->search))->paginate($this->paginate);
        return view('livewire.sell.sell.sell-record-component',compact('sells'))->layout('base.base');
    }
}
