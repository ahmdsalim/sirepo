<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Str;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = ['nip','nama','jk','telepon','npsn'];

    public function user()
    {
    	return $this->morphOne(User::class, 'userable');
    }

    public function sekolah()
    {
    	return $this->belongsTo(Sekolah::class, 'npsn', 'npsn');
    }
    
    protected function nama(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => Str::title($value),
        );
    }

}
