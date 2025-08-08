<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class FormRequestBindingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::bind('form_request', function ($value, $route) {
            $type = $route->parameter('type');

            $map = config('forms.types');

            if (!isset($map[$type])) {
                abort(404, "Formulario no reconocido: $type");
            }

            $formRequestClass = $map[$type];

            /** @var FormRequest $request */
            $request = app($formRequestClass);

            $request->setContainer(app())->setRedirector(app('redirect'));
            $request->validateResolved();

            return $request;
        });
    }
}
