<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;

class BookingsController extends Controller {

    function update(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:bookings,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = \App\Models\Booking::find($input["id"]);
        if ($request->has('status')) {
            $item->status = $input["status"];
            $update = new \App\Models\ActivityTracker();
            $update->target_id = $item->id;
            $update->target_type = \App\Models\ActivityTracker::TARGET_BOOKING;
            $update->contents = \Illuminate\Support\Facades\Auth::user()->name . " changed booking No " . $input["id"] . " to " . $input["status"];
            $update->save();
        }
        if ($request->has('reply') && $input["reply"]!="" ) {
            
            if($item->reply !=  $input["reply"]){
            $update = new \App\Models\ActivityTracker();
            $update->target_id = $item->id;
            $update->target_type = \App\Models\ActivityTracker::TARGET_BOOKING;
            $update->contents = \Illuminate\Support\Facades\Auth::user()->name . " added a reply to booking No " . $input["id"] . " [" . $input["reply"] . "]";
            }
            $item->reply = $input["reply"];
            $update->save();
        }








        $item->save();
        
   if ($request->has('status')) {        
        
     //uncomment when in production
         if(\App\Helpers\Environment::TEST_MODE == false){
        $emailController = new \App\Http\Controllers\Emails\EmailsController();
        $emailController->sendBookingChangedEmail($input["id"]);
         }
         }  
         
         
        return back()->with('message', 'Changes saved succesfully');
        ;
    }

}
