<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistorialPago
 * 
 * @property int $Id
 * @property int $NroDoc
 * @property int $TipoPagoId
 * @property Carbon $FechaPago
 * @property int $MontoAPagar
 * @property int $MontoPagado
 * @property int $GastoComunId
 * @property int $EstadoPagoId
 * 
 * @property TipoPago $tipo_pago
 * @property GastoComun $gasto_comun
 * @property EstadoPago $estado_pago
 *
 * @package App\Models
 */
class HistorialPago extends Model
{
	protected $table = 'HistorialPago';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'NroDoc' => 'int',
		'TipoPagoId' => 'int',
		'FechaPago' => 'datetime',
		'MontoAPagar' => 'int',
		'MontoPagado' => 'int',
		'GastoComunId' => 'int',
		'EstadoPagoId' => 'int'
	];

	protected $fillable = [
		'NroDoc',
		'TipoPagoId',
		'FechaPago',
		'MontoAPagar',
		'MontoPagado',
		'GastoComunId',
		'EstadoPagoId'
	];

	public function tipo_pago()
	{
		return $this->belongsTo(TipoPago::class, 'TipoPagoId');
	}

	public function gasto_comun()
	{
		return $this->belongsTo(GastoComun::class, 'GastoComunId');
	}

	public function estado_pago()
	{
		return $this->belongsTo(EstadoPago::class, 'EstadoPagoId');
	}
}
