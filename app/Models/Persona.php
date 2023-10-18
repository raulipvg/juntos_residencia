<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

/**
 * Class Persona
 * 
 * @property int $Id
 * @property string $RUT
 * @property string $Nombre
 * @property string $Apellido
 * @property string $Sexo
 * @property int $Telefono
 * @property int $Enabled
 * @property int $NacionalidadId
 * 
 * @property Nacionalidad $nacionalidad
 * @property Collection|Copropietario[] $copropietarios
 * @property Collection|Residente[] $residentes
 * @property Collection|HojaVida[] $hoja_vidas
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'Persona';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'Telefono' => 'int',
		'Enabled' => 'int',
		'NacionalidadId' => 'int'
	];

	protected $fillable = [
		'RUT',
		'Nombre',
		'Apellido',
		'Sexo',
		'Telefono',
		'Enabled',
		'NacionalidadId'
	];

	public function nacionalidad()
	{
		return $this->belongsTo(Nacionalidad::class, 'NacionalidadId');
	}

	public function copropietarios()
	{
		return $this->hasMany(Copropietario::class, 'PersonaId');
	}

	public function residentes()
	{
		return $this->hasMany(Residente::class, 'PersonaId');
	}

	public function hoja_vidas()
	{
		return $this->hasMany(HojaVida::class, 'PersonaId');
	}

	public function validate(array $data)
    {
		if(isset($data['Id'])){
			$id = $data['Id'];
		}else{
			$id = null;
		}
		

        $rules = [
			'RUT' => [
					'required',
					Rule::unique('Persona','RUT')->ignore($id, 'Id')
					],
			'Nombre' => 'required|string',
            'Apellido' => 'required|string|max:255',
			'Sexo' => 'required',
			'Telefono' => 'required',
			'RolId' => 'required',
			'Enabled' => 'required',
			'NacionalidadId' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
