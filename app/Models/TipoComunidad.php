<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoComunidad
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|Comunidad[] $comunidads
 *
 * @package App\Models
 */
class TipoComunidad extends Model
{
	protected $table = 'TipoComunidad';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function comunidads()
	{
		return $this->hasMany(Comunidad::class, 'TipoComunidadId');
	}
}
