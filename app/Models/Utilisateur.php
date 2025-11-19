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

	public static function update_statut($id, $statut)
	{
		DB::update("update mcd_utilisateurs set code_statut = :statut where id = :id", ["statut" => $statut, "id" => $id]);
	}
	public static function update_role($id)
	{
		$concours =  DB::select("select id from mcd_concours where en_cours=1");
		$id_concours = $concours[0]->id;
		DB::insert(
			"insert into mcd_engager (id_utilisateur, id_concours, id_role)
		 values (:id_utilisateur, :id_concours, :id_role)",
			["id_utilisateur" => $id, "id_concours" => $id_concours, "id_role" => 10]
		);
	}
	public static function delete_utilisateur($id)
	{
		DB::delete("delete from mcd_utilisateurs  where id = :id", ["id" => $id]);
	}
}
