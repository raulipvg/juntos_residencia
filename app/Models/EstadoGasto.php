<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoGasto
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|GastoComun[] $gasto_comuns
 *
 * @package App\Models
 */
class EstadoGasto extends Model
{
	protected $table = 'EstadoGasto';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function gasto_comuns()
	{
		return $this->hasMany(GastoComun::class, 'EstadoGastoId');
	}
}
