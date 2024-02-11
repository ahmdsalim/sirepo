<?php

namespace App\Services;

use Vinkla\Hashids\Facades\Hashids;

class HashIdService
{

	public function encode($id)
	{
		return Hashids::encode($id);
	}

	public function decode($hashId)
	{
		if(is_int($hashId))
			return $hashId;
		return Hashids::decode($hashId)[0];
	}
}