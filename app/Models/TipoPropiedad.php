<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoPropiedad
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|Propiedad[] $propiedads
 *
 * @package App\Models
 */
class TipoPropiedad extends Model
{
	protected $table = 'TipoPropiedad';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $fillable = [
		'Nombre'
	];

	public function propiedads()
	{
		return $this->hasMany(Propiedad::class, 'TipoPropiedad');
	}
}
