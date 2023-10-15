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
 * @property int $Enabled
 * @property int $NacionalidadId
 * 
 * @property Nacionalidad $nacionalidad
 * @property Collection|Copropietario[] $copropietarios
 * @property Collection|Residente[] $residentes
 * @property Collection|HojaVida[] $hoja_vidas
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'Persona';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
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
		'Enabled',
		'NacionalidadId'
	];

	public function nacionalidad()
	{
		return $this->belongsTo(Nacionalidad::class, 'NacionalidadId');
	}

	public function copropietarios()
	{
		return $this->hasMany(Copropietario::class, 'PersonaId');
	}

	public function residentes()
	{
		return $this->hasMany(Residente::class, 'PersonaId');
	}

	public function hoja_vidas()
	{
		return $this->hasMany(HojaVida::class, 'PersonaId');
	}
}
