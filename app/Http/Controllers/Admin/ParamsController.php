<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;

class ParamsController extends Controller {

    
    
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
        $item = new \App\Models\Parameter();
        $item->title_en = $input["title_en"];
        $item->title_ar = $input["title_ar"];
            $item->title_ha = $input["title_ha"];
        if($request->desc_en){
             $item->description_en = $input["desc_en"];  
        }
           if($request->desc_ha){
             $item->description_ha = $input["desc_ha"];  
        }
          if($request->desc_ar){
             $item->description_ar = $input["desc_ar"];  
        }
        $item->category_id = $input["category_id"];

        
  
        
    
        
        
        $item->save();

        return back()->with('message', 'Inserted succesfully');
        ;
    }

        function insertOption(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'title_en' => 'required',
                    'title_ar' => 'required',
                'title_ha' => 'required',
                    'param_id' => 'required',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = new \App\Models\ParameterOption();
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
        
          if($request->cost){
             $item->added_price = $input["cost"];  
        }
        $item->param_id = $input["param_id"];
        
        $item->save();

        return back()->with('message', 'Inserted succesfully');
        ;
    }

    
    function update(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:parameters,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = \App\Models\Parameter::find($input["id"]);
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

        function deleteOption(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:parameter_options,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = \App\Models\ParameterOption::find($input["id"]);
        $item->delete();
        return back()->with('message', "Deleted succesfully");
        ;
    }
    
    function delete(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:parameters,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
if(\App\Models\BookingParam::where('param_id' ,$input['id'])->count() ==0 ) {
        $item = \App\Models\Parameter::find($input["id"]);
        
        $item->delete();
}else{
     return back()->with('message', "Question can not be deleted , it has bookings related to it");
}

        return back()->with('message', "Deleted succesfully");
        ;
    }

}
