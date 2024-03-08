<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Download extends Model
{
    use HasFactory;

    protected $guard = [];


    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }

    public function scopeOnlySameProdi(Builder $query)
    {
        $user = auth()->user();
        $query->whereHas('dokumen', function ($subquery) use ($user) {
            $subquery->whereHas('user', function ($subsubquery) use ($user) {
                $subsubquery->where('kode_prodi', $user->kode_prodi);
            });
        });
    }
}
