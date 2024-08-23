<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Mechanisms\HandleComponents\HandleComponents;

class LivePreview extends Component
{
    public string $title;

    public function mount()
    {
        $parent = $this->getParentComponentInstance();
        // $this->title = $parent->title;
    }

    private function getParentComponentInstance()
    {
        return app(HandleComponents::class)::$componentStack[0];
    }

    public function render()
    {
        return view('livewire.live-preview');
    }
}
