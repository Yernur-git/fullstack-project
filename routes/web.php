<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LocalizationController;
use App\Models\CreatorFile;
use App\Models\Role;
use App\Models\UploadedFile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $totalFiles = CreatorFile::count();
    $recentFiles = CreatorFile::latest()->take(3)->get();
    $totalStorage = CreatorFile::sum('file_size');

    return view('pages.home', compact('totalFiles', 'recentFiles', 'totalStorage'));
})->name('home');

Route::get('/login-register', [AuthController::class, 'show'])->name('midterm');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/library', function () {
    $files = CreatorFile::latest()->get();
    $types = CreatorFile::select('file_type')
        ->whereNotNull('file_type')
        ->distinct()
        ->pluck('file_type');

    return view('pages.library', compact('files', 'types'));
})->name('library');

Route::get('/details/{file}', function (CreatorFile $file) {
    return view('pages.details', compact('file'));
})->name('details');

Route::get('/download/{file}', function (CreatorFile $file) {
    if (!in_array(session('user_role'), ['admin', 'premium'])) {
        return redirect()->route('details', $file)->with('error', __('Downloads are available for premium users and admins.'));
    }

    if (!$file->file_path || !Storage::disk('public')->exists($file->file_path)) {
        return redirect()->route('details', $file)->with('error', __('The file is not available on storage.'));
    }

    $file->increment('download_count');

    return response()->download(
        storage_path('app/public/' . $file->file_path),
        $file->original_filename ?? $file->name
    );
})->name('download');

Route::get('/profile', function () {
    if (!session('logged_in')) {
        return redirect()->route('midterm')->with('error', __('Please log in to view your profile.'));
    }

    $files = UploadedFile::where('user_id', session('user_id'))->latest()->get();
    $totalStorage = $files->sum('file_size');
    $users = session('user_role') === 'admin' ? User::with('role')->orderBy('name')->get() : collect();
    $roles = session('user_role') === 'admin' ? Role::orderBy('name')->get() : collect();

    return view('pages.profile', compact('files', 'totalStorage', 'users', 'roles'));
})->name('profile');

Route::get('/upload', [UploadFileController::class, 'show'])->name('file.upload.show');
Route::post('/upload', [UploadFileController::class, 'upload'])->name('file.upload');
Route::delete('/upload/{id}', [UploadFileController::class, 'delete'])->name('file.delete');

Route::get('/admin/users', function () {
    if (session('user_role') !== 'admin') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    return User::with('role')->get()->map(fn($u) => [
        'id' => $u->id,
        'name' => $u->name,
        'email' => $u->email,
        'role' => $u->role?->name ?? 'none',
    ]);
})->name('admin.users');

Route::post('/admin/change-role', [AuthController::class, 'changeRole'])->name('admin.changeRole');

Route::get('/send-email', [MailController::class, 'send'])->name('mail.send');
Route::get('/lang/{locale}', [LocalizationController::class, 'switch'])->name('lang.switch');
