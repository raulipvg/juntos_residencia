<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CobroIndividual
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $Descripcion
 * @property int $Cantidad
 * @property int $MontoTotal
 * @property int $TipoCobroId
 * @property int $GastoComunId
 * 
 * @property TipoCobro $tipo_cobro
 * @property GastoComun $gasto_comun
 *
 * @package App\Models
 */
class CobroIndividual extends Model
{
	protected $table = 'CobroIndividual';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'Cantidad' => 'int',
		'MontoTotal' => 'int',
		'TipoCobroId' => 'int',
		'GastoComunId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Cantidad',
		'MontoTotal',
		'TipoCobroId',
		'GastoComunId'
	];

	public function tipo_cobro()
	{
		return $this->belongsTo(TipoCobro::class, 'TipoCobroId');
	}

	public function gasto_comun()
	{
		return $this->belongsTo(GastoComun::class, 'GastoComunId');
	}
}
