<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class GastoMe
 * 
 * @property int $Id
 * @property Carbon $Fecha
 * @property int $TotalRemuneracion
 * @property int $TotasOtros
 * @property int $TotalAdm
 * @property int $TotalConsumo
 * @property int $TotalMantencion
 * @property int $TotalReparacion
 * @property int $TotalMes
 * @property float $PorcentajeFondo
 * @property int $FondoReserva
 * @property int $Total
 * @property int $EstadoId
 * @property int $ComunidadId
 * 
 * @property EstadoGastoMe $estado_gasto_me
 * @property Comunidad $comunidad
 * @property Collection|GastosDetalle[] $gastos_detalles
 * @property Collection|GastoComun[] $gasto_comuns
 *
 * @package App\Models
 */
class GastoMe extends Model
{
	protected $table = 'GastoMes';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'Fecha' => 'datetime',
		'TotalRemuneracion' => 'int',
		'TotalCajaChica' => 'int',
		'TotasOtros' => 'int',
		'TotalAdm' => 'int',
		'TotalConsumo' => 'int',
		'TotalMantencion' => 'int',
		'TotalReparacion' => 'int',
		'TotalMes' => 'int',
		'PorcentajeFondo' => 'float',
		'FondoReserva' => 'int',
		'Total' => 'int',
		'EstadoId' => 'int',
		'ComunidadId' => 'int'
	];

	protected $fillable = [
		'Fecha',
		'TotalRemuneracion',
		'TotalCajaChica',
		'TotasOtros',
		'TotalAdm',
		'TotalConsumo',
		'TotalMantencion',
		'TotalReparacion',
		'TotalMes',
		'PorcentajeFondo',
		'FondoReserva',
		'Total',
		'EstadoId',
		'ComunidadId'
	];

	public function estado_gasto_me()
	{
		return $this->belongsTo(EstadoGastoMe::class, 'EstadoId');
	}

	public function comunidad()
	{
		return $this->belongsTo(Comunidad::class, 'ComunidadId');
	}

	public function gastos_detalles()
	{
		return $this->hasMany(GastosDetalle::class, 'GastoMesId');
	}

	public function gasto_comuns()
	{
		return $this->hasMany(GastoComun::class, 'GastoMesId');
	}

	public function validate(array $data)
    {
		if(isset($data['Id'])){
			$id = $data['Id'];
		}else{
			$id = null;
		}

        $rules = [
            'Fecha' => 'required|date',
            'TotalRemuneracion' => 'required|numeric',
            'TotasOtros' => 'required|numeric',
            'TotalAdm' => 'required|numeric',
            'TotalConsumo' => 'required|numeric',
            'TotalMantencion' => 'required|numeric',
            'TotalReparacion' => 'required|numeric',
			'TotalCajaChica'=> 'required|numeric',
            'TotalMes' => 'required|numeric',
            'PorcentajeFondo' => 'required|numeric',
            'FondoReserva' => 'required|numeric',
            'Total' => 'required|numeric',
            'EstadoId' => 'required|numeric',
            'ComunidadId' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
