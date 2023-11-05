<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GastoComun
 * 
 * @property int $Id
 * @property int $PropiedadId
 * @property int $CobroGC
 * @property int $FondoReserva
 * @property int $TotalGC
 * @property int $TotalCobroMes
 * @property Carbon $Fecha
 * @property int $SaldoMesAnterior
 * @property int $GastoMesId
 * @property int $EstadoGastoId
 * 
 * @property Propiedad $propiedad
 * @property GastoMe $gasto_me
 * @property EstadoGastoComun $estado_gasto_comun
 * @property Collection|CobroIndividual[] $cobro_individuals
 * @property Collection|ReservaEspacio[] $reserva_espacios
 * @property Collection|HistorialPago[] $historial_pagos
 *
 * @package App\Models
 */
class GastoComun extends Model
{
	protected $table = 'GastoComun';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'PropiedadId' => 'int',
		'CobroGC' => 'int',
		'FondoReserva' => 'int',
		'TotalGC' => 'int',
		'TotalCobroMes' => 'int',
		'Fecha' => 'datetime',
		'SaldoMesAnterior' => 'int',
		'GastoMesId' => 'int',
		'EstadoGastoId' => 'int'
	];

	protected $fillable = [
		'PropiedadId',
		'CobroGC',
		'FondoReserva',
		'TotalGC',
		'TotalCobroMes',
		'Fecha',
		'SaldoMesAnterior',
		'GastoMesId',
		'EstadoGastoId'
	];

	public function propiedad()
	{
		return $this->belongsTo(Propiedad::class, 'PropiedadId');
	}

	public function gasto_me()
	{
		return $this->belongsTo(GastoMe::class, 'GastoMesId');
	}

	public function estado_gasto_comun()
	{
		return $this->belongsTo(EstadoGastoComun::class, 'EstadoGastoId');
	}

	public function cobro_individuals()
	{
		return $this->hasMany(CobroIndividual::class, 'GastoComunId');
	}

	public function reserva_espacios()
	{
		return $this->hasMany(ReservaEspacio::class, 'GastoComunId');
	}

	public function historial_pagos()
	{
		return $this->hasMany(HistorialPago::class, 'GastoComunId');
	}
}
