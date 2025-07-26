<?php

namespace App\Models;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prodi extends Model
{
    use HasFactory;

    protected $primaryKey = 'kode_prodi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id'];

    protected $fillable = ['kode_prodi', 'nama_prodi'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    protected function kodeProdi(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value,
            set: fn (?string $value) => strtoupper($value),
        );
    }
}
