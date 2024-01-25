<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Package
 * 
 * @property int $id
 * @property string|null $title_en
 * @property string|null $title_ar
 * @property float|null $price
 * @property string|null $currency
 * @property float|null $old_price
 * @property int|null $duration
 * @property string|null $description_en
 * @property string|null $description_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Package extends Model
{
	protected $table = 'packages';

	protected $casts = [
		'price' => 'float',
		'old_price' => 'float',
		'duration' => 'int'
	];

	protected $fillable = [
		'title_en',
		'title_ar',
		'price',
		'currency',
		'old_price',
		'duration',
		'description_en',
		'description_ar'
	];
}
