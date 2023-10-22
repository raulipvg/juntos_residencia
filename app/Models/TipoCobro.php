<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoCobro
 * 
 * @property int $Id
 * @property string $Nombre
 * @property int|null $Precio
 * @property int $Enabled
 * @property int $ComunidadId
 * 
 * @property Comunidad $comunidad
 * @property Collection|CobroIndividual[] $cobro_individuals
 *
 * @package App\Models
 */
class TipoCobro extends Model
{
	protected $table = 'TipoCobro';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'Precio' => 'int',
		'Enabled' => 'int',
		'ComunidadId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Precio',
		'Enabled',
		'ComunidadId'
	];

	public function comunidad()
	{
		return $this->belongsTo(Comunidad::class, 'ComunidadId');
	}

	public function cobro_individuals()
	{
		return $this->hasMany(CobroIndividual::class, 'TipoCobroId');
	}
}
