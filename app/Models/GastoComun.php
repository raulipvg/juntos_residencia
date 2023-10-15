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
 * @property int $CobroGC
 * @property int $FondoReserva
 * @property int $TotalGC
 * @property int $TotalCobroMes
 * @property Carbon $Fecha
 * @property int $SaldoMesAnterior
 * @property int $EstadoGastoId
 * @property int $PropiedadId
 * @property int $GastoMesId
 * 
 * @property EstadoGasto $estado_gasto
 * @property Propiedad $propiedad
 * @property GastoMe $gasto_me
 * @property Collection|HistorialPago[] $historial_pagos
 * @property Collection|CobroIndividual[] $cobro_individuals
 *
 * @package App\Models
 */
class GastoComun extends Model
{
	protected $table = 'GastoComun';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'CobroGC' => 'int',
		'FondoReserva' => 'int',
		'TotalGC' => 'int',
		'TotalCobroMes' => 'int',
		'Fecha' => 'datetime',
		'SaldoMesAnterior' => 'int',
		'EstadoGastoId' => 'int',
		'PropiedadId' => 'int',
		'GastoMesId' => 'int'
	];

	protected $fillable = [
		'CobroGC',
		'FondoReserva',
		'TotalGC',
		'TotalCobroMes',
		'Fecha',
		'SaldoMesAnterior',
		'EstadoGastoId',
		'PropiedadId',
		'GastoMesId'
	];

	public function estado_gasto()
	{
		return $this->belongsTo(EstadoGasto::class, 'EstadoGastoId');
	}

	public function propiedad()
	{
		return $this->belongsTo(Propiedad::class, 'PropiedadId');
	}

	public function gasto_me()
	{
		return $this->belongsTo(GastoMe::class, 'GastoMesId');
	}

	public function historial_pagos()
	{
		return $this->hasMany(HistorialPago::class, 'GastoComunId');
	}

	public function cobro_individuals()
	{
		return $this->hasMany(CobroIndividual::class, 'GastoComunId');
	}
}
