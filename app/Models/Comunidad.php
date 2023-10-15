<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comunidad
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $RUT
 * @property string $Correo
 * @property int $NumeroCuenta
 * @property string $TipoCuenta
 * @property string $Banco
 * @property int $CantPropiedades
 * @property Carbon $FechaRegistro
 * @property int $Enabled
 * @property int $TipoComunidadId
 * 
 * @property TipoComunidad $tipo_comunidad
 * @property Collection|Propiedad[] $propiedads
 * @property Collection|AccesoComunidad[] $acceso_comunidads
 * @property Collection|GastoMe[] $gasto_mes
 *
 * @package App\Models
 */
class Comunidad extends Model
{
	protected $table = 'Comunidad';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'NumeroCuenta' => 'int',
		'CantPropiedades' => 'int',
		'FechaRegistro' => 'datetime',
		'Enabled' => 'int',
		'TipoComunidadId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'RUT',
		'Correo',
		'NumeroCuenta',
		'TipoCuenta',
		'Banco',
		'CantPropiedades',
		'FechaRegistro',
		'Enabled',
		'TipoComunidadId'
	];

	public function tipo_comunidad()
	{
		return $this->belongsTo(TipoComunidad::class, 'TipoComunidadId');
	}

	public function propiedads()
	{
		return $this->hasMany(Propiedad::class, 'ComunidadId');
	}

	public function acceso_comunidads()
	{
		return $this->hasMany(AccesoComunidad::class, 'ComunidadId');
	}

	public function gasto_mes()
	{
		return $this->hasMany(GastoMe::class, 'ComunidadId');
	}
}
