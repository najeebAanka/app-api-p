<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;

class ContactController extends Controller {

    function send(Request $request) {

        $input = $request->all();
        
        $validator = Validator::make($input, [
                    'name' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'message' => 'required',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = new \App\Models\Lead();
        $item->name = $input["name"];
        $item->phone = $input["phone"];
        $item->email = $input["email"];
        $item->message = $input["message"];
        $item->source = "Website";
        $item->save();
        return back()->with('message', 'Thanks for contacting us');
        ;
    }

  
}
