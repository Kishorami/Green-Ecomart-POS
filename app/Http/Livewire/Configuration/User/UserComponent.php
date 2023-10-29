<?php

namespace App\Http\Livewire\Configuration\User;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = "";

    public $name, $email, $contact, $password, $user_type="";

    public $edit_id, $e_name, $e_email, $e_contact, $e_password, $e_user_type;

    public function Store()
    {
        $validatedData = $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);

        if(auth()->user()->user_type != 'admin' && $this->user_type == 'admin')
        {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Manager Can Not Create Admin']);
            $this->password = null;
            $this->emit('storeSomething');
            return;
        }

        $data = new User();

        $data->name = $this->name;
        $data->email = $this->email;
        $data->password = Hash::make($this->password);
        $data->contact = $this->contact;
        $data->user_type = $this->user_type;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'New User Created']);
        }
        
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->contact = null;

        $this->emit('storeSomething');

    }

    public function getItem($id)
    {
        $this->edit_id = $id;

        $data = User::find($this->edit_id);

        $this->e_name = $data->name;
        $this->e_email = $data->email;
        $this->e_contact = $data->contact;
        $this->e_user_type = $data->user_type;
    }

    public function Update()
    {

        if($this->e_password == "")
        {
            $this->e_password = null;
        }

        $validatedData = $this->validate([
            'e_name' => 'required|max:255',
            'e_email' => [
                'required',
                    Rule::unique('users', 'email')->ignore($this->edit_id)
                ],
        ]);

        if ($this->e_password != null) {
            $validatedData = $this->validate([
                'password' => 'min:8',
            ]);
        }

        $data = User::find($this->edit_id);

        $data->name = $this->e_name;
        $data->email = $this->e_email;
        $data->contact = $this->e_contact;
        $data->user_type = $this->e_user_type;

        if ($this->e_password != null) {
             $data->password = Hash::make($this->e_password);
        }

        // dd($data, $this->e_password);

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'User Updated']);
        }

        $this->edit_id = null;
        $this->e_name = null;
        $this->e_email = null;
        $this->e_contact = null;
        $this->e_password = null;
        $this->e_user_type = null;

        $this->emit('storeSomething');
    }

    public function toggleActive($id)
    {
        $data = User::find($id);

        $temp = '';

        if ($data->is_active) {
            $data->is_active = 0;
            $temp = 'Deactivated';
        } else {
            $data->is_active = 1;
            $temp = 'Activated';
        }

        $done = $data->save();

        if ($done) {
            if ($temp === 'Activated') {
                $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'User '.$data->name.' Activated Successfuly.']);
            } elseif ($temp === 'Deactivated') {
                $this->dispatchBrowserEvent('alert', 
                    ['type' => 'warning',  'message' => 'User '.$data->name.' Deactivated Successfuly.']);
            }
            
        }

        
    }

    public function render()
    {
        if (auth()->user()->user_type === 'manager') {
            $users = User::where('user_type','cashier')->search(trim($this->search))->paginate($this->paginate);
        }else{
            $users = User::search(trim($this->search))->paginate($this->paginate);
        }
        return view('livewire.configuration.user.user-component',compact('users'))->layout('base.base');
    }
}
