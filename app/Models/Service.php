<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * 
 * @property int $id
 * @property string|null $title_en
 * @property string|null $title_ar
 * @property string|null $description_en
 * @property string|null $description_ar
 * @property string|null $media_url
 * @property int|null $category_id
 * @property int|null $media_type
 * @property float|null $old_price
 * @property float|null $new_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Category|null $category
 * @property Collection|Booking[] $bookings
 *
 * @package App\Models
 */
class Service extends Model
{
	protected $table = 'services';

	protected $casts = [
		'category_id' => 'int',
		'media_type' => 'int',
		'old_price' => 'float',
		'new_price' => 'float'
	];

	protected $fillable = [
		'title_en',
		'title_ar',
		'description_en',
		'description_ar',
		'media_url',
		'category_id',
		'media_type',
		'old_price',
		'new_price'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function bookings()
	{
		return $this->belongsToMany(Booking::class, 'booking_services')
					->withPivot('id', 'quantity')
					->withTimestamps();
	}
        
          public function buildIcon(){
      return $this->media_url!="" ? asset('storage/services/'.$this->media_url):url('dist/assets/img/empty.png');
        }
        
}
