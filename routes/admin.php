<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TestimonialController;
use Illuminate\Support\Facades\Route;


// Admin Group Middleware
Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');


    Route::controller(PropertyTypeController::class)->group(function () {

//        Route::get('/all/type', 'allTypes')->name('all.type')->middleware('permission:all.type');
//        Route::get('/add/type', 'addType')->name('add.type')->middleware('permission:all.type');
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

        Route::get('/admin/package/history', 'AdminPackageHistory')->name('admin.package.history');
        Route::get('/package/invoice/{id}', 'PackageInvoice')->name('package.invoice');

        Route::get('/admin/property/message/', 'AdminPropertyMessage')->name('admin.property.message');
        Route::get('/admin/message/details/{id}', 'AdminMessageDetails')->name('admin.message.details');
    });


    // Agent All Route from admin
    Route::controller(AdminController::class)->group(function () {

        Route::get('/all/agent', 'allAgent')->name('all.agent');
        Route::get('/add/agent', 'addAgent')->name('add.agent');
        Route::post('/store/agent', 'storeAgent')->name('store.agent');
        Route::get('/edit/agent/{id}', 'editAgent')->name('edit.agent');
        Route::post('/update/agent/{id}', 'updateAgent')->name('update.agent');
        Route::get('/delete/agent/{id}', 'deleteAgent')->name('delete.agent');

        Route::get('/changeStatus', 'changeStatus');

    });


    // Testimonials  All Routes
    Route::controller(TestimonialController::class)->group(function () {

        Route::get('/all/testimonials', 'AllTestimonials')->name('all.testimonials');
        Route::get('/add/testimonials', 'AddTestimonials')->name('add.testimonials');
        Route::post('/store/testimonials', 'StoreTestimonials')->name('store.testimonials');
        Route::get('/edit/testimonials/{id}', 'EditTestimonials')->name('edit.testimonials');
        Route::post('/update/testimonials', 'UpdateTestimonials')->name('update.testimonials');
        Route::get('/delete/testimonials/{id}', 'DeleteTestimonials')->name('delete.testimonials');

    });


    // BlogController Routes
    Route::controller(BlogController::class)->group(function () {

        // Category_blog All Routes
        Route::get('/all/blog/category', 'AllBlogCategory')->name('all.blog.category');
        Route::post('/store/type', 'StoreBlogCategory')->name('store.blog.category');
        Route::get('/blog/category/{id}', 'EditBlogCategory')->name('edit.blog.category');
        Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
        Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');

        // Posts All Routes
        Route::get('/all/post', 'AllPost')->name('all.post');
        Route::get('/add/post', 'AddPost')->name('add.post');
        Route::post('/store/post', 'StorePost')->name('store.post');
        Route::get('/edit/post/{id}', 'EditPost')->name('edit.post');
        Route::post('/update/post', 'UpdatePost')->name('update.post');
        Route::get('/delete/post/{id}', 'DeletePost')->name('delete.post');

    });


    Route::controller(SettingController::class)->group(function () {

        // SMTP Setting All Route
        Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
        Route::post('update/smtp/setting', 'updateSmtpSetting')->name('update.smtp.setting');

        // Site Setting  All Route
        Route::get('/site/setting', 'SiteSetting')->name('site.setting');
        Route::post('/update/site/setting/{id}', 'updateSiteSetting')->name('update.site.setting');
    });

    // Role Controller All Routes
    Route::controller(RoleController::class)->group(function () {

        // Permission All Routes
        Route::get('/all/permission', 'AllPermission')->name('all.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
        Route::post('/update/permission/{id}', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');


        Route::get('/import/permission', 'ImportPermission')->name('import.permission');
        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');


        Route::get('/all/roles', 'AllRoles')->name('all.roles');
        Route::get('/add/roles', 'AddRoles')->name('add.roles');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
        Route::post('/update/roles/{id}', 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');


        Route::get('/add/role/permission/', 'AddRolesPermission')->name('add.roles.permission');
        Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');
        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');
        Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');

    });


    // Admin User All Route
    Route::controller(AdminController::class)->group(function () {

        Route::get('/all/admin', 'AllAdmin')->name('all.admin');

        Route::get('/add/admin', 'AddAdmin')->name('add.admin');

        Route::post('/store/admin', 'StoreAdmin')->name('store.admin');

        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');

        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');

        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');

    });


});
