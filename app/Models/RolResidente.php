<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RolResidente
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|Residente[] $residentes
 *
 * @package App\Models
 */
class RolResidente extends Model
{
	protected $table = 'RolResidente';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function residentes()
	{
		return $this->hasMany(Residente::class, 'RolId');
	}
}
