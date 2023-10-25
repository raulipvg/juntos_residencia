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
 * Class HojaVida
 * 
 * @property int $Id
 * @property int $PersonaId
 * @property string $Titulo
 * @property string $Descripcion
 * @property Carbon $Fecha
 * @property int $Enabled
 * 
 * @property Persona $persona
 *
 * @package App\Models
 */
class HojaVida extends Model
{
	protected $table = 'HojaVida';
	protected $primaryKey = 'Id';
	public $timestamps = false;

	protected $casts = [
		'PersonaId' => 'int',
		'Fecha' => 'datetime',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'PersonaId',
		'Titulo',
		'Descripcion',
		'Fecha',
		'Enabled'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'PersonaId');
	}

	public function validate(array $data)
    {
        if(isset($data['Id'])){
            $id = $data['Id'];
        }else{
            $id = null;
        }


        $rules = [
            'Titulo' => 'required|string|max:100',
            'Descripcion' => 'required|string|max:500',
            'Fecha' => 'required|date',
            'Enabled'=> 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
