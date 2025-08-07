<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('sepe');
});

// Ruta dinámica para mostrar el formulario
Route::get('{type}', function ($type) {
    if (!array_key_exists($type, config('pdf.types'))) {
        abort(404);
    }

    return view($type, ['type' => $type]);
});


// Ruta dinámica para procesar el formulario
Route::post('{type}', [PdfController::class, 'generate'])
    ->where('type', 'sepe|eoi|mec');

