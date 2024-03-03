<?php

namespace App\Models;

use App\Models\Jenis;
use App\Models\Bookmark;
use App\Services\HashIdService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumen extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getHashIdAttribute()
    {
        return (new HashIdService)->encode($this->id);
    }

    public function getHashJenisIdAttribute()
    {
        return (new HashIdService)->encode($this->jenis_id);
    }

    protected function file(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value !== null ? json_decode($value) : null,
            set: fn (?string $value) => $value !== null ? $value : null,
        );
    }
    

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function scopeOnlyLogged(Builder $query)
    {
        $query->where('username', auth()->user()->username);
    }

    public function collectedBy(User $user)
    {
        return $this->bookmarks->contains('username', $user->username);
    }
}
