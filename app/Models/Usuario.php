<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 *
 * @property int $Id
 * @property string $Nombre
 * @property string $Apellido
 * @property string $Username
 * @property string $Correo
 * @property string $Password
 * @property int $EstadoId
 * @property int $RolId
 *
 * @property EstadoUsuario $estado_usuario
 * @property Rol $rol
 * @property Collection|AccesoComunidad[] $acceso_comunidads
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'Usuario';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'EstadoId' => 'int',
		'RolId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Apellido',
		'Username',
		'Correo',
		'Password',
		'EstadoId',
		'RolId'
	];

	public function estado_usuario()
	{
		return $this->belongsTo(EstadoUsuario::class, 'EstadoId');
	}

	public function rol()
	{
		return $this->belongsTo(Rol::class, 'RolId');
	}

	public function acceso_comunidads()
	{
		return $this->hasMany(AccesoComunidad::class, 'UsuarioId');
	}
}
