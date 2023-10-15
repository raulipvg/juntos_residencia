<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GastoMe
 * 
 * @property int $Id
 * @property Carbon $Fecha
 * @property int $TotalRemuneracion
 * @property int $TotasOtros
 * @property int $TotalAdm
 * @property int $TotalConsumo
 * @property int $TotalMantencion
 * @property int $TotalReparacion
 * @property int $TotalMes
 * @property float $PorcentajeFondo
 * @property int $FondoReserva
 * @property int $Total
 * @property int $EstadoId
 * @property int $ComunidadId
 * 
 * @property EstadoGastoMe $estado_gasto_me
 * @property Comunidad $comunidad
 * @property Collection|GastoComun[] $gasto_comuns
 * @property Collection|GastosDetalle[] $gastos_detalles
 *
 * @package App\Models
 */
class GastoMe extends Model
{
	protected $table = 'GastoMes';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'Fecha' => 'datetime',
		'TotalRemuneracion' => 'int',
		'TotasOtros' => 'int',
		'TotalAdm' => 'int',
		'TotalConsumo' => 'int',
		'TotalMantencion' => 'int',
		'TotalReparacion' => 'int',
		'TotalMes' => 'int',
		'PorcentajeFondo' => 'float',
		'FondoReserva' => 'int',
		'Total' => 'int',
		'EstadoId' => 'int',
		'ComunidadId' => 'int'
	];

	protected $fillable = [
		'Fecha',
		'TotalRemuneracion',
		'TotasOtros',
		'TotalAdm',
		'TotalConsumo',
		'TotalMantencion',
		'TotalReparacion',
		'TotalMes',
		'PorcentajeFondo',
		'FondoReserva',
		'Total',
		'EstadoId',
		'ComunidadId'
	];

	public function estado_gasto_me()
	{
		return $this->belongsTo(EstadoGastoMe::class, 'EstadoId');
	}

	public function comunidad()
	{
		return $this->belongsTo(Comunidad::class, 'ComunidadId');
	}

	public function gasto_comuns()
	{
		return $this->hasMany(GastoComun::class, 'GastoMesId');
	}

	public function gastos_detalles()
	{
		return $this->hasMany(GastosDetalle::class, 'GastoMesId');
	}
}
