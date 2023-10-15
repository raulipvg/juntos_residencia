<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoCobro
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int|null $Precio
 * 
 * @property Collection|CobroIndividual[] $cobro_individuals
 * @property Collection|ReservaEspacio[] $reserva_espacios
 *
 * @package App\Models
 */
class TipoCobro extends Model
{
	protected $table = 'TipoCobro';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'Precio' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Precio'
	];

	public function cobro_individuals()
	{
		return $this->hasMany(CobroIndividual::class, 'TipoCobroId');
	}

	public function reserva_espacios()
	{
		return $this->hasMany(ReservaEspacio::class, 'TipoCobroId');
	}
}
