<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use App\Models\User;

class Baca extends Model
{
    use HasFactory;

    protected $fillable = ['email','sesi','buku_id','prev_progress','progress','started_at','end_at'];

    public $timestamps = false;

    public function buku()
    {
    	return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class,'email','email');
    }

    protected static function boot()
	{
	    parent::boot();

	    static::creating(function ($model) {
	        $model->started_at = now();
	        $model->end_at = now();
	    });

	    static::updating(function ($model) {
	        $model->end_at = now();
	    });
	}

}
