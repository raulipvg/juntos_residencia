<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Copropietario
 * 
 * @property int $Id
 * @property string $Direccion
 * @property int $Departamento
 * @property int|null $TipoId
 * @property int $PersonaId
 * 
 * @property TipoComite|null $tipo_comite
 * @property Persona $persona
 * @property Collection|Propiedad[] $propiedads
 *
 * @package App\Models
 */
class Copropietario extends Model
{
	protected $table = 'Copropietario';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'Departamento' => 'int',
		'TipoId' => 'int',
		'PersonaId' => 'int'
	];

	protected $fillable = [
		'Direccion',
		'Departamento',
		'TipoId',
		'PersonaId'
	];

	public function tipo_comite()
	{
		return $this->belongsTo(TipoComite::class, 'TipoId');
	}

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'PersonaId');
	}

	public function propiedads()
	{
		return $this->hasMany(Propiedad::class, 'CopropietarioId');
	}
}
