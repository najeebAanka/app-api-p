<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AddressController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->formResponse("Ok", \App\Models\Address::where('user_id', Auth::user()->id)->get(), Response::HTTP_OK);
    }

    public function storeInternal(Request $request , $user) {
        //
        $validator = Validator::make($request->all(), [
                    'country' => 'required',
                    'address1' => 'required',
                    'latitude' => 'required',
                    'longitude' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->formResponse("Validation error", $this->failedValidation($validator), Response::HTTP_BAD_REQUEST);
        }
        $address = new \App\Models\Address();
        $address->country = $request->country;
        $address->address1 = $request->address1;
        $address->lat = $request->latitude;
        $address->lng = $request->longitude;
        $address->user_id = $user->id;
        $address->save();
        
         $update = new \App\Models\ActivityTracker();
        $update->contents =   $user->name." Added a new address at  ". $address->address1 ;
        $update->save();
        
        return $this->formResponse("Created", null, Response::HTTP_CREATED);
    }
    public function store(Request $request) {
        //
       return $this->storeInternal($request, Auth::user());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $edited = false;
        $address = \App\Models\Address::find($id);
        if ($address) {
            if ($request->has('country')) {
                $address->country = $request->country;
                $edited = true;
            }
            if ($request->has('address1')) {
                $address->address1 = $request->address1;
                $edited = true;
            }
            if ($request->has('address2')) {
                $address->address2 = $request->address2;
                $edited = true;
            }
            if ($request->has('longitude')) {
                $address->lng = $request->longitude;
                $edited = true;
            }
            if ($request->has('latitude')) {
                $address->lat = $request->latitude;
                $edited = true;
            }
            if ($edited === true)
                $address->save();
            return $this->formResponse($edited === true ? "Updated" : "No changes.", null, Response::HTTP_OK);
        } else {
            return $this->formResponse("Not found", null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $data = \App\Models\Address::find($id);
        $data->delete();
           return $this->formResponse("Deleted", null, Response::HTTP_OK);
    }

}
