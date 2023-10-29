<?php

namespace App\Http\Livewire\Inventory\Category;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";

    public $name, $description;

    public $edit_id, $e_name, $e_description;

    public function Store()
    {
        $validatedData = $this->validate([
            'name' => 'required|unique:categories',
            'description' => 'required',
        ]);

        $data = new Category();

        $data->name = $this->name;
        $data->description = $this->description;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Category Added Successfuly']);
        }

        $this->name = null;
        $this->description = null;

        $this->emit('storeSomething');
    }

    public function getItem($id)
    {
        $this->edit_id = $id;
        $data = Category::find($id);

        $this->e_name = $data->name;
        $this->e_description = $data->description;
    }

    public function Update()
    {
        $validatedData = $this->validate([
            'e_name' => [
                'required',
                    Rule::unique('categories', 'name')->ignore($this->edit_id)
                ],
            'e_description' => 'required',
        ]);

        $data = Category::find($this->edit_id);

        $data->name = $this->e_name;
        $data->description = $this->e_description;
        $data->user_id = auth()->user()->id;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Category Updated Successfuly']);
        }

        $this->edit_id = null;
        $this->e_name = null;
        $this->e_description = null;

        $this->emit('storeSomething');
    }

    public function render()
    {
        $categories = Category::with('user')->search(trim($this->search))->paginate($this->paginate);
        return view('livewire.inventory.category.category-component',compact('categories'))->layout('base.base');
    }
}
