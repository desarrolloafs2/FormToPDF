<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

use App\Services\Contracts\PdfFormFormatterInterface;

class FormFormatterBindingServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $this->app->bind(PdfFormFormatterInterface::class, function () {
            $type = request()->route('type');
            $config = config("forms.types.$type.formatter");


            if (!class_exists($config)) {
                abort(404, "No se ha encontrado un formatter para el tipo '{$type}'.");
            }

            return app($config);
        });
    }
}
