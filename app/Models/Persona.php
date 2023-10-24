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
			'RUT' => 'required|unique|string|min:8|max:10',
			'Nombre' => 'required|string',
			'Apellido' => 'required|string|max:255',
			'Sexo' => [
				'required',
				'numeric',
				'min:1',
				'max:2',
				Rule::unique('Usuario', 'Username')->ignore($id, 'Id'),
			],
			'Telefono' => 'required|numeric|min:100000000|max:999999999',
			'Email' => [
				'required',
				'email',
				'max:255',
				Rule::unique('Usuario', 'Correo')->ignore($id, 'Id'),
			],
			'Enabled' => 'required|numeric|min:1|max:2',
			'NacionalidadId' => 'required|numeric|min:0',
		];		

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
