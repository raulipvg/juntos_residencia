<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class ReservaEspacio
 * 
 * @property int $Id
 * @property Carbon $FechaSolicitud
 * @property Carbon $FechaUso
 * @property int $Cantidad
 * @property int $Total
 * @property int $TipoCobroId
 * @property int $GastoComunId
 * @property int $PropiedadId
 * @property int $EstadoReservaId
 * @property int $EspacioComunId
 * 
 * @property GastoComun $gasto_comun
 * @property Propiedad $propiedad
 * @property EstadoReserva $estado_reserva
 * @property EspacioComun $espacio_comun
 *
 * @package App\Models
 */
class ReservaEspacio extends Model
{
	protected $table = 'ReservaEspacio';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'FechaSolicitud' => 'datetime',
		'FechaUso' => 'datetime',
		'Cantidad' => 'int',
		'Total' => 'int',
		'TipoCobroId' => 'int',
		'GastoComunId' => 'int',
		'PropiedadId' => 'int',
		'EstadoReservaId' => 'int',
		'EspacioComunId' => 'int'
	];

	protected $fillable = [
		'FechaSolicitud',
		'FechaUso',
		'Cantidad',
		'Total',
		'TipoCobroId',
		'GastoComunId',
		'PropiedadId',
		'EstadoReservaId',
		'EspacioComunId'
	];

	public function gasto_comun()
	{
		return $this->belongsTo(GastoComun::class, 'GastoComunId');
	}

	public function propiedad()
	{
		return $this->belongsTo(Propiedad::class, 'PropiedadId');
	}

	public function estado_reserva()
	{
		return $this->belongsTo(EstadoReserva::class, 'EstadoReservaId');
	}

	public function espacio_comun()
	{
		return $this->belongsTo(EspacioComun::class, 'EspacioComunId');
	}

	public function validate(array $data)
    {
		if(isset($data['Id'])){
			$id = $data['Id'];
		}else{
			$id = null;
		}

        $rules = [
            'FechaSolicitud' => 'required|date',
            'FechaUso' => 'required|date',
			'Cantidad' => 'required|date',
			'Total' => 'required|numeric',
			'GastoComunId' => 'required|numeric',
			'PropiedadId' => 'required|numeric',
            'EstadoReservaId' => 'required|numeric',
            'EstadoComunId' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
