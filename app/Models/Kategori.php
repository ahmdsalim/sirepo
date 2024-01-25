<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Kategori extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function buku()
    {
    	return $this->hasMany(Buku::class);
    }
    
    protected function kategori(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => Str::title($value),
        );
    }
}
