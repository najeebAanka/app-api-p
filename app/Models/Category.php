<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string|null $title_en
 * @property string|null $title_ar
 * @property string|null $icon
 * @property int|null $parent_id
 * @property string|null $description_en
 * @property string|null $description_ar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|FrequencyOption[] $frequency_options
 * @property Collection|Parameter[] $parameters
 * @property Collection|Service[] $services
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'parent_id' => 'int'
	];

	protected $fillable = [
		'title_en',
		'title_ar',
		'icon',
		'parent_id',
		'description_en',
		'description_ar'
	];

	public function frequency_options()
	{
		return $this->hasMany(FrequencyOption::class);
	}

	public function parameters()
	{
		return $this->hasMany(Parameter::class);
	}

	public function services()
	{
           return $this->hasMany(Service::class);
	}
        public function buildIcon(){
           return $this->icon!="" ? asset('storage/categories/'.$this->icon):url('dist/assets/img/empty.png');
        }
        
        function has_frequency(){
           return \App\Models\FrequencyOption::where('category_id', $this->id)->count() > 0 ;
        }
}
