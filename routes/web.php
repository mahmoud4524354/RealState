<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [UserController::class, 'index']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');

    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');

    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');

    Route::post('/user/password/update', [UserController::class, 'UserUpdatePassword'])->name('user.password.update');

});


Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');
});


// Admin Group Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');


    Route::controller(PropertyTypeController::class)->group(function () {

        Route::get('/all/type', 'allTypes')->name('all.type');
        Route::get('/add/type', 'addType')->name('add.type');
        Route::post('/store/type', 'storeType')->name('store.type');
        Route::get('/edit/type/{id}', 'editType')->name('edit.type');
        Route::post('/update/type/{id}', 'updateType')->name('update.type');
        Route::get('/delete/type/{id}', 'deleteType')->name('delete.type');


        Route::get('/all/amenitie', 'allAmenitie')->name('all.amenitie');
        Route::get('/add/amenitie', 'addAmenitie')->name('add.amenitie');
        Route::post('/store/amenitie', 'storeAmenitie')->name('store.amenitie');
        Route::get('/edit/amenitie/{id}', 'editAmenitie')->name('edit.amenitie');
        Route::post('/update/amenitie/{id}', 'updateAmenitie')->name('update.amenitie');
        Route::get('/delete/amenitie/{id}', 'deleteAmenitie')->name('delete.amenitie');

    });

    Route::controller(PropertyController::class)->group(function () {
        Route::get('/all/property', 'allProperty')->name('all.property');
        Route::get('/add/property', 'addProperty')->name('add.property');
        Route::post('/store/property', 'storeProperty')->name('store.property');
        Route::get('/edit/property/{id}', 'editProperty')->name('edit.property');


        Route::post('/update/property', 'UpdateProperty')->name('update.property');
        Route::post('/update/property/thambnail', 'UpdatePropertyThambnail')->name('update.property.thambnail');
        Route::post('/update/property/multiimage', 'UpdatePropertyMultiimage')->name('update.property.multiimage');


        Route::get('/property/multiimg/delete/{id}', 'PropertyMultiImageDelete')->name('property.multiimg.delete');

        Route::post('/store/new/multiimage', 'StoreNewMultiimage')->name('store.new.multiimage');

        Route::post('/update/property/facilities', 'UpdatePropertyFacilities')->name('update.property.facilities');

        Route::get('/delete/property/{id}', 'DeleteProperty')->name('delete.property');

        Route::get('/details/property/{id}', 'DetailsProperty')->name('details.property');

        Route::post('/inactive/property', 'InactiveProperty')->name('inactive.property');

        Route::post('/active/property', 'ActiveProperty')->name('active.property');

    });

});


// Agent Group Middleware
Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
});

// Property Type All Route


require __DIR__ . '/auth.php';


