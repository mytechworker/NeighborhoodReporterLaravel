<?php

use Illuminate\Support\Facades\Route;
use admin\RegionController;
use admin\CommunitieController;
use admin\AdvertiseController;
use admin\FaqCategoryController;
use admin\FaqController;
use admin\AdminController;
use admin\CategoryController;
use admin\PressReleaseController;
use admin\PostController;
use admin\FeatureBusinessController;
use admin\ClassifiedController;
use admin\EventController;
use admin\PageController;
use admin\UserController;
use admin\TicketController;
use admin\BannerImageController;

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

// Post Route
Route::get('/', 'HomeController@index')->name('home');
Route::post('load-data', 'HomeController@loadMoreData')->name('load-data');
Route::post('post-like', 'HomeController@postLike')->name('post-like');
Route::post('post-report', 'HomeController@postReport')->name('post-report');
Route::get('/p/{location}/{town}/{guid}', 'ArticleController@details', function ($location, $town, $guid) {
    
})->name('post-details');
Route::get('/r/{location}', 'HomeController@region', function ($location) {
    
})->name('region-details');
Route::get('/reply/{id}/{type}/nodx', 'UserController@redirectPost', function ($id, $type) {
    
})->name('redirect');

// Neighbour post route
Route::post('neighbour-load-data', 'PostController@neighbourMoreData')->name('neighbour-load-data');
Route::get('/n/{location}/{town}/{guid}', 'ArticleController@neighborDetails', function ($location, $town, $guid) {
    
})->name('neighbour-details');

// Advertise Route
Route::get('/across-america/advertise-with-us', 'AdvertisementController@index')->name('advertise');
Route::post('/across-america/advertise-add', 'AdvertisementController@store')->name('advertise-store');

// Location Route
Route::get('/l/{location}/{town}', 'PostController@location', function ($location, $town) {
    
})->name('location-details');
Route::get('/{location}/{town}/post', 'PostController@neighborLocation', function ($location, $town) {
    
})->name('neighbor-details');
Route::get('/l/{location}/{town}/{category}', 'PostController@categoryPost', function ($location, $town, $category) {
    
})->name('category-details');
Route::post('category-load-data', 'PostController@loadCategoryMoreData')->name('category-load-data');
Route::post('location-load-data', 'PostController@loadMoreData')->name('location-load-data');

// Event Route
Route::post('event-load-data', 'PostController@eventMoreData')->name('event-load-data');
Route::post('event-intrest', 'PostController@eventIntrest')->name('event-intrest');
Route::get('/e/{id}/{name}', 'EventController@details', function ($id, $name) {
    
})->name('event-details');

// Classified Route
Route::get('/c/{id}/{name}', 'ClassifiedController@details', function ($id, $name) {
    
})->name('classified-details');
Route::post('classified-load-data', 'PostController@classifiedMoreData')->name('classified-load-data');


//Map route
Route::get('/map', 'MapController@index')->name('map');

//Calender Route
Route::get('/{location}/{town}/calendar', 'CalendarController@index', function ($location, $town) {
    
})->name('event-details');
Route::post('calendarFilterData', 'CalendarController@getFilterData')->name('calendar-filter-data');

//marketplace route
Route::get('/{location}/{town}/marketplace', 'MarketplaceController@index', function ($location, $town) {
    
})->name('marketplace-listing');
Route::get('/{location}/{town}/classifieds/{category}', 'MarketplaceController@categoryClassified', function ($location, $town, $category) {
    
})->name('category-classified');

// Add and store article
Route::get('/add/article', 'ArticleController@index')->name('add-article');
Route::post('/add/article', 'ArticleController@store')->name('article-store');
Route::post('/add/articlecomment', 'ArticleController@addComment')->name('add-article-comment');
Route::post('/edit/articlecomment', 'ArticleController@editComment')->name('edit-article-comment');
Route::post('/delete/articlecomment', 'ArticleController@deleteComment')->name('delete-article-comment');
Route::post('/add/neighborcomment', 'ArticleController@addNeighborComment')->name('add-neighbor-comment');
Route::post('dropzone/upload_image', 'ArticleController@upload_image')->name('dropzone.upload_image');
Route::get('dropzone/delete_image', 'ArticleController@delete_image')->name('dropzone.delete_image');
Route::get('/article/{id}/edit', 'ArticleController@edit')->name('article.edit');
Route::post('/article/update', 'ArticleController@update')->name('article-update');
Route::get('/article/delete/{id}', 'ArticleController@destroy')->name('article.delete');


// Add post and more
Route::get('/my/article', 'ArticleController@index')->name('my-post');
Route::get('/{location}/{town}/compose', 'ArticleController@neighborCompose', function ($location, $town) {
    
})->name('compose-neighbor');
Route::post('/add/compose', 'ArticleController@storeNeighborPost')->name('neighbor-store');

