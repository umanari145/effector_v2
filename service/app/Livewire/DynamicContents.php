<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicContents extends Component
{
    public $contents;

    public function mount()
    {
        $this->loadContent();
    }

    public function loadContent()
    {
        $path = request()->path();
        $this->contents = $path .  "aaaa";

        if (!$this->contents) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.dynamic-contents')
            ->extends('components.layouts.app')
            ->section('content');
    }
}
