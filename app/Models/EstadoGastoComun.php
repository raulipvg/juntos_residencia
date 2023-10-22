<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoGastoComun
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|GastoComun[] $gasto_comuns
 *
 * @package App\Models
 */
class EstadoGastoComun extends Model
{
	protected $table = 'EstadoGastoComun';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $fillable = [
		'Nombre'
	];

	public function gasto_comuns()
	{
		return $this->hasMany(GastoComun::class, 'EstadoGastoId');
	}
}
