<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FrequencyOption
 * 
 * @property int $id
 * @property string|null $title_en
 * @property string|null $title_ar
 * @property string|null $description_en
 * @property string|null $description_ar
 * @property int|null $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Category|null $category
 *
 * @package App\Models
 */
class FrequencyOption extends Model
{
	protected $table = 'frequency_options';

	protected $casts = [
		'category_id' => 'int'
	];

	protected $fillable = [
		'title_en',
		'title_ar',
		'description_en',
		'description_ar',
		'category_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}
}
