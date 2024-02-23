<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $guard = [];


    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }
}
