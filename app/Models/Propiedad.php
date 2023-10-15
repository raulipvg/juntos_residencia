<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Propiedad
 * 
 * @property int $Id
 * @property int $CopropietarioId
 * @property int $ComunidadId
 * @property int $TipoPropiedad
 * @property int $Numero
 * @property float $Prorrateo
 * @property string $Descripcion
 * @property Carbon $FechaContrato
 * @property Carbon $FechaTermino
 * @property int $Enabled
 * 
 * @property Copropietario $copropietario
 * @property Comunidad $comunidad
 * @property TipoPropiedad $tipo_propiedad
 * @property Collection|GastoComun[] $gasto_comuns
 * @property Collection|ReservaEspacio[] $reserva_espacios
 * @property Collection|Residente[] $residentes
 *
 * @package App\Models
 */
class Propiedad extends Model
{
	protected $table = 'Propiedad';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'CopropietarioId' => 'int',
		'ComunidadId' => 'int',
		'TipoPropiedad' => 'int',
		'Numero' => 'int',
		'Prorrateo' => 'float',
		'FechaContrato' => 'datetime',
		'FechaTermino' => 'datetime',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'CopropietarioId',
		'ComunidadId',
		'TipoPropiedad',
		'Numero',
		'Prorrateo',
		'Descripcion',
		'FechaContrato',
		'FechaTermino',
		'Enabled'
	];

	public function copropietario()
	{
		return $this->belongsTo(Copropietario::class, 'CopropietarioId');
	}

	public function comunidad()
	{
		return $this->belongsTo(Comunidad::class, 'ComunidadId');
	}

	public function tipo_propiedad()
	{
		return $this->belongsTo(TipoPropiedad::class, 'TipoPropiedad');
	}

	public function gasto_comuns()
	{
		return $this->hasMany(GastoComun::class, 'PropiedadId');
	}

	public function reserva_espacios()
	{
		return $this->hasMany(ReservaEspacio::class, 'PropiedadId');
	}

	public function residentes()
	{
		return $this->hasMany(Residente::class, 'PropiedadId');
	}
}
