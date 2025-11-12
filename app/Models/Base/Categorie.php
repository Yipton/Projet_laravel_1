<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Classer;
use App\Models\Concours;
use App\Models\Epreuve;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Categorie
 * 
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property string|null $commentaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id_concours
 * 
 * @property Concours $concours
 * @property Collection|Classer[] $classers
 * @property Collection|Epreuve[] $epreuves
 *
 * @package App\Models\Base
 */
class Categorie extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'id_concours' => 'int'
	];

	public function concours()
	{
		return $this->belongsTo(Concours::class, 'id_concours');
	}

	public function classers()
	{
		return $this->hasMany(Classer::class, 'id_categorie');
	}

	public function epreuves()
	{
		return $this->hasMany(Epreuve::class, 'id_categorie');
	}
}
