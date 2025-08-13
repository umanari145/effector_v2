<?php

namespace App\Livewire;

use Livewire\Component;

class DynamicContents extends Component
{
    public $contents;
    public $path;

    public function mount()
    {
        $this->path = request()->path();
        $this->loadContent();
    }

    public function loadContent()
    {
        $this->contents = "aaaa";

        if (!$this->contents) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.' . $this->path)
            ->extends('components.layouts.app')
            ->section('content');
    }
}
