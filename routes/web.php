<?php

use App\Http\Controllers\ArchetypeController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\TestingSeriesController;
use App\Http\Controllers\TestResultController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return Inertia::render('Welcome', [
		'canLogin'    => Route::has('login'),
		'canRegister' => Route::has('register'),
	]);
});

Route::get('/dashboard', function () {
	return Inertia::render('Dashboard');
})->middleware([ 'auth', 'verified' ])->name('dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ ProfileController::class, 'edit' ])->name('profile.edit');
	Route::patch('/profile', [ ProfileController::class, 'update' ])->name('profile.update');
	Route::delete('/profile', [ ProfileController::class, 'destroy' ])->name('profile.destroy');

	Route::apiResources([
		'/archetypes'      => ArchetypeController::class,
		'/decks'           => DeckController::class,
		'/formats'         => FormatController::class,
		'/sets'            => SetController::class,
		'/testing_results' => TestResultController::class,
		'/testing_series'  => TestingSeriesController::class,
	]);
});

require __DIR__ . '/auth.php';
