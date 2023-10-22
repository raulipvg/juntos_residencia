<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RolComponeCoRe
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|Compone[] $compones
 *
 * @package App\Models
 */
class RolComponeCoRe extends Model
{
	protected $table = 'RolComponeCoRe';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $fillable = [
		'Nombre'
	];

	public function compones()
	{
		return $this->hasMany(Compone::class, 'RolComponeCoReId');
	}
}
