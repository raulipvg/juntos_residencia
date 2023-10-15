<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReservaEspacio
 * 
 * @property int $Id
 * @property Carbon $FechaSolicitud
 * @property Carbon $FechaUso
 * @property int $Cantidad
 * @property int $Total
 * @property int $TipoCobroId
 * @property int $PropiedadId
 * @property int $EstadoReservaId
 * 
 * @property TipoCobro $tipo_cobro
 * @property Propiedad $propiedad
 * @property EstadoReserva $estado_reserva
 *
 * @package App\Models
 */
class ReservaEspacio extends Model
{
	protected $table = 'ReservaEspacio';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'FechaSolicitud' => 'datetime',
		'FechaUso' => 'datetime',
		'Cantidad' => 'int',
		'Total' => 'int',
		'TipoCobroId' => 'int',
		'PropiedadId' => 'int',
		'EstadoReservaId' => 'int'
	];

	protected $fillable = [
		'FechaSolicitud',
		'FechaUso',
		'Cantidad',
		'Total',
		'TipoCobroId',
		'PropiedadId',
		'EstadoReservaId'
	];

	public function tipo_cobro()
	{
		return $this->belongsTo(TipoCobro::class, 'TipoCobroId');
	}

	public function propiedad()
	{
		return $this->belongsTo(Propiedad::class, 'PropiedadId');
	}

	public function estado_reserva()
	{
		return $this->belongsTo(EstadoReserva::class, 'EstadoReservaId');
	}
}
