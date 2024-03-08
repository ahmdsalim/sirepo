<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'npm';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id'];

    protected $fillable = [
        'npm',
        'nama_mahasiswa',
        'email',
        'kode_prodi',
        'is_active',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'npm', 'npm');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function scopeOnlySameProdi(Builder $query)
    {
        $query->where('kode_prodi', auth()->user()->kode_prodi);
    }
}
