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
class ActivityTracker extends Model
{
    
    
    public const TARGET_BOOKING = 100;
	protected $table = 'activity_tracker';


}
