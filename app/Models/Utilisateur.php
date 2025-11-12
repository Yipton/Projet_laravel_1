<?php

namespace App\Models;

use App\Models\Base\Utilisateur as BaseUtilisateur;
use Illuminate\Support\Facades\DB;

class Utilisateur extends BaseUtilisateur
{
	protected $fillable = [
		'nom',
		'prenom',
		'classe',
		'commentaire',
		'code_statut',
		'code_genre',
		'id_college',
		'id_equipe'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id', 'id');
	}

	public static function abonnement($id, $nom, $prenom, $code_statut, $code_genre)
	{
		DB::insert(
			'insert into mcd_utilisateurs (id, nom, prenom, code_statut, code_genre) 
			values (:id, :nom, :prenom, :code_statut, :code_genre)',
			['id' => $id, 'nom' => $nom, 'prenom' => $prenom, 'code_statut' => $code_statut, 'code_genre' => $code_genre]
		);
	}

	public static function existe($id)
	{
		return DB::table('utilisateurs')
			->where('id', $id)
			->exists();
	}

	public static function has_profile($id)
	{
		return self::where('id', $id)->exists();
	}

	public static function afficher_demandes_abo()
	{
		return  DB::select("select mcd_utilisateurs.id, nom, prenom, mcd_users.email from mcd_utilisateurs 
							inner join mcd_users on mcd_users.id = mcd_utilisateurs.id where code_statut='A'");
	}
}
