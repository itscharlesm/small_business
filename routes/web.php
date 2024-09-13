<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\POSController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
// use App\Http\Controllers\QRController;
// use App\Http\Controllers\SMSController;
use App\Http\Controllers\EnrollController;
use App\Http\Controllers\UtilityController;
// use App\Http\Controllers\ChartController;
// use App\Http\Controllers\BannerController;
// use App\Http\Controllers\BorrowController;
// use App\Http\Controllers\GoogleController;
// use App\Http\Controllers\ContactController;
// use App\Http\Controllers\BorrowerController;
// use App\Http\Controllers\RedirectController;
// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\AnnouncementController;

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

//Main
Route::get('/', [MainController::class, 'main']);
Route::get('register', [MainController::class, 'registration']);

// Route::post('register', [UserController::class, 'register']);

// //Login
Route::post('/validate', [LoginController::class, 'validateUser']);
Route::get('logout', [LoginController::class, 'logout']);

// User
// Route::post('user/register', [UserController::class, 'register']);
// Route::get('user/reset/{usr_uuid}', [UserController::class, 'reset']);
// Route::post('user/change-password', [UserController::class, 'updatePassword']);
// Route::post('user/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('user/update', [UserController::class, 'update']);
Route::post('user/update-password', [UserController::class, 'updatePassword2']);
// Route::get('user/list/active', [UserController::class, 'active']);
// Route::get('user/list/inactive', [UserController::class, 'inactive']);
// Route::get('user/list/activate/{usr_uuid}', [UserController::class, 'activate']);
// Route::get('user/list/deactivate/{usr_uuid}', [UserController::class, 'deactivate']);
// Route::get('user/list/add-admin/{usr_uuid}', [UserController::class, 'addAdmin']);
// Route::get('user/list/remove-admin/{usr_uuid}', [UserController::class, 'removeAdmin']);

// Announcements
Route::post('announcement/save', [AnnouncementController::class, 'save']);
Route::get('announcement/delete/{ann_uuid}', [AnnouncementController::class, 'delete']);

// Admin
Route::get('admin/home', [AdminController::class, 'home']);
Route::get('admin/setup', [AdminController::class, 'setup']);

// Transactions
Route::get('admin/pos/new-transaction', [POSController::class, 'pos_main']);
Route::post('admin/pos/new-transaction/payment', [POSController::class, 'payment']);
Route::get('admin/pos/transactions', [POSController::class, 'transaction_history']);
Route::get('admin/pos/cash-on-hand', [POSController::class, 'cash_on_hand']);
Route::post('admin/pos/cash-on-hand/starting-cash', [POSController::class, 'starting_cash']);
Route::post('admin/pos/cash-on-hand/ending-cash', [POSController::class, 'ending_cash']);

// Utility
Route::get('admin/utility/manage-categories', [UtilityController::class, 'category_main']);
Route::post('admin/utility/manage-categories/create', [UtilityController::class, 'category_create']);
Route::post('admin/utility/manage-categories/update/{mcat_id}', [UtilityController::class, 'category_update']);

// ? PURCHASE
Route::get('pos/purchase/new-transaction', [POSController::class, 'pos_purchase_main']);
Route::post('pos/purchase/add-items', [POSController::class, 'pos_purchase_add']);

Route::post('pos/purchase/new-transaction/add', [POSController::class, 'pos_purchase_add_transaction']);

// ? DAMAGE
Route::get('pos/damages/create-new', [POSController::class, 'pos_damages_main']);
Route::post('pos/damages/create-new/add', [POSController::class, 'pos_damages_add']);