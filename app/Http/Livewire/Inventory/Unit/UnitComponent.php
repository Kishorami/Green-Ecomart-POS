<?php

namespace App\Http\Livewire\Inventory\Unit;

use Livewire\Component;
use Livewire\WithPagination;


use App\Models\Unit;

class UnitComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";
    public $sortBy = "id";
    public $sortDirection = "asc";


    public $name, $edit_id, $e_name;


    public function Store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $data = new Unit();

        $data->name = $this->name;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Unit Created Successfuly']);
        }
        $this->emit('storeSomething');
        $this->name = null;
    }

    public function getItem($id)
    {
        $data = Unit::find($id);

        $this->edit_id = $id;

        $this->e_name = $data->name;
    }

    public function Update()
    {
        $this->validate([
            'e_name' => 'required',
        ]);

        $data = Unit::find($this->edit_id);

        $data->name = $this->e_name;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Unit Updated Successfuly']);
        }
        $this->emit('storeSomething');
        $this->e_name = null;
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
        $allUnits = Unit::orderBy($this->sortBy,$this->sortDirection)->search(trim($this->search))->paginate($this->paginate);
        return view('livewire.inventory.unit.unit-component',compact('allUnits'))->layout('base.base');
    }
}
