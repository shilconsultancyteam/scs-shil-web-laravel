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
    // (Your existing user management routes go here...)
    Route::get('/access_control', fn() => view('dashboard.access_control', ['users' => User::all()]))->name('access_control');
    Route::post('/access_control/store', function (Request $request) {
        // ... (validation and user creation logic)
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
        // ... (validation and user update logic)
        $validated = $request->validate(['name' => 'required|string|max:255', 'email' => 'required|string|email|max:255|unique:users,email,'.$user->id, 'password' => 'nullable|string|min:8', 'role' => 'required|in:admin,manager,developer', 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048']);
        if ($request->hasFile('image')) {
            if ($user->image) Storage::disk('public')->delete($user->image);
            $validated['image'] = $request->file('image')->store('users', 'public');
        }
        if ($request->filled('password')) $validated['password'] = Hash::make($request->password);
        $user->update($validated);
        return redirect()->route('access_control')->with('success', 'User updated successfully!');
    })->name('users.update');
    // End User Management

    // Blog Routes
    Route::resource('blogs', AdminBlogController::class)->names('dashboard.blogs');

    // **THIS IS THE CRITICAL FIX**
    // Job Routes
    Route::resource('jobs', JobController::class)->names('dashboard.jobs');
});

// Other Routes
Route::get('/dashboard/unauthorized-access', fn() => view('dashboard.unauthorized'))->name('unauthorized.access')->middleware('auth');
Route::post('/dashboard/blogs/upload', [AdminBlogController::class, 'upload'])->name('dashboard.blogs.upload');

// **THIS IS THE SECOND CRITICAL FIX**
Route::get('/careers', [CareerController::class, 'index'])->name('careers');

Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
Route::view('/terms-of-service', 'terms-of-service')->name('terms.of.service');
Route::view('/cookie-policy', 'cookie-policy')->name('cookie.policy');
Route::post('/send-message', [ContactController::class, 'send'])->name('send.message');

