<?php

use App\Http\Controllers\Contact\{CreateContactController, CreateContactPageController, UpdateContactController, ListContactsController, DeleteContactController, ExportContactController, ImportContactController, ToggleContactController, UpdateContactPageController};
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/contacts', ListContactsController::class)->name('contact.index');
Route::get('/contacts/create', CreateContactPageController::class)->name('contact.create');
Route::post('/contacts', CreateContactController::class)->name('contact.store');
Route::get('/contacts/{id}/edit', UpdateContactPageController::class)->name('contact.edit');
Route::put('/contacts/{id}', UpdateContactController::class)->name('contact.update');
Route::delete('/contacts/{id}', DeleteContactController::class)->name('contact.delete');
Route::get('/contacts/export', ExportContactController::class)->name('contact.export');
Route::post('/contacts/import', ImportContactController::class)->name('contact.import');
Route::patch('/contacts/{contact}/toggle-favorite', ToggleContactController::class)->name('contacts.toggle-favorite');
