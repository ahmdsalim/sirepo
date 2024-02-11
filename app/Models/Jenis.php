<?php

namespace App\Models;

use App\Casts\HashId;
use App\Models\Dokumen;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenis extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
    	'id' => HashId::class
    ];

    public function dokumens()
    {
    	return $this->hasMany(Dokumen::class);
    }

    protected function namaJenis(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => Str::title($value),
        );
    }
}
