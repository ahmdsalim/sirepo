<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use App\Models\User;

class Koleksi extends Model
{
    use HasFactory;

    protected $fillable = ['email','buku_id'];
    
    public function buku()
    {
    	return $this->belongsTo(Buku::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class,'email','email');
    }

    public function isLikedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
}
