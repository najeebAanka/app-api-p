<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Booking
 * 
 * @property int $id
 * @property int|null $user_id
 * @property Carbon|null $requested_date
 * @property int|null $address_id
 * @property float|null $subtotal
 * @property float|null $vat
 * @property float|null $dicount
 * @property float|null $grand_total
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Address|null $address
 * @property Collection|BookingParam[] $booking_params
 * @property Collection|Service[] $services
 *
 * @package App\Models
 */
class Booking extends Model
{
	protected $table = 'bookings';

	protected $casts = [
		'user_id' => 'int',
		'address_id' => 'int',
		'subtotal' => 'float',
		'vat' => 'float',
		'dicount' => 'float',
		'grand_total' => 'float'
	];

	protected $dates = [
		'requested_date'
	];

	protected $fillable = [
		'user_id',
		'requested_date',
		'address_id',
		'subtotal',
		'vat',
		'dicount',
		'grand_total',
		'status'
	];

	public function address()
	{
		return $this->belongsTo(Address::class);
	}

	public function booking_params()
	{
		return $this->hasMany(BookingParam::class);
	}

	public function services()
	{
		return $this->belongsToMany(Service::class, 'booking_services')
					->withPivot('id', 'quantity')
					->withTimestamps();
	}
}
