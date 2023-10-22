<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Persona
 * 
 * @property int $Id
 * @property string $RUT
 * @property string $Nombre
 * @property string $Apellido
 * @property string $Sexo
 * @property int $Telefono
 * @property string $Email
 * @property int $Enabled
 * @property int $NacionalidadId
 * 
 * @property Nacionalidad $nacionalidad
 * @property Collection|Compone[] $compones
 * @property Collection|HojaVida[] $hoja_vidas
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'Persona';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'Telefono' => 'int',
		'Enabled' => 'int',
		'NacionalidadId' => 'int'
	];

	protected $fillable = [
		'RUT',
		'Nombre',
		'Apellido',
		'Sexo',
		'Telefono',
		'Email',
		'Enabled',
		'NacionalidadId'
	];

	public function nacionalidad()
	{
		return $this->belongsTo(Nacionalidad::class, 'NacionalidadId');
	}

	public function compones()
	{
		return $this->hasMany(Compone::class, 'PersonaId');
	}

	public function hoja_vidas()
	{
		return $this->hasMany(HojaVida::class, 'PersonaId');
	}
}
