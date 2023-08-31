<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerifyMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductContrller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;

// login & registration routes
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp-code', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
// verify token by middleware
Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerifyMiddleware::class]);

//profile
Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/update-profile', [UserController::class, 'UpdateProfile'])->middleware([TokenVerifyMiddleware::class]);

// logout
Route::get('logout', [UserController::class, 'UserLogout']);


// Page Routes
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/productPage',[ProductContrller::class,'ProductPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerifyMiddleware::class]);


// Category API
Route::post('/create-category',[CategoryController::class,'CategoryCreate'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/list-category',[CategoryController::class,'CategoryList'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/delete-category',[CategoryController::class,'CategoryDelete'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/update-category',[CategoryController::class,'UpdateCategory'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/category-by-id',[CategoryController::class,'CategoryByID'])->middleware([TokenVerifyMiddleware::class]);

// Category API
Route::post('/create-customer',[CustomerController::class,'CreateCustomer'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/list-customer',[CustomerController::class,'ListCustomer'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/delete-customer',[CustomerController::class,'DeleteCustomer'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/update-customer',[CustomerController::class,'UpdateCustomer'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/customer-by-id',[CustomerController::class,'CustomerByID'])->middleware([TokenVerifyMiddleware::class]);


// Product API
Route::post('/create-product',[ProductContrller::class,'CreateProduct'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/delete-product',[ProductContrller::class,'DeleteProduct'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/list-product',[ProductContrller::class,'ListProduct'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/update-product',[ProductContrller::class,'UpdateProduct'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/product-by-id',[ProductContrller::class,'ProductByID'])->middleware([TokenVerifyMiddleware::class]);

// Invoice API
Route::post('/create-invoice',[InvoiceController::class,'invoiceCreate'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/delete-invoice',[InvoiceController::class,'invoiceDelete'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/invoice-details',[InvoiceController::class,'invoiceDetails'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/invoice-select',[InvoiceController::class,'invoiceSelect'])->middleware([TokenVerifyMiddleware::class]);

// Summary & Report
Route::get('/summary', [DashboardController::class, 'Summary'])->middleware([TokenVerifyMiddleware::class]);

