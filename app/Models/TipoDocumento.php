<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoDocumento
 * 
 * @property int $Id
 * @property string $Nombre
 * 
 * @property Collection|GastosDetalle[] $gastos_detalles
 *
 * @package App\Models
 */
class TipoDocumento extends Model
{
	protected $table = 'TipoDocumento';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int'
	];

	protected $fillable = [
		'Nombre'
	];

	public function gastos_detalles()
	{
		return $this->hasMany(GastosDetalle::class, 'TipoDocumentoId');
	}
}
