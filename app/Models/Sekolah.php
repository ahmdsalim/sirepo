<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = ['npsn','nama','jenjang','alamat','provinsi','kota','kecamatan','kelurahan','telepon'];

    public function user()
    {
    	return $this->morphOne(User::class, 'userable');
    }

    public function siswa()
    {
    	return $this->hasMany(Siswa::class,'npsn','npsn');
    }

    public function guru()
    {
    	return $this->hasMany(Guru::class,'npsn','npsn');
    }

}
