<?php


use App\Http\Controllers\Agent\AgentBuyPackageController;
use App\Http\Controllers\Agent\AgentPropertyController;
use App\Http\Controllers\Agent\AgentScheduleController;
use App\Http\Controllers\AgentController;
use Illuminate\Support\Facades\Route;


// Agent Group Middleware
Route::middleware(['auth', 'roles:agent'])->group(function () {
    Route::get('agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');

    Route::get('/agent/profile', [AgentController::class, 'agentProfile'])->name('agent.profile');

    Route::post('/agent/profile/store', [AgentController::class, 'agentProfileUpdate'])->name('agent.profile.store');

    Route::get('/agent/change/password', [AgentController::class, 'agentChangePassword'])->name('agent.change.password');

    Route::post('/agent/update/password', [AgentController::class, 'agentUpdatePassword'])->name('agent.update.password');


    // Agent All Property
    Route::controller(AgentPropertyController::class)->group(function () {

        Route::get('/agent/all/property', 'AgentAllProperty')->name('agent.all.property');
        Route::get('/agent/add/property', 'AgentAddProperty')->name('agent.add.property');

        Route::post('/agent/store/property', 'AgentStoreProperty')->name('agent.store.property');

        Route::get('/agent/edit/property/{id}', 'AgentEditProperty')->name('agent.edit.property');

        Route::post('/agent/update/property', 'AgentUpdateProperty')->name('agent.update.property');

        Route::post('/agent/update/property/thambnail', 'AgentUpdatePropertyThambnail')->name('agent.update.property.thambnail');

        Route::post('/agent/update/property/multiimage', 'AgentUpdatePropertyMultiimage')->name('agent.update.property.multiimage');

        Route::get('/agent/property/multiimg/delete/{id}', 'AgentPropertyMultiimgDelete')->name('agent.property.multiimg.delete');

        Route::post('/agent/store/new/multiimage', 'AgentStoreNewMultiimage')->name('agent.store.new.multiimage');

        Route::post('/agent/update/property/facilities', 'AgentUpdatePropertyFacilities')->name('agent.update.property.facilities');

        Route::get('/agent/details/property/{id}', 'AgentDetailsProperty')->name('agent.details.property');

        Route::get('/agent/delete/property/{id}', 'AgentDeleteProperty')->name('agent.delete.property');

        Route::get('/agent/property/message/', 'AgentPropertyMessage')->name('agent.property.message');
        Route::get('/agent/message/details/{id}', 'AgentMessageDetails')->name('agent.message.details');
    });


    // Schedule Request Route
    Route::controller(AgentScheduleController::class)->group(function () {

        Route::get('/agent/schedule/request/', 'AgentScheduleRequest')->name('agent.schedule.request');

        Route::get('/agent/details/schedule/{id}', 'AgentDetailsSchedule')->name('agent.details.schedule');

        Route::post('/agent/update/schedule/', 'AgentUpdateSchedule')->name('agent.update.schedule');
    });


    Route::controller(AgentBuyPackageController::class)->group(function () {

        Route::get('/buy/package', 'BuyPackage')->name('buy.package');
        Route::get('/buy/business/plan', 'BuyBusinessPlan')->name('buy.business.plan');
        Route::post('/store/business/plan', 'StoreBusinessPlan')->name('store.business.plan');
        Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
        Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');

        Route::get('/package/history', 'PackageHistory')->name('package.history');
        Route::get('/agent/package/invoice/{id}', 'AgentPackageInvoice')->name('agent.package.invoice');

    });


});
