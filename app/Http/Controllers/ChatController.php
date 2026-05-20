<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Percakapan;
use App\Models\Pesan;
use App\Models\Anggota;
use App\Models\User;

class ChatController extends Controller
{
    public function bukaPercakapan($userId)
{
    $authId = auth()->id();

    $percakapan = Percakapan::whereHas('anggota', function ($q) use ($authId) {

        $q->where('user_id', $authId);

    })->whereHas('anggota', function ($q) use ($userId) {

        $q->where('user_id', $userId);

    })->first();

    if (!$percakapan)
    {
        $percakapan = Percakapan::create([
            'type' => 'private',
            'created_by' => $authId
        ]);

        Anggota::create([
            'percakapan_id' => $percakapan->id,
            'user_id' => $authId
        ]);

        Anggota::create([
            'percakapan_id' => $percakapan->id,
            'user_id' => $userId
        ]);
    }

    return response()->json([
        'percakapan_id' => $percakapan->id
    ]);
}

    public function show($percakapanId)
{
    $percakapan = Percakapan::with([
        'pesan.user',
        'anggota.user'
    ])->findOrFail($percakapanId);

    $pesanList = $percakapan->pesan()
        ->with('user')
        ->orderBy('created_at')
        ->get();

    $lawanBicara = $percakapan->anggota
        ->firstWhere('user_id', '!=', auth()->id())?->user;

    $users = User::where('id', '!=', auth()->id())->get();


    // TAMBAHAN UNTUK GROUP
    $groups = Percakapan::where('type', 'group')
        ->whereHas('anggota', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->get();


    return view(
        'dashboard',
        compact(
            'percakapan',
            'pesanList',
            'lawanBicara',
            'users',
            'groups'
        )
    );
}

    public function kirim(Request $request, $percakapanId)
    {
        $request->validate(['body' => 'required|string']);

        $pesan = Pesan::create([
            'percakapan_id' => $percakapanId,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return response()->json([
            'status' => 'ok',
            'pesan' => [
                'id' => $pesan->id,
                'body' => $pesan->body,
                'user_id' => $pesan->user_id,
                'created_at' => $pesan->created_at->format('H:i'),
            ]
        ]);
    }
    public function createGroup()
{
    $users = User::where('id', '!=', auth()->id())->get();

    return view('group', compact('users'));
}

public function storeGroup(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'members' => 'required|array'
    ]);

    // buat percakapan grup
    $percakapan = Percakapan::create([
        'name' => $request->name,
        'type' => 'group',
        'created_by' => auth()->id()
    ]);

    // masukkan pembuat grup
    Anggota::create([
        'percakapan_id' => $percakapan->id,
        'user_id' => auth()->id()
    ]);

    // masukkan anggota lain
    foreach ($request->members as $memberId)
    {
        Anggota::create([
            'percakapan_id' => $percakapan->id,
            'user_id' => $memberId
        ]);
    }

    return redirect('/chat/' . $percakapan->id);
}
}