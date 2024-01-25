<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;

class CategoriesController extends Controller {

    function insert(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'title_en' => 'required',
                    'title_ar' => 'required',
                    'title_ha' => 'required',
                  
                    'parent_id' => 'required',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = new \App\Models\Category();
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
        $item->parent_id = $input["parent_id"];

        
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
                    if (!Storage::disk('public')->has('categories/' . date('Y') . "/" . date("m") . "/" . date("d") . "/")) {
                        Storage::disk('public')->makeDirectory('categories/' . date('Y') . "/" . date("m") . "/" . date("d") . "/");
                    }
                    
                    Image::make($file)->resize(512, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/categories/' . $name));
                    
                    
                    
                    $item->icon = $name;
                    $item->save();
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
                    'id' => 'required|exists:categories,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = \App\Models\Category::find($input["id"]);
        if ($request->has('title_en'))
            $item->title_en = $input["title_en"];
        if ($request->has('title_ar'))
            $item->title_ar = $input["title_ar"];
           if ($request->has('title_ha'))
            $item->title_ha = $input["title_ha"];
        if ($request->has('desc_ar'))
            $item->description_ar = $input["desc_ar"];
        if ($request->has('desc_en'))
            $item->description_en = $input["desc_en"];
           if ($request->has('desc_ha'))
            $item->description_ha = $input["desc_ha"];
 
            if ($request->has('base_price'))
            $item->base_price = $input["base_price"];
 
        
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
                    if (!Storage::disk('public')->has('categories/' . date('Y') . "/" . date("m") . "/" . date("d") . "/")) {
                        Storage::disk('public')->makeDirectory('categories/' . date('Y') . "/" . date("m") . "/" . date("d") . "/");
                    }
                    
                    Image::make($file)->resize(512, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/categories/' . $name));
                    
                    
                    
                    $item->icon = $name;
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
                    'id' => 'required|exists:categories,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
if(\App\Models\Category::where('parent_id' ,$input['id'])->count() ==0 ) {
        $item = \App\Models\Category::find($input["id"]);
        
        $item->delete();
}else{
     return back()->with('message', "Category can not be deleted , it has subcategories under it");
}

        return back()->with('message', "Deleted succesfully");
        ;
    }

}
