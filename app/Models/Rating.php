<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use App\Models\User;

class Rating extends Model
{
    use HasFactory;

    public function buku()
    {
    	return $this->belongsTo(Buku::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class,'email','email');
    }

}
