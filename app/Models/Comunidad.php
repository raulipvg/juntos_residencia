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
use Illuminate\Validation\Rule;

/**
 * Class Comunidad
 * 
 * @property int $Id
 * @property string $Nombre
 * @property string $RUT
 * @property string $Correo
 * @property int $NumeroCuenta
 * @property string $TipoCuenta
 * @property string $Banco
 * @property int $CantPropiedades
 * @property Carbon $FechaRegistro
 * @property int $Enabled
 * @property int $TipoComunidadId
 * @property string $Domicilio
 * @property string $Telefono
 * 
 * @property TipoComunidad $tipo_comunidad
 * @property Collection|EspacioComun[] $espacio_comuns
 * @property Collection|GastoMe[] $gasto_mes
 * @property Collection|TipoCobro[] $tipo_cobros
 * @property Collection|AccesoComunidad[] $acceso_comunidads
 * @property Collection|Propiedad[] $propiedads
 *
 * @package App\Models
 */
class Comunidad extends Model
{
	protected $table = 'Comunidad';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'NumeroCuenta' => 'int',
		'CantPropiedades' => 'int',
		'FechaRegistro' => 'datetime',
		'Enabled' => 'int',
		'TipoComunidadId' => 'int'
	];

	protected $fillable = [
		'Nombre',
		'RUT',
		'Correo',
		'NumeroCuenta',
		'TipoCuenta',
		'Banco',
		'CantPropiedades',
		'FechaRegistro',
		'Enabled',
		'TipoComunidadId',
		'Domicilio',
		'Telefono'
	];

	public function tipo_comunidad()
	{
		return $this->belongsTo(TipoComunidad::class, 'TipoComunidadId');
	}

	public function espacio_comuns()
	{
		return $this->hasMany(EspacioComun::class, 'ComunidadId');
	}

	public function gasto_mes()
	{
		return $this->hasMany(GastoMe::class, 'ComunidadId');
	}

	public function tipo_cobros()
	{
		return $this->hasMany(TipoCobro::class, 'ComunidadId');
	}

	public function acceso_comunidads()
	{
		return $this->hasMany(AccesoComunidad::class, 'ComunidadId');
	}

	public function propiedads()
	{
		return $this->hasMany(Propiedad::class, 'ComunidadId');
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
            'RUT' => [
                'required',
                'string',
                'max:50',
                Rule::unique('Comunidad','RUT')->ignore($id, 'Id'),
            ],
            'Correo' => 'required|email|max:50',
            'NumeroCuenta' => 'required|numeric',
            'TipoCuenta' => 'required|string',
            'Banco' => 'required|string',
            'CantPropiedades' => 'required|numeric',
            'FechaRegistro' => 'required|date',
            'Enabled' => 'required|min:1|max:2',
            'TipoComunidadId' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
