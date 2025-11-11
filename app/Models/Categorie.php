<?php

namespace App\Models;

use App\Models\Base\Categorie as BaseCategorie;

class Categorie extends BaseCategorie
{
	protected $fillable = [
		'code',
		'nom',
		'commentaire',
		'id_concours'
	];
}
