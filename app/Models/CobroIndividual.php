<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'Cantidad' => 'int',
		'MontoTotal' => 'int',
		'TipoCobroId' => 'int',
		'GastoComunId' => 'int',
		'PropiedadId'=> 'int',
		'EstadoId'=> 'int',
		'Fecha'=> 'datetime',
	];

	protected $fillable = [
		'Nombre',
		'Descripcion',
		'Cantidad',
		'MontoTotal',
		'TipoCobroId',
		'GastoComunId',
		'PropiedadId',
		'EstadoId',
		'Fecha',
	];

	public function tipo_cobro()
	{
		return $this->belongsTo(TipoCobro::class, 'TipoCobroId');
	}

	public function gasto_comun()
	{
		return $this->belongsTo(GastoComun::class, 'GastoComunId');
	}

	public function validate(array $data)
    {
		if(isset($data['Id'])){
			$id = $data['Id'];
		}else{
			$id = null;
		}

        $rules = [
            'Nombre' => 'required|string|max:50',
            'Descripcion' => 'nullable|string|max:50',
            'Cantidad' => 'required|numeric',
            'MontoTotal' => 'required|numeric',
            'TipoCobroId' => 'required|numeric',
            'GastoComunId' => 'nullable|numeric',
			'EstadoId' => 'required|numeric',
			'Fecha' => 'required|date',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
