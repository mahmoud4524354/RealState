<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\ChatController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
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

Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('agent/login', [AgentController::class, 'login'])->name('agent.login');
});

Route::get('/', [UserController::class, 'index']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// User Group Middleware
Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');

    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');

    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');

    Route::post('/user/password/update', [UserController::class, 'UserUpdatePassword'])->name('user.password.update');

    // User WishlistAll Route
    Route::controller(WishlistController::class)->group(function () {

        Route::get('/user/wishlist', 'UserWishlist')->name('user.wishlist');
        Route::get('/get-wishlist-property', 'GetWishlistProperty');
        Route::get('/wishlist-remove/{id}', 'WishlistRemove');


    });

    // User Compare All Route
    Route::controller(CompareController::class)->group(function () {

        Route::get('/user/compare', 'UserCompare')->name('user.compare');
        Route::get('/get-compare-property', 'GetCompareProperty');
        Route::get('/compare-remove/{id}', 'CompareRemove');

    });


    Route::get('/user/schedule/request', [UserController::class, 'UserScheduleRequest'])->name('user.schedule.request');

    Route::get('/live/chat', [UserController::class, 'LiveChat'])->name('live.chat');



});



require __DIR__ . '/auth.php';


// Frontend Property Details All Route
Route::get('/property/details/{id}/{slug}', [IndexController::class, 'PropertyDetails']);

// Add Wishlist Route
Route::post('/add-to-wishList/{property_id}', [WishlistController::class, 'AddToWishList']);

// Add Compare Route
Route::post('/add-to-compare/{property_id}', [CompareController::class, 'AddToCompare']);

// Send Message from Property Details Page
Route::post('/property/message', [IndexController::class, 'PropertyMessage'])->name('property.message');

// Agent Details Page in Frontend
Route::get('/agent/details/{id}', [IndexController::class, 'AgentDetails'])->name('agent.details');

// Send Message from Agent Details Page
Route::post('/agent/details/message', [IndexController::class, 'AgentDetailsMessage'])->name('agent.details.message');

// Get All Rent Property
Route::get('/rent/property', [IndexController::class, 'RentProperty'])->name('rent.property');

// Get All Buy Property
Route::get('/buy/property', [IndexController::class, 'BuyProperty'])->name('buy.property');

// Get All Property Type Data
Route::get('/property/type/{id}', [IndexController::class, 'PropertyType'])->name('property.type');

// Get State Details Data
Route::get('/state/details/{id}', [IndexController::class, 'StateDetails'])->name('state.details');

// Get State Details Data
Route::get('/state/details/{id}', [IndexController::class, 'StateDetails'])->name('state.details');

// State  All Route
Route::controller(StateController::class)->group(function () {

    Route::get('/all/state', 'AllState')->name('all.state');
    Route::get('/add/state', 'AddState')->name('add.state');
    Route::post('/store/state', 'StoreState')->name('store.state');
    Route::get('/edit/state/{id}', 'EditState')->name('edit.state');
    Route::post('/update/state', 'UpdateState')->name('update.state');
    Route::get('/delete/state/{id}', 'DeleteState')->name('delete.state');

});


// Home Page Buy Search Option
Route::post('/buy/property/search', [IndexController::class, 'BuyPropertySearch'])->name('buy.property.search');

// Home Page Rent Search Option
Route::post('/rent/property/search', [IndexController::class, 'RentPropertySearch'])->name('rent.property.search');

// All Property Seach Option
Route::post('/all/property/search', [IndexController::class, 'AllPropertySearch'])->name('all.property.search');

// Blog Details Routes
Route::get('/blog/details/{slug}', [BlogController::class, 'BlogDetails']);
Route::get('/blog/category/list/{id}', [BlogController::class, 'BlogCatList']);
Route::get('/blog', [BlogController::class, 'BlogList'])->name('blog.list');

Route::post('/store/comment', [BlogController::class, 'StoreComment'])->name('store.comment');
Route::get('/admin/blog/comment', [BlogController::class, 'AdminBlogComment'])->name('admin.blog.comment');

Route::get('/admin/comment/reply/{id}', [BlogController::class, 'AdminCommentReply'])->name('admin.comment.reply');
Route::post('/reply/message', [BlogController::class, 'ReplyMessage'])->name('reply.message');


// Schedule Message Request Route
Route::post('/store/schedule', [IndexController::class, 'StoreSchedule'])->name('store.schedule');



// Chat Post Request Route
Route::post('/send-message', [ChatController::class, 'SendMsg'])->name('send.msg');

Route::get('/user-all', [ChatController::class, 'GetAllUsers']);

Route::get('/user-message/{id}', [ChatController::class, 'UserMsgById']);

Route::get('/agent/live/chat', [ChatController::class, 'AgentLiveChat'])->name('agent.live.chat');

