<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ParameterOption
 * 
 * @property int $id
 * @property string|null $title_en
 * @property string|null $title_ar
 * @property string|null $description_en
 * @property string|null $description_ar
 * @property int|null $param_id
 * @property float|null $added_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Parameter|null $parameter
 *
 * @package App\Models
 */
class ParameterOption extends Model
{
	protected $table = 'parameter_options';

	protected $casts = [
		'param_id' => 'int',
		'added_price' => 'float'
	];

	protected $fillable = [
		'title_en',
		'title_ar',
		'description_en',
		'description_ar',
		'param_id',
		'added_price'
	];

	public function parameter()
	{
		return $this->belongsTo(Parameter::class, 'param_id');
	}
}
