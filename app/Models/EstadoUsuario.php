<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoUsuario
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class EstadoUsuario extends Model
{
	protected $table = 'EstadoUsuario';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'EstadoId');
	}
}
