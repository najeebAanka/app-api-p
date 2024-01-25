<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;

class FrequenciesController extends Controller {

    function insert(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'title_en' => 'required',
                    'title_ar' => 'required',
                            'title_ha' => 'required',
                    'category_id' => 'required',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = new \App\Models\FrequencyOption();
        $item->title_en = $input["title_en"];
        $item->title_ar = $input["title_ar"];
           $item->title_ha= $input["title_ha"];
        if($request->desc_en){
             $item->description_en = $input["desc_en"];  
        }
          if($request->desc_ar){
             $item->description_ar = $input["desc_ar"];  
        }
           if($request->desc_ha){
             $item->description_ha = $input["desc_ha"];  
        }
        $item->category_id = $input["category_id"];

        
  
        
    
        
        
        $item->save();

        return back()->with('message', 'Inserted succesfully');
        ;
    }

    
    
    function update(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:frequency_options,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = \App\Models\FrequencyOption::find($input["id"]);
        if ($request->has('title_en'))
            $item->title_en = $input["title_en"];
        if ($request->has('title_ar'))
            $item->title_ar = $input["title_ar"];
        if ($request->has('desc_ar'))
            $item->description_ar = $input["desc_ar"];
        if ($request->has('desc_en'))
            $item->description_en = $input["desc_en"];
        

           if ($request->has('title_ha'))
            $item->title_ha = $input["title_ha"];
        if ($request->has('desc_ha'))
            $item->description_ha = $input["desc_ha"];
        

        $item->save();

        return back()->with('message', 'Changes saved succesfully');
        ;
    }

    function delete(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:frequency_options,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
if(\App\Models\Booking::where('frequency_type' ,$input['id'])->count() ==0 ) {
        $item = \App\Models\FrequencyOption::find($input["id"]);
        
        $item->delete();
}else{
     return back()->with('message', "Frequency option can not be deleted , it has bookings related to it");
}

        return back()->with('message', "Deleted succesfully");
        ;
    }

}
