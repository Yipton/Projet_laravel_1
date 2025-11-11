<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Categorie;
use App\Models\Equipe;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Classer
 * 
 * @property int $id_equipe
 * @property int $id_categorie
 * @property float $score_total
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Equipe $equipe
 * @property Categorie $categorie
 *
 * @package App\Models\Base
 */
class Classer extends Model
{
	protected $table = 'mcd_classer';
	public $incrementing = false;

	protected $casts = [
		'id_equipe' => 'int',
		'id_categorie' => 'int',
		'score_total' => 'float'
	];

	public function equipe()
	{
		return $this->belongsTo(Equipe::class, 'id_equipe');
	}

	public function categorie()
	{
		return $this->belongsTo(Categorie::class, 'id_categorie');
	}
}
