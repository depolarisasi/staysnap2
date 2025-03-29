<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HomeSlider;

class SliderFront extends Component
{

    public $slides = [];


    public function mount(){
        $this->slides = HomeSlider::get();
    }
    public function render()
    {
        return view('livewire.slider-front');
    }
}
