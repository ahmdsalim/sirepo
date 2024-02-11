<?php

namespace App\Models;

use App\Casts\HashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Dokumen;

class Bookmark extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
    	'id' => HashId::class
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function dokumen()
    {
    	return $this->belongsTo(Dokumen::class);
    }
}
