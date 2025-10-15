<?php

namespace App\Models;

use App\Models\Base\Scorer as BaseScorer;

class Scorer extends BaseScorer
{
	protected $hidden = [
		'id_secretaire'
	];

	protected $fillable = [
		'score',
		'commentaire'
	];
}
