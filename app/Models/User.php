<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Prodi;
use App\Models\Dokumen;
use App\Models\Bookmark;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\UserModerationApproved;
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
        'npm',
        'prodi_id',
        'nama',
        'email',
        'password',
        'is_active',
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

    public function sendModerationApprovedNotification()
    {
        $this->notifyNow(new UserModerationApproved($this));
    }

    public function getHashUsernameAttribute()
    {
        return encryptString($this->username);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'npm', 'npm');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function scopeToapprove(Builder $query)
    {
        $query->where('is_active', 0);
    }

    public function scopeApproved(Builder $query)
    {
        $query->where('is_active', 1);
    }

    public function scopeExceptlogged(Builder $query)
    {
        $query->where('username', '!=', auth()->user()->username);
    }

    public function scopeOnlyuser(Builder $query)
    {
        $query->where('role', 'user');
    }

    public function scopeOnlyadmin(Builder $query)
    {
        $query->where('role', 'admin');
    }
}
