<?php

use App\Livewire\About;
use App\Livewire\AddPayment;
use App\Livewire\Cancel;
// use App\Livewire\Checkout;
use App\Livewire\Contact;
use App\Livewire\Classes;
use App\Livewire\ForgotPassword;
use App\Livewire\Gallery;
use App\Livewire\HandleAbout;
use App\Livewire\HandleClasses;
use App\Livewire\HandleClassType;
use App\Livewire\HandlePricing;
use App\Livewire\HandleSubscription;
use App\Livewire\HandleUsers;
use App\Livewire\Home;
use App\Livewire\Login;
use App\Livewire\Mailings;
use App\Livewire\Order;
use App\Livewire\Payments;
use App\Livewire\Pricing;
use App\Livewire\PrivacyPolicy;
use App\Livewire\Profile;
use App\Livewire\Register;
use App\Livewire\Registration;
use App\Livewire\ResetPassword;
use App\Livewire\Success;
use App\Livewire\Unsubscribe;
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

Route::get('/', Home::class);
Route::get('/classes', Classes::class);
Route::get('/about', About::class);
Route::get('/gallery', Gallery::class)->middleware('auth', 'isAdmin');
Route::get('/contact', Contact::class);
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class);
Route::get('/forgot-password', ForgotPassword::class);
Route::get('/reset-password/{token}', ResetPassword::class);
Route::get('/privacy-policy', PrivacyPolicy::class);

// Route::get('/handle-about', HandleAbout::class)->middleware('auth', 'isAdmin');
Route::get('/handle-users', HandleUsers::class)->middleware('auth', 'isAdmin');
Route::get('/handle-classes', HandleClasses::class)->middleware('auth', 'isAdmin');
Route::get('/handle-class-type', HandleClassType::class)->middleware('auth', 'isAdmin');
Route::get('/handle-pricing', HandlePricing::class)->middleware('auth', 'isAdmin');
Route::get('/handle-subscription', HandleSubscription::class)->middleware('auth', 'isAdmin');
Route::get('/payments', Payments::class)->middleware('auth', 'isAdmin');
Route::get('/add-payment', AddPayment::class)->middleware('auth', 'isAdmin');

Route::get('/pricing', Pricing::class);
// Route::get('/checkout', Checkout::class)->middleware('auth');
Route::get('/success', Success::class)->middleware('auth');
Route::get('/cancel', Cancel::class)->middleware('auth');
Route::get('/registrations', Registration::class)->middleware('auth');
Route::get('/orders', Order::class)->middleware('auth');
Route::get('/unsubscribe/{token}', Unsubscribe::class);
Route::get('/mailings', Mailings::class)->middleware('auth', 'isAdmin');

Route::get('/{user}', Profile::class)->middleware('auth', 'isCurrentUser');

