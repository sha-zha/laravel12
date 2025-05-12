<?php

use App\Http\Controllers\ClientsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::resources([ClientsController::class]);

Route::get('/clients', [ClientsController::class,'index'])->name('client.index');
Route::get('/clients/add',[ClientsController::class,'create'])->name('client.create');
Route::get('/clients/edit/{id}',[ClientsController::class,'edit'])->name('client.edit');
Route::post('/clients/create', [ClientsController::class, 'store'])->name('client.store');
Route::put('/clients/update/{id}', [ClientsController::class, 'update'])->name('client.update');
Route::delete('/clients/delete/{id}', [ClientsController::class, 'destroy'])->name('client.destroy');