<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactEnquiryController as AdminContactEnquiryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistributorApplicationController as AdminDistributorApplicationController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\IngredientController as AdminIngredientController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RedirectController as AdminRedirectController;
use App\Http\Controllers\Admin\SeoController as AdminSeoController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [PageController::class, 'about'])->name('about');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{category}', [ProductController::class, 'category'])->name('products.category');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
Route::get('/ingredients/{slug}', [IngredientController::class, 'show'])->name('ingredients.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/become-a-distributor', [DistributorController::class, 'index'])->name('distributor');
Route::post('/become-a-distributor', [DistributorController::class, 'store'])->name('distributor.store');

Route::get('/agent-locator', [PageController::class, 'agentLocator'])->name('agent.locator');
Route::get('/agent-portal', [PageController::class, 'agentPortal'])->name('agent.portal');

Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');

Route::get('/search', [PageController::class, 'search'])->name('search');

Route::get('/privacy-policy', fn() => app(PageController::class)->policy('privacy-policy'))->name('policy.privacy');
Route::get('/terms-and-conditions', fn() => app(PageController::class)->policy('terms-and-conditions'))->name('policy.terms');
Route::get('/return-policy', fn() => app(PageController::class)->policy('return-policy'))->name('policy.returns');
Route::get('/shipping-policy', fn() => app(PageController::class)->policy('shipping-policy'))->name('policy.shipping');

// SEO Dynamic Endpoints
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');

Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes (/admin)
|--------------------------------------------------------------------------
*/
Route::get('/admin/reset-password/{token}', [AdminAuthController::class, 'showResetPassword'])->name('password.reset');

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth Routes
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:6,1')->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Forgot & Reset Password Routes
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLinkEmail'])->middleware('throttle:6,1')->name('password.email');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->middleware('throttle:6,1')->name('password.update');

    Route::middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [AdminAuthController::class, 'profile'])->name('profile');
        Route::post('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');

        // Content Management: Super Admin, Admin, Content Manager
        Route::middleware(['role:super-admin,admin,content-manager'])->group(function () {
            Route::resource('products', AdminProductController::class);
            Route::post('/products/{product}/duplicate', [AdminProductController::class, 'duplicate'])->name('products.duplicate');
            Route::resource('categories', AdminCategoryController::class)->except(['create', 'show', 'edit']);
            Route::resource('ingredients', AdminIngredientController::class)->except(['create', 'show', 'edit']);
            Route::resource('blog', AdminBlogPostController::class);
            Route::resource('faqs', AdminFaqController::class)->except(['create', 'show', 'edit']);
            Route::resource('testimonials', AdminTestimonialController::class)->except(['create', 'show', 'edit']);
            Route::resource('agents', AdminAgentController::class)->except(['create', 'show', 'edit']);
        });

        // Enquiries & Applications: Super Admin, Admin, Enquiry Manager
        Route::middleware(['role:super-admin,admin,enquiry-manager'])->group(function () {
            Route::get('/distributors', [AdminDistributorApplicationController::class, 'index'])->name('distributors.index');
            Route::get('/distributors/{distributor}', [AdminDistributorApplicationController::class, 'show'])->name('distributors.show');
            Route::post('/distributors/{distributor}/status', [AdminDistributorApplicationController::class, 'updateStatus'])->name('distributors.updateStatus');
            Route::delete('/distributors/{distributor}', [AdminDistributorApplicationController::class, 'destroy'])->name('distributors.destroy');
            Route::get('/distributors-export', [AdminDistributorApplicationController::class, 'exportCsv'])->name('distributors.export');

            Route::get('/enquiries', [AdminContactEnquiryController::class, 'index'])->name('enquiries.index');
            Route::get('/enquiries/{enquiry}', [AdminContactEnquiryController::class, 'show'])->name('enquiries.show');
            Route::post('/enquiries/{enquiry}/status', [AdminContactEnquiryController::class, 'updateStatus'])->name('enquiries.updateStatus');
            Route::delete('/enquiries/{enquiry}', [AdminContactEnquiryController::class, 'destroy'])->name('enquiries.destroy');

            Route::get('/subscribers', [AdminNewsletterController::class, 'index'])->name('subscribers.index');
            Route::delete('/subscribers/{subscriber}', [AdminNewsletterController::class, 'destroy'])->name('subscribers.destroy');
            Route::get('/subscribers-export', [AdminNewsletterController::class, 'exportCsv'])->name('subscribers.export');
        });

        // SEO & Media: Super Admin, Admin, SEO Manager
        Route::middleware(['role:super-admin,admin,seo-manager'])->group(function () {
            Route::resource('seo', AdminSeoController::class)->except(['create', 'show', 'edit']);
            Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
            Route::post('/media/upload', [AdminMediaController::class, 'upload'])->name('media.upload');
            Route::delete('/media/{media}', [AdminMediaController::class, 'destroy'])->name('media.destroy');
            Route::resource('redirects', AdminRedirectController::class)->only(['index', 'store', 'destroy']);
        });

        // System Settings & Users: Super Admin Only
        Route::middleware(['role:super-admin'])->group(function () {
            Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
            Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
            Route::resource('users', AdminUserController::class)->except(['show']);
        });
    });
});
