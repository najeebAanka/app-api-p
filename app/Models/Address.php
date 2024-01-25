<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * 
 * @property int $id
 * @property int|null $user_id
 * @property string|null $city
 * @property string|null $address1
 * @property string|null $address2
 * @property float|null $lat
 * @property float|null $lng
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Booking[] $bookings
 *
 * @package App\Models
 */
class Address extends Model
{
	protected $table = 'addresses';

	protected $casts = [
		'user_id' => 'int',
		'lat' => 'float',
		'lng' => 'float'
	];

	protected $fillable = [
		'user_id',
		'city',
		'address1',
		'address2',
		'lat',
		'lng'
	];

	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}
}
