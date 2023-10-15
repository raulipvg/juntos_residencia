<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HojaVida
 * 
 * @property int $Id
 * @property int $PersonaId
 * @property string $Titulo
 * @property string $Descripcion
 * @property Carbon $Fecha
 * 
 * @property Persona $persona
 *
 * @package App\Models
 */
class HojaVida extends Model
{
	protected $table = 'HojaVida';
	protected $primaryKey = 'Id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Id' => 'int',
		'PersonaId' => 'int',
		'Fecha' => 'datetime'
	];

	protected $fillable = [
		'PersonaId',
		'Titulo',
		'Descripcion',
		'Fecha'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'PersonaId');
	}
}
