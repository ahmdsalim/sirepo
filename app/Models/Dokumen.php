<?php

namespace App\Models;

use App\Services\HashIdService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bookmark;
use App\Models\Jenis;

class Dokumen extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getHashIdAttribute() {
        return (new HashIdService)->encode($this->id);
    }

    public function getHashJenisIdAttribute() {
        return (new HashIdService)->encode($this->jenis_id);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
