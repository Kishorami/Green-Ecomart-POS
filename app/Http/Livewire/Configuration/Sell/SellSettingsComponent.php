<?php

namespace App\Http\Livewire\Configuration\Sell;

use App\Models\Configuration;
use Livewire\Component;

class SellSettingsComponent extends Component
{
    public $vat;

    public $enable_points, $earning_points, $per_amount, $max_point_per_invoice, $money_per_point, $min_amount_to_use_points, $use_points_per_amount;


    public function Update()
    {
        $sell_settings = Configuration::find(1);

        $sell_settings->vat = $this->vat;
        $sell_settings->enable_points = $this->enable_points;
        $sell_settings->earning_points = $this->earning_points;
        $sell_settings->per_amount = $this->per_amount;
        $sell_settings->max_point_per_invoice = $this->max_point_per_invoice;
        $sell_settings->money_per_point = $this->money_per_point;
        $sell_settings->min_amount_to_use_points = $this->min_amount_to_use_points;
        $sell_settings->use_points_per_amount = $this->use_points_per_amount;

        $done = $sell_settings->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Settings Updated Successfuly']);
        }
    }

    public function mount()
    {
        $sell_settings = Configuration::find(1);

        $this->vat = $sell_settings->vat;
        $this->enable_points = $sell_settings->enable_points;
        $this->earning_points = $sell_settings->earning_points;
        $this->per_amount = $sell_settings->per_amount;
        $this->max_point_per_invoice = $sell_settings->max_point_per_invoice;
        $this->money_per_point = $sell_settings->money_per_point;
        $this->min_amount_to_use_points = $sell_settings->min_amount_to_use_points;
        $this->use_points_per_amount = $sell_settings->use_points_per_amount;
    }
    
    public function render()
    {
        return view('livewire.configuration.sell.sell-settings-component')->layout('base.base');
    }
}
