<?php

namespace App\Http\Livewire\Expences\Expences;

use Livewire\Component;

use App\Models\Expence;
use Carbon\Carbon;

class ExpencesComponent extends Component
{

    public $month,$expences, $expence_total;

    public function get_expences()
    {
        $this->expence_total = 0;

        $date = $this->month;
        $month = Carbon::parse($date)->format('m');
        $year = Carbon::parse($date)->format('Y');
        if ($month && $year) {
            $this->expences = Expence::whereMonth('date',$month)->whereYear('date',$year)->with('user')->orderBy('date','ASC')->get();
        }
        if ($this->expences) {
            foreach ($this->expences as $key => $value) {
                $this->expence_total = $this->expence_total + $value->amount;
            }
        }
        
        // dd($month,$year, $this->expences);
    }
    public function render()
    {
        return view('livewire.expences.expences.expences-component')->layout('base.base');
    }
}
