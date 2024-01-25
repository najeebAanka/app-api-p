<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingParam
 * 
 * @property int $id
 * @property int|null $booking_id
 * @property int|null $param_id
 * @property string|null $param_val
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Booking|null $booking
 * @property Parameter|null $parameter
 *
 * @package App\Models
 */
class BookingParam extends Model
{
	protected $table = 'booking_params';

	protected $casts = [
		'booking_id' => 'int',
		'param_id' => 'int'
	];

	protected $fillable = [
		'booking_id',
		'param_id',
		'param_val'
	];

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}

	public function parameter()
	{
		return $this->belongsTo(Parameter::class, 'param_id');
	}
}
