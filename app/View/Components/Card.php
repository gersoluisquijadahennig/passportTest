<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $client;
    public $url;

    public function __construct($title, $client, $url)
    {
        $this->title = $title;
        $this->client = $client;
        $this->url = $url;
    }

    public function render()
    {
        return view('components.card');
    }
}
