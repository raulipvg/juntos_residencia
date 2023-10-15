<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoComite
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|Copropietario[] $copropietarios
 *
 * @package App\Models
 */
class TipoComite extends Model
{
	protected $table = 'TipoComite';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function copropietarios()
	{
		return $this->hasMany(Copropietario::class, 'TipoId');
	}
}
