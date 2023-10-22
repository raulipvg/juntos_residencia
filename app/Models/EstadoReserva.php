<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoReserva
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|ReservaEspacio[] $reserva_espacios
 *
 * @package App\Models
 */
class EstadoReserva extends Model
{
	protected $table = 'EstadoReserva';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $fillable = [
		'Nombre'
	];

	public function reserva_espacios()
	{
		return $this->hasMany(ReservaEspacio::class, 'EstadoReservaId');
	}
}
