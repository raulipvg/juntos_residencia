<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

/**
 * Class AccesoComunidad
 * 
 * @property int $Id
 * @property int $ComunidadId
 * @property int $UsuarioId
 * @property Carbon $FechaAcceso
 * @property int $Enabled
 * 
 * @property Comunidad $comunidad
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class AccesoComunidad extends Model
{
	protected $table = 'AccesoComunidad';
	protected $primaryKey = 'Id';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'ComunidadId' => 'int',
		'UsuarioId' => 'int',
		'FechaAcceso' => 'datetime',
		'Enabled' => 'int'
	];

	protected $fillable = [
		'ComunidadId',
		'UsuarioId',
		'FechaAcceso',
		'Enabled'
	];

	public function comunidad()
	{
		return $this->belongsTo(Comunidad::class, 'ComunidadId');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'UsuarioId');
	}
	public function validate(array $data)
    {
		if(isset($data['Id'])){
			$id = $data['Id'];
		}else{
			$id = null;
		}

        $rules = [
            'ComunidadId' => 'required|numeric',
            'UsuarioId' => 'required|numeric',
            'FechaAcceso' => 'required|date',
            'Enabled' => 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