// Add classifid and more
Route::get('/{location}/{town}/compose/classified', 'ClassifiedController@index', function ($location, $town) {
    
})->name('compose-classified');
Route::post('/add/classified', 'ClassifiedController@store')->name('classified-store');
Route::post('/add/classifiedcomment', 'ClassifiedController@addComment')->name('add-classified-comment');
Route::post('/edit/classifiedcomment', 'ClassifiedController@editComment')->name('edit-classified-comment');
Route::post('/delete/classifiedcomment', 'ClassifiedController@deleteComment')->name('delete-classified-comment');
Route::post('/send/classifiedcontact', 'ClassifiedController@sendContact')->name('sent-classified-contact');
Route::get('/classified/{id}/edit', 'ClassifiedController@edit')->name('classified.edit');
Route::post('/classified/update', 'ClassifiedController@update')->name('classified-update');
Route::get('/classified/delete/{id}', 'ClassifiedController@destroy')->name('classified.delete');

// Add event and more
Route::get('/{location}/{town}/compose/event', 'EventController@index', function ($location, $town) {
    
})->name('compose-event');
Route::get('searchEvent', 'EventController@search_community')->name('search_event_community');
Route::post('/add/event', 'EventController@store')->name('event-store');
Route::post('/add/eventcomment', 'EventController@addComment')->name('add-event-comment');
Route::post('/edit/eventcomment', 'EventController@editComment')->name('edit-event-comment');
Route::post('/delete/eventcomment', 'EventController@deleteComment')->name('delete-event-comment');
Route::get('/event/{id}/edit', 'EventController@edit')->name('event.edit');
Route::post('/event/update', 'EventController@update')->name('event-update');
Route::get('/event/delete/{id}', 'EventController@destroy')->name('event.delete');

// Add feature bussiness and more
Route::get('/{location}/{town}/compose/bizpost', 'BizpostController@index', function ($location, $town) {
    
})->name('bizpost');
Route::get('/b/{id}/{name}', 'BizpostController@details', function ($id, $name) {
    
})->name('bizpost-details');
Route::post('/add/bizpost', 'BizpostController@store')->name('bizpost-store');
Route::get('/bizpost/{id}/edit', 'BizpostController@edit')->name('bizpost.edit');
Route::post('/bizpost/update', 'BizpostController@update')->name('bizpost-update');
Route::get('/bizpost/delete/{id}', 'BizpostController@destroy')->name('bizpost.delete');
Route::post('/bizpost/sendMail', 'BizpostController@sendMail')->name('bizpost-sendMail');

// View Profile
Route::get('/users/{id}', 'UserController@viewProfile', function ($id) {
    
})->name('view-profile');
// My community
Route::get('/profile/edit', 'UserController@myCommunity', function ($id) {
    
})->name('myCommunity');
Route::post('/add/community', 'UserController@addCommunity')->name('community-store');
Route::post('/add/follower', 'UserController@addFollower')->name('follower-store');
Route::post('/remove/follower', 'UserController@removeFollower')->name('remove-follower');
// Route::get('/admin', function () {
//     return view('auth.login');
// });
Route::get('/content', 'ManagePostsController@index')->name('manage-post');
Route::get('/content/articles/draft', 'ManagePostsController@draftArticle')->name('manage-draft-post');
Route::get('/content/events', 'ManagePostsController@events')->name('manage-events-post');
Route::get('/content/classified', 'ManagePostsController@classified')->name('manage-classified-post');
Route::get('/content/bizpost', 'ManagePostsController@bizpost')->name('manage-bizpost');
Route::post('articleDelete', 'ManagePostsController@destroy')->name('articlesDelete');
Route::post('articlesDeleteAll', 'ManagePostsController@deleteAll')->name('articlesDeleteAll');

Auth::routes();
Route::get('search', 'UserController@search_community')->name('search_community');
Route::get('register', 'UserController@register')->name('user.register');
Route::post('user/login', '\App\Http\Controllers\Auth\LoginController@login')->name('user.login');
Route::post('user_register', 'UserController@user_register')->name('u.register');
Route::get('user_dashboard', 'UserController@dashboard')->name('user.dashboard')->middleware(['auth']);

//Google login
Route::get('login/{google}', 'Auth\LoginController@redirectToGoogle')->name('login.google');
Route::get('login/{google}/callback', 'Auth\LoginController@handleGoogleCallback');


//Facebook login
Route::get('login/{facebook}', 'Auth\LoginController@redirectToFacebook')->name('login.facebook');
Route::get('login/{facebook}/callback', 'Auth\LoginController@handleFacebookCallback');

