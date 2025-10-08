<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\CommentController;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public-Facing Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [PublicBlogController::class, 'index'])->name('public.blogs.index');
Route::get('/blog/category/{slug}', [PublicBlogController::class, 'category'])->name('public.blogs.category');
Route::get('/articles/{blog:slug}', [PublicBlogController::class, 'show'])->name('public.blogs.show');
Route::post('/articles/{blog:slug}/comment', [PublicBlogController::class, 'storeComment'])->name('public.blogs.comment');
Route::post('/articles/{blog:slug}/comments', [CommentController::class, 'store'])->name('comments.store');

// About Us, Services, Auth Routes
Route::prefix('about-us')->group(fn() => [
    Route::get('/', [AboutUsController::class, 'index'])->name('aboutUs.index'),
    Route::get('/team-member', [AboutUsController::class, 'teamMember'])->name('aboutUs.team-member')
]);
Route::prefix('services')->group(fn() => [
    Route::get('/web-development', [ServiceController::class, 'webDevelopment'])->name('services.web'),
    Route::get('/ecommerce-development', [ServiceController::class, 'ecommerceDevelopment'])->name('services.ecommerce'),
    Route::get('/social-media-marketing', [ServiceController::class, 'socialMediaMarketing'])->name('services.smm'),
    Route::get('/content-creation', [ServiceController::class, 'contentCreation'])->name('services.content'),
    Route::get('/brand-strategy', [ServiceController::class, 'brandStrategy'])->name('services.brand'),
    Route::get('/seo-analysis', [ServiceController::class, 'seoAnalysis'])->name('services.seo')
]);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Access Control & User Management
    Route::get('/access_control', fn() => view('dashboard.access_control', ['users' => User::all()]))->name('access_control');
    Route::post('/access_control/store', function (Request $request) {
        $request->validate(['name' => 'required|string|max:255', 'email' => 'required|string|email|max:255|unique:users', 'password' => 'required|string|min:8', 'role' => 'required|in:admin,manager,developer', 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048']);
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('users', 'public') : null;
        User::create($request->only('name', 'email', 'role') + ['password' => Hash::make($request->password), 'image' => $imagePath]);
        return redirect()->route('access_control')->with('success', 'User added successfully!');
    })->name('access_control.store');
    Route::get('/users/{user}/edit', fn(User $user) => view('dashboard.user_edit', compact('user')))->name('users.edit');
    Route::delete('/users/{user}', function (User $user) {
        if ($user->image) Storage::disk('public')->delete($user->image);
        $user->delete();
        return redirect()->route('access_control')->with('success', 'User deleted successfully!');
    })->name('users.destroy');
    Route::put('/users/{user}', function (Request $request, User $user) {
        $validated = $request->validate(['name' => 'required|string|max:255', 'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, 'password' => 'nullable|string|min:8', 'role' => 'required|in:admin,manager,developer', 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048']);
        if ($request->hasFile('image')) {
            if ($user->image) Storage::disk('public')->delete($user->image);
            $validated['image'] = $request->file('image')->store('users', 'public');
        }
        if ($request->filled('password')) $validated['password'] = Hash::make($request->password);
        $user->update($validated);
        return redirect()->route('access_control')->with('success', 'User updated successfully!');
    })->name('users.update');

    // Blog Routes
    Route::resource('blogs', AdminBlogController::class)->names('dashboard.blogs');
    Route::post('/blogs/upload', [AdminBlogController::class, 'upload'])->name('dashboard.blogs.upload');

    // Job Routes
    Route::resource('jobs', JobController::class)->names('dashboard.jobs');

    // Job Applicants Routes
    Route::get('/applicants', [CareerController::class, 'showApplicants'])->name('dashboard.applicants');
});

// Other Public-Facing Routes
Route::get('/dashboard/unauthorized-access', fn() => view('dashboard.unauthorized'))->name('unauthorized.access')->middleware('auth');
Route::post('/send-message', [ContactController::class, 'send'])->name('send.message');

// Career Routes
Route::prefix('careers')->group(function () {
    Route::get('/', [CareerController::class, 'index'])->name('careers');
    Route::get('/{job_id}/apply', [CareerController::class, 'showApplicationForm'])->name('careers.apply');
    Route::get('/jobs/{job_id}', [CareerController::class, 'showJobDescription'])->name('careers.show.job');
    Route::post('/submit', [CareerController::class, 'submitApplication'])->name('careers.submit');
});

// Policies
Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
Route::view('/terms-of-service', 'terms-of-service')->name('terms.of.service');
Route::view('/cookie-policy', 'cookie-policy')->name('cookie.policy');

//logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::post('/jobs/upload', [App\Http\Controllers\Admin\JobController::class, 'upload'])->name('dashboard.jobs.upload');
// Password Reset Routes
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
//dashboard pages section

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/pages/popular_pages', [AnalyticsController::class, 'popularPages'])
        ->name('analytics.popular');

    Route::get('/pages/live-stats', [AnalyticsController::class, 'liveStats'])
        ->name('analytics.live-stats');

    Route::get('/pages/top-referrals', [AnalyticsController::class, 'topReferrals'])
        ->name('analytics.top-referrals');
});

// Existing Blog Routes
Route::resource('blogs', AdminBlogController::class)->names('dashboard.blogs');
Route::post('/blogs/upload', [AdminBlogController::class, 'upload'])->name('dashboard.blogs.upload');


// NEW: Comment Routes (View Comments & Delete Comments)
Route::controller(AdminCommentController::class)->prefix('comments')->name('dashboard.comments.')->group(function () {
    Route::get('/', 'index')->name('index');
    // Uses route model binding: /dashboard/comments/{blog_comment_id}
    Route::delete('/{comment}', 'destroy')->name('destroy');
});

// ✅ FIX: Replaced manual route group with Route::resource to define edit, update, and destroy routes.
Route::resource('categories', CategoryController::class)->names('dashboard.categories')->except(['create', 'show']);


// SEO Routes
Route::prefix('dashboard/seo')->name('dashboard.seo.')->group(function () {
    Route::get('/meta-tags', [SeoController::class, 'metaTags'])->name('meta-tags');
    Route::post('/meta-tags', [SeoController::class, 'updateMetaTags'])->name('meta-tags.update');
    
    Route::get('/analytics', [SeoController::class, 'analytics'])->name('analytics');
    Route::post('/analytics', [SeoController::class, 'updateAnalytics'])->name('analytics.update');
    
    Route::get('/keywords', [SeoController::class, 'keywords'])->name('keywords');
    Route::post('/keywords', [SeoController::class, 'updateKeywords'])->name('keywords.update');
    
    Route::get('/sitemap', [SeoController::class, 'sitemap'])->name('sitemap');
    Route::post('/sitemap/generate', [SeoController::class, 'generateSitemap'])->name('sitemap.generate');
    
    Route::get('/robots', [SeoController::class, 'robots'])->name('robots');
    Route::post('/robots', [SeoController::class, 'updateRobots'])->name('robots.update');
});