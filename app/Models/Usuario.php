<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
	public $incrementing = true;
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

	public function validate(array $data)
    {
        $rules = [
            'Nombre' => 'required|string',
            'Apellido' => 'required|string|max:255',
            'Username' => 'required|string|max:255|unique:Usuario',
            'Correo' => 'required|email|max:255|unique:Usuario',
            'Password' => 'required|string|min:8|max:12',
            'EstadoId' => 'required|max:255',
            'RolId' => 'required'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
