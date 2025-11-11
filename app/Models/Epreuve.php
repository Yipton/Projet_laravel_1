<?php

namespace App\Models;

use App\Models\Base\Epreuve as BaseEpreuve;

class Epreuve extends BaseEpreuve
{
	protected $fillable = [
		'code',
		'nom',
		'score_max',
		'coefficient',
		'commentaire',
		'id_concours',
		'id_categorie'
	];
}
