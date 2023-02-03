<?php

use App\Http\Controllers\Admin\AdminAuthorsController;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\Admin\AdminBooksController;
use App\Http\Controllers\Admin\AdminCategoriesController;
use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminReviewsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\BookshopHomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\Users\UserOrdersController;
use App\Http\Controllers\Users\UserReviewsController;
use App\Http\Controllers\Users\UsersBaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

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

// Change language
Route::get('/change-language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'vi'])) {
        abort(404);
    }
    App::setLocale($locale);
    // Session
    session()->put('locale', $locale);
//dd(session('locale'));
    return redirect()->back();
});
// Default
Route::get('/', [BookshopHomeController::class, 'index'])->name('bookshop.home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/all-books', [BookshopHomeController::class, 'allBooks'])->name('all-books');
Route::get('/discount-books', [BookshopHomeController::class, 'discountBooks'])->name('discount-books');
Route::get('/category/{slugCategory}', [BookshopHomeController::class, 'category'])->name('category');
Route::get('/book/{slugBook}', [BookshopHomeController::class, 'bookDetails'])->name('book-details');
Route::get('/author/{slugAuthor}', [BookshopHomeController::class, 'author'])->name('author');
Route::post('/book/{book_id}/review', [ReviewsController::class, 'store'])->name('book.review');


// Cart Route
Route::get('/cart/page', [ShoppingCartController::class, 'cart'])->name('cart.page');
Route::post('/cart/add', [ShoppingCartController::class, 'add_to_cart'])->name('cart.store');
Route::get('/cart/delete/{id}', [ShoppingCartController::class, 'cart_delete'])->name('cart.delete');
Route::get('/cart/all/delete', [ShoppingCartController::class, 'cart_delete_all'])->name('cart.deleteAll');
Route::get('/cart/update', [ShoppingCartController::class, 'cart_update'])->name('cart.update');
Route::get('/cart/increment/{id}/{qty}', [ShoppingCartController::class, 'cart_increment'])->name('cart.increment');
Route::get('/cart/decrement/{id}/{qty}', [ShoppingCartController::class, 'cart_decrement'])->name('cart.decrement');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/cart/proceed', [CheckoutController::class, 'store'])->name('cart.proceed');
Route::get('/cart/payment', [CheckoutController::class, 'show'])->name('cart.payment');
//Route::get('/cart/payment/method/{payment_method}', [CheckoutController::class, 'payment_method'])->name('cart.payment.method');
Route::post('/cart/checkout', [CheckoutController::class, 'pay'])->name('cart.checkout');

// Admin Route group
Route::group(['middleware' => 'auth', 'admin'], function () {
    Route::get('/admin/home', [AdminBaseController::class, 'index'])->name('admin.home');
    Route::get('/admin/discount-books', [AdminBooksController::class, 'discountBooks'])->name('admin.discountBooks');
    Route::get('/admin/trash-books', [AdminBooksController::class, 'trashBooks'])->name('admin.trash-books');

    Route::resource('/admin/books', AdminBooksController::class, [
        'only' => ['index', 'create', 'store', 'update', 'show', 'edit', 'destroy']
    ]);
    Route::get('/admin/books/destroy/{id}', [AdminBooksController::class, 'destroy'])->name('books.destroy');

    Route::resource('/admin/categories', AdminCategoriesController::class, [
        'only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']
    ]);
    Route::resource('/admin/authors', AdminAuthorsController::class, [
        'only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']
    ]);
    Route::resource('/admin/users', AdminUsersController::class, [
        'only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']
    ]);
    Route::resource('/admin/orders', AdminOrdersController::class, [
        'only' => ['index', 'create', 'store', 'show', 'edit', 'destroy']
    ]);
    Route::get('admin/orders/update/{id}', [AdminOrdersController::class, 'update'])->name('orders.update');

    Route::resource('/admin/reviews', AdminReviewsController::class, [
        'only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']
    ]);


});


// End of admin route

// Users route group
Route::group(['middleware' => 'user'], function () {
    Route::get('user/home', [UsersBaseController::class, 'index'])->name('user.home');
    Route::get('/my-orders', [UserOrdersController::class, 'myOrders'])->name('user.orders');
    Route::get('/order/details/{id}', [UserOrdersController::class, 'order_details'])->name('order.details');
    Route::get('/my-reviews', [UserReviewsController::class, 'myReviews'])->name('user.reviews');
    Route::get('/review-delete/{id}', [UserReviewsController::class, 'deleteReview'])->name('review.delete');

});

Route::get('/send-email', [EmailController::class, 'index']);

require __DIR__ . '/auth.php';




