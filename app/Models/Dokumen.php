<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bookmark;
use App\Models\Jenis;

class Dokumen extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bookmarks()
    {
    	return $this->hasMany(Bookmark::class);
    }

    public function jenis()
    {
    	return $this->belongsTo(Jenis::class);
    }
}
