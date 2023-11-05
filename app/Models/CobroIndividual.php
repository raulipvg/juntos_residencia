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
	public $timestamps = false;

	protected $casts = [
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

	public function validate(array $data)
    {
		if(isset($data['Id'])){
			$id = $data['Id'];
		}else{
			$id = null;
		}

        $rules = [
            'Nombre' => 'required|string|max:50',
            'Descipcion' => 'required|string|max:50',
            'Cantidad' => 'required|numeric',
            'MontoTotal' => 'required|numeric',
            'TipoCobroId' => 'required|numeric',
            'GastoComunId' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
