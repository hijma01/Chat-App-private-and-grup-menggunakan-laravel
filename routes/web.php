<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Models\Pesan;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/daftar', [AuthController::class, 'showDaftar']);
Route::post('/daftar', [AuthController::class, 'daftar']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::get('/chat/{userId}/buka', [ChatController::class, 'bukaPercakapan'])->name('chat.buka');
    Route::get('/chat/{percakapanId}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{percakapanId}/kirim', [ChatController::class, 'kirim'])->name('chat.kirim');
    Route::get('/group/create', [chatController::class, 'createGroup']);
    Route::post('/group/store', [chatController::class, 'storeGroup']);
});

Route::get('/chat/{id}/pesan', function ($id) {

    return Pesan::with('user')
        ->where('percakapan_id', $id)
        ->orderBy('created_at', 'asc')
        ->get();
});


Route::post('/chat/{id}/pesan', function (Request $request, $id) {

    $pesan = Pesan::create([
        'percakapan_id' => $id,
        'user_id' => auth()->id(),
        'body' => $request->body
    ]);

    return response()->json($pesan);
});