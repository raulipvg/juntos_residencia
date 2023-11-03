<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

/**
 * Class GastosDetalle
 * 
 * @property int $Id
 * @property int $GastoMesId
 * @property string $Nombre
 * @property string $Responsable
 * @property string|null $Descripcion
 * @property string|null $NroDocumento
 * @property int $TipoDocumentoId
 * @property int $Precio
 * @property int $TipoGastoId
 * 
 * @property GastoMe $gasto_me
 * @property TipoDocumento $tipo_documento
 * @property TipoGasto $tipo_gasto
 *
 * @package App\Models
 */
class GastosDetalle extends Model
{
	protected $table = 'GastosDetalle';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'GastoMesId' => 'int',
		'TipoDocumentoId' => 'int',
		'Precio' => 'int',
		'TipoGastoId' => 'int'
	];

	protected $fillable = [
		'GastoMesId',
		'Nombre',
		'Responsable',
		'Descripcion',
		'NroDocumento',
		'TipoDocumentoId',
		'Precio',
		'TipoGastoId'
	];

	public function gasto_me()
	{
		return $this->belongsTo(GastoMe::class, 'GastoMesId');
	}

	public function tipo_documento()
	{
		return $this->belongsTo(TipoDocumento::class, 'TipoDocumentoId');
	}

	public function tipo_gasto()
	{
		return $this->belongsTo(TipoGasto::class, 'TipoGastoId');
	}
	public function validate(array $data)
    {
		if(isset($data['Id'])){
			$id = $data['Id'];
		}else{
			$id = null;
		}

        $rules = [
            'GastoMesId' => 'required|numeric',
            'Nombre' => 'required|string|max:50',
			'Responsable' => 'required|string|max:50',
			'Descripcion' => 'string|nulleable|max:50',
			'NroDocumento' => 'string|nulleable|max:50',
			'TipoDocumentoId' => 'required|numeric',
			'Precio' => 'required|numeric',
            'TipoGastoId' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

}
