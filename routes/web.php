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

Route::post('register', [UserController::class, 'register']);
// Route::get('/borrower', [MainController::class, 'mainBorrower']);

// // Route::get('malapatan', [MainController::class, 'malapatan']);
// Route::get('main-account/{acc_id}', [MainController::class, 'mainAccount']);

// Route::get('/privacy-policy', [MainController::class, 'privacypolicy']);

// // Banner
// Route::get('/banner/main', [BannerController::class, 'main']);
// Route::get('/banner/delete/{ban_id}', [BannerController::class, 'delete']);
// Route::post('/banner/save', [BannerController::class, 'save']);
// Route::post('/banner/update', [BannerController::class, 'update']);

// //Login
Route::post('/validate', [LoginController::class, 'validateUser']);
Route::get('logout', [LoginController::class, 'logout']);
// Route::post('loginAccount', [LoginController::class, 'loginAccount']);
// Route::get('forgot-password', [LoginController::class, 'forgotPassword']);

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

//Announcements
Route::post('announcement/save', [AnnouncementController::class, 'save']);
Route::get('announcement/delete/{ann_uuid}', [AnnouncementController::class, 'delete']);

// Admin
Route::get('admin/home', [AdminController::class, 'home']);
Route::get('admin/setup', [AdminController::class, 'setup']);
// Route::get('admin/welcome', [AdminController::class, 'welcome']);
// Route::get('admin/dashboard', [AdminController::class, 'dashboard']);

// Enrollment
Route::post('admin/setup/step-one', [EnrollController::class, 'enroll']);

// Route::get('dashboard', [DashboardController::class, 'main']);
// Route::post('dashboard', [DashboardController::class, 'search']);

// // GOOGLE
// Route::get('/auth/{provider}/redirect', [GoogleController::class, 'redirect']);
// Route::get('auth/{provider}/callback', [GoogleController::class, 'callback']);

// //Contact
// Route::get('contacts/manage', [ContactController::class, 'manage']);
// Route::post('contacts/find', [ContactController::class, 'find']);
// Route::post('contacts/save', [ContactController::class, 'save']);
// Route::get('contacts/edit/{con_uuid}', [ContactController::class, 'edit']);
// Route::post('contacts/update', [ContactController::class, 'update']);
// Route::get('contacts/delete/{con_uuid}', [ContactController::class, 'delete']);
// Route::get('contacts/categories', [ContactController::class, 'categories']);
// Route::post('contacts/save-category', [ContactController::class, 'saveCategory']);
// Route::get('contacts/delete-category/{cat_uuid}', [ContactController::class, 'deleteCategory']);
// Route::post('contacts/update-category', [ContactController::class, 'updateCategory']);

// //SMS
// Route::get('sms/compose/individual', [SMSController::class, 'composeIndividual']);
// Route::post('sms/send/individual', [SMSController::class, 'sendIndividual']);
// Route::get('sms/compose/category', [SMSController::class, 'composeCategory']);
// Route::post('sms/send/category', [SMSController::class, 'sendCategory']);
// Route::get('sms/history', [SMSController::class, 'history']);
// Route::post('sms/history', [SMSController::class, 'history2']);

// // Equipment
// Route::get('equipment/manage', [EquipmentController::class, 'manage']);
// Route::post('equipment/save', [EquipmentController::class, 'save']);
// Route::post('equipment/update', [EquipmentController::class, 'update']);
// Route::get('equipment/activate/{eqp_uuid}', [EquipmentController::class, 'activate']);
// Route::get('equipment/deactivate/{eqp_uuid}', [EquipmentController::class, 'deactivate']);

// // Borrow Equipment
// Route::get('borrow/main', [BorrowController::class, 'main']);
// Route::post('borrow/borrow-equipment', [BorrowController::class, 'borrow']);
// Route::get('borrow/history', [BorrowController::class, 'history']);
// Route::get('borrow/overdue', [BorrowController::class, 'overdue']);
// Route::get('borrow/requests', [BorrowController::class, 'requests']);
// Route::get('borrow/unreturned', [BorrowController::class, 'unreturned']);
// Route::get('borrow/approve/{res_uuid}', [BorrowController::class, 'approve']);
// Route::get('borrow/disapprove/{res_uuid}', [BorrowController::class, 'disapprove']);
// Route::get('borrow/history-all', [BorrowController::class, 'historyAll']);
// Route::get('borrow/return/{res_uuid}', [BorrowController::class, 'return']);
// Route::get('borrow/search', [BorrowController::class, 'search']);
// Route::post('borrow/find', [BorrowController::class, 'find']);

// // Borrower
// Route::get('borrower/manage', [BorrowerController::class, 'manage']);
// Route::post('borrower/save', [BorrowerController::class, 'save']);
// Route::post('borrower/update', [BorrowerController::class, 'update']);
// Route::get('borrower/activate/{bor_uuid}', [BorrowerController::class, 'activate']);
// Route::get('borrower/deactivate/{bor_uuid}', [BorrowerController::class, 'deactivate']);
// Route::get('borrower/reset/{bor_uuid}', [BorrowerController::class, 'reset']);

// // QR
// Route::get('qr/generate/{qrdata}', [QRController::class, 'generate']);


// //Chart Js
// Route::post('/admin/search', [ChartController::class, 'search']);
// Route::get('/default-charts', [ChartController::class, 'defaultCharts']);

Route::get('admin/utility/products', [UtilityController::class, 'product_details']);
Route::post('admin/utility/products/add', [UtilityController::class, 'add_new_product']);

Route::get('admin/utility/categories', [UtilityController::class, 'product_categories']);
Route::post('admin/utility/categories/add', [UtilityController::class, 'add_product_category']);

Route::get('admin/utility/clients', [UtilityController::class, 'clients_manage']);
Route::post('admin/utility/clients/add', [UtilityController::class, 'add_clients_manage']);

Route::get('admin/utility/suppliers', [UtilityController::class, 'suppliers_manage']);
Route::post('admin/utility/suppliers/add', [UtilityController::class, 'add_suppliers_manage']);

// @ POS CONTROLS
// ? RECEIVE
Route::get('pos/receive/new-transaction', [POSController::class, 'pos_receive_main']);
Route::post('/pos-confirm', [POSController::class, 'pos_confirm']);
Route::post('pos/receive/new-transaction/add', [POSController::class, 'pos_receive_add']);

// ? PURCHASE
Route::get('pos/purchase/new-transaction', [POSController::class, 'pos_purchase_main']);
Route::post('pos/purchase/add-items', [POSController::class, 'pos_purchase_add']);

Route::post('pos/purchase/new-transaction/add', [POSController::class, 'pos_purchase_add_transaction']);

// ? DAMAGE
Route::get('pos/damages/create-new', [POSController::class, 'pos_damages_main']);
Route::post('pos/damages/create-new/add', [POSController::class, 'pos_damages_add']);