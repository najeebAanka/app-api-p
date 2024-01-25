<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class HomeNotificationsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = new \stdClass();
        $data->count_notifications = \App\Models\Booking::where('seen' ,-1)->count();
        $data->updates = \App\Models\ActivityTracker::orderBy('id', 'desc')->take(25)->get();
        foreach ($data->updates as $u){
              $alarm = false;
              
            if($u->seen == -1){
             $alarm  = true;  
               $u->seen = 1;
               $u->save();
            }else{
                   $alarm  =  false; 
            }
              $u->time = time_elapsed_string($u->created_at);
              $u->alarm = $alarm;
        }
      
        return $this->formResponse("Ok",  $data , Response::HTTP_OK);
    }

}
