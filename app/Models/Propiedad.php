<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Propiedad
 * 
 * @property int $Id
 * @property int $ComunidadId
 * @property int $TipoPropiedad
 * @property string $Numero
 * @property float $Prorrateo
 * @property string $Descripcion
 * @property int $Enabled
 * 
 * @property Comunidad $comunidad
 * @property TipoPropiedad $tipo_propiedad
 * @property Collection|Compone[] $compones
 * @property Collection|GastoComun[] $gasto_comuns
 * @property Collection|ReservaEspacio[] $reserva_espacios
 *
 * @package App\Models
 */
class Propiedad extends Model
{
	protected $table = 'Propiedad';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'ComunidadId' => 'int',
		'TipoPropiedad' => 'int',
		'Prorrateo' => 'float',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'ComunidadId',
		'TipoPropiedad',
		'Numero',
		'Prorrateo',
		'Descripcion',
		'Enabled'
	];

	public function comunidad()
	{
		return $this->belongsTo(Comunidad::class, 'ComunidadId');
	}

	public function tipo_propiedad()
	{
		return $this->belongsTo(TipoPropiedad::class, 'TipoPropiedad');
	}

	public function compones()
	{
		return $this->hasMany(Compone::class, 'PropiedadId');
	}

	public function gasto_comuns()
	{
		return $this->hasMany(GastoComun::class, 'PropiedadId');
	}

	public function reserva_espacios()
	{
		return $this->hasMany(ReservaEspacio::class, 'PropiedadId');
	}
}
