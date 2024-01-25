<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingService
 * 
 * @property int $id
 * @property int|null $booking_id
 * @property int|null $service_id
 * @property int|null $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Booking|null $booking
 * @property Service|null $service
 *
 * @package App\Models
 */
class BookingService extends Model
{
	protected $table = 'booking_services';

	protected $casts = [
		'booking_id' => 'int',
		'service_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'booking_id',
		'service_id',
		'quantity'
	];

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}

	public function service()
	{
		return $this->belongsTo(Service::class);
	}
}
