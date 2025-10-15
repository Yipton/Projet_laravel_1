<?php

namespace App\Models;

use App\Models\Base\Category as BaseCategory;

class Category extends BaseCategory
{
	protected $fillable = [
		'code',
		'nom',
		'commentaire',
		'id_concours'
	];
}
