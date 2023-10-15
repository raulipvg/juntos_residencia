<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoGastoMe
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|GastoMe[] $gasto_mes
 *
 * @package App\Models
 */
class EstadoGastoMe extends Model
{
	protected $table = 'EstadoGastoMes';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function gasto_mes()
	{
		return $this->hasMany(GastoMe::class, 'EstadoId');
	}
}
