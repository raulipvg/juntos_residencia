<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Compone
 * 
 * @property int $Id
 * @property int $PropiedadId
 * @property int $PersonaId
 * @property int $RolComponeCoReId
 * @property Carbon $FechaInicio
 * @property Carbon $FechaFin
 * @property int $Enabled
 * 
 * @property Propiedad $propiedad
 * @property Persona $persona
 * @property RolComponeCoRe $rol_compone_co_re
 *
 * @package App\Models
 */
class Compone extends Model
{
	protected $table = 'Compone';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'PropiedadId' => 'int',
		'PersonaId' => 'int',
		'RolComponeCoReId' => 'int',
		'FechaInicio' => 'datetime',
		'FechaFin' => 'datetime',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'PropiedadId',
		'PersonaId',
		'RolComponeCoReId',
		'FechaInicio',
		'FechaFin',
		'Enabled'
	];

	public function propiedad()
	{
		return $this->belongsTo(Propiedad::class, 'PropiedadId');
	}

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'PersonaId');
	}

	public function rol_compone_co_re()
	{
		return $this->belongsTo(RolComponeCoRe::class, 'RolComponeCoReId');
	}
}
