<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Buku;
use App\Models\Baca;
use App\Models\Rating;
use App\Models\Koleksi;
use App\Models\Notifikasi;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'uuid',
        'email',
        'password',
        'userable_id',
        'userable_type',
        'role',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function userable()
    {
        return $this->morphTo();
    }

    public function buku()
    {
        return $this->hasMany(Buku::class, 'email', 'email');
    }

    public function baca()
    {
        return $this->hasMany(Baca::class, 'email', 'email');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'email', 'email');
    }

    public function koleksi()
    {
        return $this->hasMany(Koleksi::class, 'email', 'email');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
    
    protected function nama(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => Str::title($value),
        );
    }

}
