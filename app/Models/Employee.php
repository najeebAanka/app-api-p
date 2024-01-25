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
class Employee extends Model
{
	protected $table = 'employees';

             public function buildIcon(){
      // return $this->icon? assets('categories').$this->icon : 
      return $this->profile_pic!="" ? asset('storage/employees/'.$this->profile_pic):url('dist/assets/img/empty.png');
        }
	
}
