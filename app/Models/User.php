<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Dokumen;
use App\Models\Bookmark;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'nama',
        'email',
        'password',
        'verifikasi_file',
        'terverifikasi',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public static function boot()
    {
        parent::boot();

        // Memeriksa verifikasi pengguna sebelum login
        static::creating(function ($user) {
            if (!$user->terverifikasi) {
                throw new \Exception('User not verified');
            }
        });
    }

    // Metode untuk memeriksa login
    public function checkLogin($password)
    {
        return Hash::check($password, $this->password);
    }
}
