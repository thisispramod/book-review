<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StartRating extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public readonly float $rating;

    public function __construct(float $rating)
    {
        $this->rating = $rating;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.start-rating');
    }
}
