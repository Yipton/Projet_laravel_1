<?php

namespace App\Models;

use App\Models\Base\Pays as BasePays;

class Pays extends BasePays
{
	protected $fillable = [
		'nom',
		'commentaire'
	];
}
