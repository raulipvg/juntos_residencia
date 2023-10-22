<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rol
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $Descripcion
 * 
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Rol extends Model
{
	protected $table = 'Rol';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $fillable = [
		'Nombre',
		'Descripcion'
	];

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'RolId');
	}
}
