<?php

namespace App\Models;

use App\Models\Dokumen;
use App\Services\HashIdService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;

class Jenis extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getHashIdAttribute()
    {
        return (new HashIdService())->encode($this->id);
    }
    
    public function dokumens()
    {
    	return $this->hasMany(Dokumen::class);
    }

}
