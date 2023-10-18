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
 * Class Residente
 * 
 * @property int $Id
 * @property int $PersonaId
 * @property int $PropiedadId
 * @property int $RolId
 * @property Carbon $FechaInicio
 * @property Carbon|null $FechaFin
 * 
 * @property Persona $persona
 * @property Propiedad $propiedad
 * @property RolResidente $rol_residente
 *
 * @package App\Models
 */
class Residente extends Model
{
	protected $table = 'Residente';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'PersonaId' => 'int',
		'PropiedadId' => 'int',
		'RolId' => 'int',
		'FechaInicio' => 'datetime',
		'FechaFin' => 'datetime'
	];

	protected $fillable = [
		'PersonaId',
		'PropiedadId',
		'RolId',
		'FechaInicio',
		'FechaFin'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'PersonaId');
	}

	public function propiedad()
	{
		return $this->belongsTo(Propiedad::class, 'PropiedadId');
	}

	public function rol_residente()
	{
		return $this->belongsTo(RolResidente::class, 'RolId');
	}

	public function validate(array $data)
    {
		if(isset($data['Id'])){
			$id = $data['Id'];
		}else{
			$id = null;
		}
		

        $rules = [
			'PersonaId' => 'required',
			'PropiedadId' => 'required',
			'RolId' => 'required',
			'FechaInicio' => 'required|date',
			'FechaFin' => 'date|nullable'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