Route::get('faqCategory', 'FaqCategoryController@get_faq_category');
Route::get('faqCategory/{id}', 'FaqCategoryController@faq_listing')->name('faq_listing');
Route::get('faq_detail/{id}', 'FaqCategoryController@faq_detail')->name('faq_detail');
Route::get('about', 'FooterPageController@about');
Route::get('community-guidelines', 'FooterPageController@community_guidelines');
Route::get('posting-instructions', 'FooterPageController@posting_instructions');
Route::get('terms', 'FooterPageController@terms');
Route::get('privacy', 'FooterPageController@privacy');
Route::get('contact-us', 'FooterPageController@contact_us');
Route::get('submit_request', 'TicketController@create')->name('submit-request');
Route::post('submit_request', 'TicketController@store')->name('submit-request-store');
Route::get('search_faq_category', 'FaqCategoryController@search_faq_category')->name('search_faq_category');
Route::get('search_faq_category/{id}', 'FaqCategoryController@search_faq_listing')->name('search_faq_listing');
Route::get('view_profile/{name?}', 'UserController@view_profile')->name('view_profile');

//view user
Route::get('add/user-profile', 'UserProfleController@index')->name('add-user');
Route::post('update/user-profile', 'UserProfleController@update')->name('update-user');
Route::get('user-community', 'UserProfleController@search_community')->name('search_user_community');
Route::get('update-password', 'UserProfleController@changePasswordform');
Route::post('update-password', 'UserProfleController@changePassword')->name('update.password');
Route::get('/{location}/{town}/invite', 'InviteController@create', function ($location, $town) {
    
})->name('invite');
Route::post('invite-store', 'InviteController@store')->name('store.invite');
Route::get('/{location}/{town}/register', 'UserController@register', function ($location, $town) {
    
})->name('register');

//email setting
Route::get('settings/email', 'SettingEmailController@index')->name('settings-email');
Route::post('save/email', 'SettingEmailController@store')->name('save-email');
Route::post('add/email', 'SettingEmailController@addEmail')->name('add-email');

Route::get('test','TestController@test');
Route::get('/{location?}/{town?}/advertise-with-us', 'AdvertisementController@index')->name('advertise');
Route::get('/{location}/{town}/subscribe', 'SubscribeController@create')->name('create-subscribe');
Route::post('/subscribe', 'SubscribeController@store')->name('store-subscribe');

Route::get('forget-password', 'ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post'); 
Route::get('reset-password/{token}', 'ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

/* admin route start */

Route::prefix('admin')->group(function () {
    // Auth::routes();
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    Route::post('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', '\App\Http\Controllers\admin\DashboardController@index')->name('dashboard')->middleware(['is_admin']);
    Route::resource('regions', RegionController::class)->middleware(['auth', 'is_admin']);
    Route::resource('communities', CommunitieController::class)->middleware(['auth', 'is_admin']);
    Route::resource('advertises', AdvertiseController::class)->middleware(['auth', 'is_admin']);
    Route::resource('faq_categories', FaqCategoryController::class)->middleware(['auth', 'is_admin']);
    Route::resource('faqs', FaqController::class)->middleware(['auth', 'is_admin']);
    Route::resource('users', AdminController::class)->middleware(['auth', 'is_admin']);
    Route::resource('categories', CategoryController::class)->middleware(['auth', 'is_admin']);
    Route::get('change-password', '\App\Http\Controllers\admin\ChangePasswordController@index')->middleware(['auth', 'is_admin']);
    Route::post('change-password', '\App\Http\Controllers\admin\ChangePasswordController@changePassword')->name('change.password')->middleware(['auth', 'is_admin']);
    Route::resource('press_releases', PressReleaseController::class)->middleware(['auth', 'is_admin']);
    Route::resource('post', PostController::class)->middleware(['auth', 'is_admin']);
    Route::get('view_post_report/{id}', '\App\Http\Controllers\admin\PostController@view_report')->middleware(['auth', 'is_admin']);
    Route::resource('feature_business', FeatureBusinessController::class)->middleware(['auth', 'is_admin']);
    //Route::get('view_feature_business_report/{id}', '\App\Http\Controllers\admin\FeatureBusinessController@view_report')->middleware(['auth', 'is_admin']);
    Route::resource('classified', ClassifiedController::class)->middleware(['auth', 'is_admin']);
    Route::get('view_classified_report/{id}', '\App\Http\Controllers\admin\ClassifiedController@view_report')->middleware(['auth', 'is_admin']);
    Route::resource('event', EventController::class)->middleware(['auth', 'is_admin']);
    Route::get('view_event_report/{id}', '\App\Http\Controllers\admin\EventController@view_report')->middleware(['auth', 'is_admin']);
    Route::resource('pages', PageController::class)->middleware(['auth', 'is_admin']);
    Route::resource('user', UserController::class)->middleware(['auth', 'is_admin']);
    Route::resource('tickets', TicketController::class)->middleware(['auth', 'is_admin']);
    Route::resource('banner_images', BannerImageController::class)->middleware(['auth', 'is_admin']);
});

/* admin route end */