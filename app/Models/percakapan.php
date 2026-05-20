<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pesan;
use App\Models\Anggota;
use App\Models\User;

class Percakapan extends Model
{
    protected $fillable = [
        'type',
        'name',
        'created_by'
    ];

    public function pesan()
    {
        return $this->hasMany(Pesan::class, 'percakapan_id');
    }

    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'percakapan_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'anggotas',
            'percakapan_id',
            'user_id'
        );
    }
}