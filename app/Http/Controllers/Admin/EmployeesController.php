<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;

class EmployeesController extends Controller {
    function insert(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'name' => 'required',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = new \App\Models\Employee();
        $item->name = $input["name"];
    
        if($request->details){
             $item->details = $input["details"];  
        }
        
           if($request->email){
             $item->email = $input["email"];  
        }
           if($request->phone){
             $item->phone = $input["phone"];  
        }
           if($request->department){
             $item->department = $input["department"];  
        }
        
        
        
        
    
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
                    if (!Storage::disk('public')->has('employees/' . date('Y') . "/" . date("m") . "/" . date("d") . "/")) {
                        Storage::disk('public')->makeDirectory('employees/' . date('Y') . "/" . date("m") . "/" . date("d") . "/");
                    }
                    
                    Image::make($file)->resize(512, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/employees/' . $name));
                    
                    
                    
                    $item->profile_pic = $name;
               
                } catch (Exception $r) {
                    return back()->with('error', "Failed to upload image " . $r);
            
                }
            }
        }
            $item->save();

        return back()->with('message', 'Inserted succesfully');
        ;
    }

    function link(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'emp_id' => 'required',
                    'cat_id' => 'required',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $item = new \App\Models\CategoryEmployee();
        $item->cat_id = $input["cat_id"];
        $item->emp_id = $input["emp_id"];
            $item->save();

        return back()->with('message', 'Linked successfully');
        ;
    }
     function unlink(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        $link = \App\Models\CategoryEmployee::find( $input ['id']);
            $link->delete();

        return back()->with('message', 'Unlinked successfully');
        ;
    }
    
        function addSlot(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'link_id' => 'required',
                    'day_of_week' => 'required',
                    'start_hour' => 'required',
                    'end_hour' => 'required',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
        
        if(\App\Models\EmployeeTimeSlot::where('link_id' , $input["link_id"])
                ->where('day_of_week' ,$input["day_of_week"])
                ->where(function ($q) use ($input){
                $q->whereNotBetween('slot_from' ,[$input["start_hour"]   ,$input["end_hour"]]) ;   
                $q->orwhereNotBetween( 'slot_to',[$input["start_hour"]   ,$input["end_hour"]]) ;   
                    
                })->count() ==0
                ){
        $item = new \App\Models\EmployeeTimeSlot();
        $item->link_id = $input["link_id"];
        $item->day_of_week = $input["day_of_week"];
        $item->slot_from = $input["start_hour"];
        $item->slot_to = $input["end_hour"];
        $item->extra_cost = $input["extra_cost"];
      
            $item->save();
                }else{
                   return back()->with('error', 'This time slot can not be added , there is a conflict in timing with another slot or another service');  
                }
        return back()->with('message', 'Slot added successfully');
        ;
    }
       function deleteSlot(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:employee_times,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }

        $item = \App\Models\EmployeeTimeSlot::find($input["id"]);
        $item->delete();
        return back()->with('message', "Time slot succesfully");
        ;
    } 
       function updateSlot(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
                    'id' => 'required|exists:employee_times,id',
                    'cost' => 'required',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }

        $item = \App\Models\EmployeeTimeSlot::find($input["id"]);
        $item->extra_cost = $input['cost'];
        $item->save();
        return back()->with('message', "Time slot cost changed to ".$input['cost']);
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
        $item = \App\Models\Employee::find($input["id"]);
        if ($request->has('name'))
            $item->name = $input["name"];
        if ($request->has('details'))
            $item->details = $input["details"];
      
 
        
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
                    if (!Storage::disk('public')->has('employees/' . date('Y') . "/" . date("m") . "/" . date("d") . "/")) {
                        Storage::disk('public')->makeDirectory('employees/' . date('Y') . "/" . date("m") . "/" . date("d") . "/");
                    }
                    
                    Image::make($file)->resize(512, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/employees/' . $name));
                    
                    
                    
                    $item->profile_pic = $name;
               
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
                    'id' => 'required|exists:employees,id',
                        ]
        );
        if ($validator->fails()) {
            return back()->with('error', $this->failedValidation($validator));
            ;
        }
if(\App\Models\CategoryEmployee::where('emp_id' ,$input['id'])->count() ==0 ) {
        $item = \App\Models\Employee::find($input["id"]);
        
        $item->delete();
}else{
     return back()->with('message', "Professional account can not be deleted , it has services under it");
}

        return \Illuminate\Support\Facades\Redirect::to('admin/professionals')
                ->with('message', "Deleted succesfully");
        ;
    }

}
