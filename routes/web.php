<?php
 
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
 
Route::get('/', function () {   //ฟังก์ชันนี้กำหนดเส้นทาง (route) HTTP GET สำหรับ URL / (หน้าหลัก)
    //เมื่อผู้ใช้เข้าถึง URL / ฟังก์ชันนิรนาม (anonymous function) จะถูกเรียกใช้งาน
    
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),//ตรวจสอบว่ามีเส้นทาง (route) ที่ชื่อ 'login' อยู่หรือไม่
        'canRegister' => Route::has('register'),//ตรวจสอบว่ามีเส้นทาง (route) ที่ชื่อ 'register' อยู่หรือไม่
        'laravelVersion' => Application::VERSION,//นำเวอร์ชันของ Laravel ที่ใช้อยู่ในโปรเจกต์มาส่งไปให้หน้า
        'phpVersion' => PHP_VERSION,//นำเวอร์ชันของ PHP ที่กำลังทำงานในเซิร์ฟเวอร์มาส่งไปให้หน้า
    ]);
});
 
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');//เรนเดอร์หน้า
})->middleware(['auth', 'verified'])->name('dashboard');//ตรวจสอบว่าผู้ใช้ได้เข้าสู่ระบบหรือไม่ หากยังไม่ได้เข้าสู่ระบบ ระบบจะเปลี่ยนเส้นทางไป
 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
 
Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy']) 
    ->middleware(['auth', 'verified']);
 
require __DIR__.'/auth.php';
