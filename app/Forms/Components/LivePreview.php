<?php

namespace App\Forms\Components;

use App\Http\Controllers\HomepageController;
use Filament\Forms\Components\Field;

class LivePreview extends Field
{
    protected string $view = 'forms.components.live-preview';

    public string $previewContent;

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function getPreviewContent()
    {
        return $this->previewHomePage();
    }

    public function previewHomePage()
    {
        return call_user_func(resolve(HomepageController::class))->render();
    }
}
