<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EspacioComun
 * 
 * @property int $Id
 * @property int $ComunidadId
 * @property string $Nombre
 * @property int $Precio
 * @property string $Descripcion
 * @property int $Garantia
 * @property int $Enabled
 * 
 * @property Comunidad $comunidad
 * @property Collection|ReservaEspacio[] $reserva_espacios
 *
 * @package App\Models
 */
class EspacioComun extends Model
{
	protected $table = 'EspacioComun';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'ComunidadId' => 'int',
		'Precio' => 'int',
		'Garantia' => 'int',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'ComunidadId',
		'Nombre',
		'Precio',
		'Descripcion',
		'Garantia',
		'Enabled'
	];

	public function comunidad()
	{
		return $this->belongsTo(Comunidad::class, 'ComunidadId');
	}

	public function reserva_espacios()
	{
		return $this->hasMany(ReservaEspacio::class, 'EspacioComunId');
	}
}
