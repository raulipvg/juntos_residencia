<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Persona
 * 
 * @property int $Id
 * @property string $RUT
 * @property string $Nombre
 * @property string $Apellido
 * @property string $Sexo
 * @property int $Telefono
 * @property string $Email
 * @property int $Enabled
 * @property int $NacionalidadId
 * 
 * @property Nacionalidad $nacionalidad
 * @property Collection|Compone[] $compones
 * @property Collection|HojaVida[] $hoja_vidas
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'Persona';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
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
		'Email',
		'Enabled',
		'NacionalidadId'
	];

	public function nacionalidad()
	{
		return $this->belongsTo(Nacionalidad::class, 'NacionalidadId');
	}

	public function compones()
	{
		return $this->hasMany(Compone::class, 'PersonaId');
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
                'string',
                'max:50',
                Rule::unique('Persona','RUT')->ignore($id, 'Id'),
            ],
			'Nombre' => 'required|string',
			'Apellido' => 'required|string|max:255',
			'Sexo' => 'required|string',
			'Telefono' => 'required|numeric',
			'Email' => [
				'required',
				'email',
				'max:255',
				Rule::unique('Persona', 'Email')->ignore($id, 'Id'),
			],
			'Enabled' => 'required|numeric|',
			'NacionalidadId' => 'required|numeric',
		];		

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
