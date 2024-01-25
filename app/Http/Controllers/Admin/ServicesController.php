<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;

class ServicesController extends Controller {

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
        $item = new \App\Models\Service();
        $item->title_en = $input["title_en"];
        $item->title_ar = $input["title_ar"];
        $item->title_ha = $input["title_ha"];
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

        
        
                 if ($request->has('max_q'))
            $item->max_quantity = $input["max_q"];
                if ($request->has('new_price'))
            $item->new_price = $input["new_price"];
                    if ($request->has('old_price'))
            $item->old_price = $input["old_price"];
        
        
        
            if ($request->hasFile('image')) {

            $file = $request->only('image')['image'];
            $fileArray = array('image' => $file);
            $rules = array(
                'image' => 'mimes:jpg,png,jpeg|required|max:50000' // max 10000kb
            );
            $validator = Validator::make($fileArray, $rules);
            if ($validator->fails()) {
                return back()->with('error', "Image validation says it is not correct");
                ;
            } else {
                $uniqueFileName = uniqid()
                        . '.' . $file->getClientOriginalExtension();
                $name = date('Y') . "/" . date("m") . "/" . date("d") . "/" . $uniqueFileName;
                try {
                    if (!Storage::disk('public')->has('services/' . date('Y') . "/" . date("m") . "/" . date("d") . "/")) {
                        Storage::disk('public')->makeDirectory('services/' . date('Y') . "/" . date("m") . "/" . date("d") . "/");
                    }
                    
                    Image::make($file)->resize(512, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/services/' . $name));
                    
                    
                    
                    $item->media_url = $name;
                 
                } catch (Exception $r) {
                    return back()->with('error', "Failed to upload image " . $r);
            
                }
            }
        }
        
        
        $item->save();

        return back()->with('message', 'Inserted succesfully');
        ;
    }

    
    
    function update(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:services,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = \App\Models\Service::find($input["id"]);
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
        
        
        
            if ($request->has('max_q'))
            $item->max_quantity = $input["max_q"];
                if ($request->has('new_price'))
            $item->new_price = $input["new_price"];
                    if ($request->has('old_price'))
            $item->old_price = $input["old_price"];
        
        
 
        
          if ($request->hasFile('image')) {

            $file = $request->only('image')['image'];
            $fileArray = array('image' => $file);
            $rules = array(
                'image' => 'mimes:jpg,png,jpeg|required|max:50000' // max 10000kb
            );
            $validator = Validator::make($fileArray, $rules);
            if ($validator->fails()) {
                return back()->with('error', "Image validation says it is not correct");
                ;
            } else {
                $uniqueFileName = uniqid()
                        . '.' . $file->getClientOriginalExtension();
                $name = date('Y') . "/" . date("m") . "/" . date("d") . "/" . $uniqueFileName;
                try {
                    if (!Storage::disk('public')->has('services/' . date('Y') . "/" . date("m") . "/" . date("d") . "/")) {
                        Storage::disk('public')->makeDirectory('services/' . date('Y') . "/" . date("m") . "/" . date("d") . "/");
                    }
                    
                    Image::make($file)->resize(512, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/services/' . $name));
                    
                    
                    
                    $item->media_url = $name;
                    $item->save();
                } catch (Exception $r) {
                    return back()->with('error', "Failed to upload image " . $r);
            
                }
            }
        }
        


        $item->save();

        return back()->with('message', 'Changes saved succesfully');
        ;
    }

    function delete(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:services,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
if(\App\Models\BookingService::where('service_id' ,$input['id'])->count() ==0 ) {
        $item = \App\Models\Service::find($input["id"]);
        
        $item->delete();
}else{
     return back()->with('message', "Service can not be deleted , it has bookings related to it");
}

        return back()->with('message', "Deleted succesfully");
        ;
    }

}
