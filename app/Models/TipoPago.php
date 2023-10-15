<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoPago
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|HistorialPago[] $historial_pagos
 *
 * @package App\Models
 */
class TipoPago extends Model
{
	protected $table = 'TipoPago';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function historial_pagos()
	{
		return $this->hasMany(HistorialPago::class, 'TipoPagoId');
	}
}
