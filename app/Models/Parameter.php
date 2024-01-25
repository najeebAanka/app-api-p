<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Parameter
 * 
 * @property int $id
 * @property string|null $title_en
 * @property string|null $title_ar
 * @property string|null $icon
 * @property string|null $description_en
 * @property string|null $description_ar
 * @property int|null $param_type
 * @property int|null $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Category|null $category
 * @property Collection|BookingParam[] $booking_params
 * @property Collection|ParameterOption[] $parameter_options
 *
 * @package App\Models
 */
class Parameter extends Model
{
	protected $table = 'parameters';

	protected $casts = [
		'param_type' => 'int',
		'category_id' => 'int'
	];

	protected $fillable = [
		'title_en',
		'title_ar',
		'icon',
		'description_en',
		'description_ar',
		'param_type',
		'category_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function booking_params()
	{
		return $this->hasMany(BookingParam::class, 'param_id');
	}

	public function parameter_options()
	{
		return $this->hasMany(ParameterOption::class, 'param_id');
	}
}
