<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nacionalidad
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class Nacionalidad extends Model
{
	protected $table = 'Nacionalidad';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function personas()
	{
		return $this->hasMany(Persona::class, 'NacionalidadId');
	}
}
