<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormRequestResolverServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Request::macro('resolveFormRequest', function (string $type) {
            $map = config('forms.types');

            if (!isset($map[$type])) {
                abort(404, "Formulario no reconocido: $type");
            }

            /** @var \Illuminate\Http\Request $this */
            return app($map[$type]);
        });
    }
}
