<?php

namespace App\Models;

use App\Models\Base\Concours as BaseConcours;

class Concours extends BaseConcours
{
	protected $fillable = [
		'nom',
		'date_debut',
		'date_fin',
		'actif',
		'en_cours',
		'equipe_min',
		'equipe_max',
		'commentaire'
	];
}
