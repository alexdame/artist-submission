<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaystackController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\ArtistSubmissionController;

Route::middleware(['auth'])->group(function () {
    Route::get('/submission', [ArtistSubmissionController::class, 'create'])->name('submission.create');
    Route::post('/submission', [ArtistSubmissionController::class, 'store'])->name('submission.store');
   Route::get('/artist/submit', [ArtistSubmissionController::class, 'showForm'])->name('artist.submit.form');
    Route::post('/artist/submit', [ArtistSubmissionController::class, 'submit'])->name('artist.submit');

Route::get('/submit-music', [ArtistSubmissionController::class, 'create'])->name('artist.submission.form');
Route::post('/submit-music', [ArtistSubmissionController::class, 'store'])->name('artist.submission.store');
Route::get('/submission-success', [ArtistSubmissionController::class, 'success'])->name('submission.success');


    Route::get('/submissions', [ArtistSubmissionController::class, 'index'])->name('artist.submissions'); // for founder
});

// routes/web.php






// use App\Http\Controllers\ArtistSubmissionController;

// Route::get('/submit', [ArtistSubmissionController::class, 'create'])->name('submission.form');
// Route::post('/submit', [ArtistSubmissionController::class, 'store'])->name('submission.store');
// Route::get('/founder/dashboard', [ArtistSubmissionController::class, 'dashboard'])->middleware('auth')->name('founder.dashboard');


use App\Http\Controllers\FounderController;

Route::prefix('founder')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [FounderController::class, 'index'])->name('founder.dashboard');
    Route::get('/download/artwork/{id}', [FounderController::class, 'downloadArtwork'])->name('founder.download.artwork');
    Route::get('/download/music/{id}', [FounderController::class, 'downloadMusic'])->name('founder.download.music');
    Route::get('/export/csv', [FounderController::class, 'exportCSV'])->name('founder.export.csv');
    Route::get('/export/excel', [FounderController::class, 'exportExcel'])->name('founder.export.excel');
Route::get('/founder/export/xlsx', [FounderController::class, 'exportXLSX'])->name('founder.export.xlsx');


});



use App\Http\Controllers\RoyaltyController;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/upload-royalty', [RoyaltyController::class, 'showUploadForm'])->name('admin.royalty.upload.form');
    Route::post('/admin/upload-royalty', [RoyaltyController::class, 'upload'])->name('admin.royalty.upload');
});

use App\Http\Controllers\PlanController;



Route::middleware(['auth'])->group(function () {
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/select/{id}', [PlanController::class, 'select'])->name('plans.select');
    Route::post('/paystack/pay', [PlanController::class, 'redirectToPaystack'])->name('paystack.redirect');
Route::get('/paystack/callback', [PlanController::class, 'handleGatewayCallback'])->name('paystack.callback');
Route::get('/plans', [PlanController::class, 'showPlans'])->name('plans.index');


});






Route::get('/pay', function () {
    return view('pay');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/paystack/initiate/{plan_id}', [PaystackController::class, 'initiate'])->name('paystack.initiate');
    Route::get('/paystack/callback', [PaystackController::class, 'callback'])->name('paystack.callback');
Route::post('/pay', [PaystackController::class, 'redirectToGateway'])->name('paystack.pay');
Route::get('/payment/callback', [PaystackController::class, 'handleGatewayCallback'])->name('paystack.callback');
Route::get('/admin/transactions', [PaystackController::class, 'adminTransactions'])->name('admin.transactions');
Route::get('/admin/transactions/export', [PaystackController::class, 'exportTransactions'])->name('admin.transactions.export');
Route::get('/admin/transactions/{reference}', [PaystackController::class, 'viewTransaction'])->name('admin.transactions.view');
Route::get('/paystack/callback', [PaystackController::class, 'handleCallback'])->name('paystack.callback');
Route::get('/payment-history', [PaystackController::class, 'paymentHistory'])->name('payment.history')->middleware('auth');




});

use App\Http\Controllers\PaymentController;

Route::middleware(['auth'])->group(function () {
    Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
    Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback'])->name('payment.callback');
});



require __DIR__.'/auth.php';
