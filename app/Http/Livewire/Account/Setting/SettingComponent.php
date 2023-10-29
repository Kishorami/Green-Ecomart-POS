<?php

namespace App\Http\Livewire\Account\Setting;

use Livewire\Component;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class SettingComponent extends Component implements UpdatesUserPasswords
{

    use PasswordValidationRules;

    public $name;

    public $password, $password_confirmation, $old_password;

    public function UpdateInfo()
    {
        $validatedData = $this->validate([
            'name' => 'required|alpha',
        ]);

        $data = User::find(auth()->user()->id);

        $data->name = $this->name;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Info Updated Successfuly']);
        }
    }


    public function UpdatePassword()
    {
        $user = auth()->user();
        $input = [
            'current_password' => $this->old_password,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];


        self::update($user, $input);

        if (request()->hasSession()) {
            request()->session()->put([
                'password_hash_'.Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
            ]);
        }

        $this->password = null;
        $this->password_confirmation = null;
        $this->old_password = null;


        $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Password Changed.']);
    }

    public function update($user, array $input)
    {
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->after(function ($validator) use ($user, $input) {
            if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));

                // dd($validator);
            }
        })->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }


    public function mount()
    {
        $data = User::find(auth()->user()->id);

        $this->name = $data->name;
    }

    public function render()
    {
        return view('livewire.account.setting.setting-component')->layout('base.base');
    }
}
