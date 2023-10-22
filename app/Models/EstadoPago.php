<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoPago
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|HistorialPago[] $historial_pagos
 *
 * @package App\Models
 */
class EstadoPago extends Model
{
	protected $table = 'EstadoPago';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $fillable = [
		'Nombre'
	];

	public function historial_pagos()
	{
		return $this->hasMany(HistorialPago::class, 'EstadoPagoId');
	}
}
