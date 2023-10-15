<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccesoComunidad
 * 
 * @property int $Id
 * @property int $ComunidadId
 * @property int $UsuarioId
 * @property Carbon $FechaAcceso
 * @property int $Enabled
 * 
 * @property Comunidad $comunidad
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class AccesoComunidad extends Model
{
	protected $table = 'AccesoComunidad';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'ComunidadId' => 'int',
		'UsuarioId' => 'int',
		'FechaAcceso' => 'datetime',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'ComunidadId',
		'UsuarioId',
		'FechaAcceso',
		'Enabled'
	];

	public function comunidad()
	{
		return $this->belongsTo(Comunidad::class, 'ComunidadId');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'UsuarioId');
	}
}
