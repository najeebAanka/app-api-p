<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends \App\Http\Controllers\Controller {

    function checkOtp(Request $request) {
        $validator = Validator::make($request->all(), [
                    'phone' => 'required',
                    'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->formResponse("Validation error", $this->failedValidation($validator), 400);
        }

        if (\App\Models\PhoneVerification::where('phone', '=', $request->phone)->where('status', '1')->
                        whereBetween('created_at', [now()->subMinutes(5), now()])->count() > 0) {


            $user = User::where('phone', $request->phone)->first();
            if (!$user)
                return $this->formResponse("Phone is verified , no account yet , please create an account !",
                                null, Response::HTTP_PARTIAL_CONTENT);
            else {

                \Illuminate\Support\Facades\Auth::login($user);
                $accessToken = auth()->user()->createToken('authToken')->accessToken;
                $user->token = $accessToken;

                return $this->formResponse("Phone is verified , we have an account !",
                                $user, Response::HTTP_PARTIAL_CONTENT);
            }
        }
        if (\App\Models\PhoneVerification::where('phone', '=', $request->phone)->
                        whereBetween('created_at', [now()->subMinutes(5), now()])
                        ->where('status', '-1')->count() == 0) {
            return $this->formResponse("Phone verification requests was not found !", null, Response::HTTP_BAD_REQUEST);
        }

        $p = \App\Models\PhoneVerification::where('phone', '=', $request->phone)->where('status', '-1')->latest()->first();

        if ($p->code == $request->otp) {
            $p->status = 1;
            $p->save();

            $user = User::where('phone', $p->phone)->first();
            if (!$user)
                return $this->formResponse("Phone is verified ,"
                        . " no account yet , "
                        . "please create an account !",
                                null, Response::HTTP_PARTIAL_CONTENT);
            else {
                \Illuminate\Support\Facades\Auth::login($user);
                
                $accessToken = auth()->user()->createToken('authToken')->accessToken;
                $user->token = $accessToken;
                return $this->formResponse("Phone is verified , we have an account !",
                                $user, Response::HTTP_PARTIAL_CONTENT);
            }
        } else {
            return $this->formResponse("Code is not correct !", null, Response::HTTP_UNAUTHORIZED);
        }
    }

    function createAccount(Request $request) {
        $validator = Validator::make($request->all(), [
                    'phone' => 'required|unique:users,phone',
                    'email' => 'required|unique:users,email',
                    'name' => 'required',
                    'gender' => 'required|in:male,female',
                    'address1' => 'required',
                    'latitude' => 'required',
                    'longitude' => 'required',
                    'city' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->formResponse("Validation error", $this->failedValidation($validator), 400);
        }
        $p = \App\Models\PhoneVerification::where('phone', '=', $request->phone)->where('status', '1')
                        ->
                        whereBetween('created_at', [now()->subMinutes(5), now()])->latest()->first();
        if (!$p) {
            return $this->formResponse("Validation error", "Phone number is not verified ! , Verify your phone and come back later", 400);
        }


        if (User::where('email', '=', $request->phone)->exists()) {
            return $this->formResponse("Unauthorized , Email is already in use ", null, 400);
        }
        if (User::where('phone', '=', $request->phone)->exists()) {
            return $this->formResponse("Unauthorized , Phone is already in use ", null, 400);
        }
        $u = new User();
        $u->phone = $request->phone;
        $u->email = $request->email;
        $u->name = $request->name;
        $u->password = bcrypt($request->phone);
        $u->gender = $request->gender;
        if ($request->has('birthdate')) {
            $u->birthdate = $request->birthdate;
        }
        $u->save();
        \Illuminate\Support\Facades\Auth::login($u);
        $user = User::find($u->id);
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $user->token = $accessToken;
        $controller = new AddressController();
        $controller->storeInternal($request, $u);
        
         $update = new \App\Models\ActivityTracker();
        $update->contents =   $user->name." Joined test at ".date('Y-m-d');
        $update->save();
        
        
        return $this->formResponse("ok", $user, Response::HTTP_OK);
    }

    function login(Request $request) {
        $validator = Validator::make($request->all(), [
                    'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->formResponse("Validation error", $this->failedValidation($validator), 400);
        }

        $this->sendOtp($request->phone);

        return $this->formResponse("ok", "check OTP then proceed to next stage.", Response::HTTP_OK);
    }

    private function sendOtp($phone) {


        $p = new \App\Models\PhoneVerification();
        $p->phone = $phone;
        $p->code = "00000";
        $p->status = -1;
        $p->save();
    }

    public function update(Request $request) {
        $edited = false;
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($request->has('birthdate')) {
            $user->birthdate = $request->birthdate;
            $edited = true;
        }
        if ($request->has('gender')) {
            $user->gender = $request->gender;
            $edited = true;
        }
        if ($request->has('name')) {
            $user->name = $request->name;
            $edited = true;
        }
        if ($request->has('email')) {
            if (User::where('email', $request->email)->where('id', '<>', $user->id)->count() > 0) {
                return $this->formResponse("Email is already in use", null, 400);
            }
            $user->email = $request->email;
            $edited = true;
        }

        if ($request->has('phone')) {
            if (User::where('phone', $request->phone)->where('id', '<>', $user->id)->count() > 0) {
                return $this->formResponse("Phone is already in use", null, 400);
            }
            $user->phone = $request->phone;
            $this->sendOtp($request->phone);
            return $this->formResponse("Phone changed  , OTP is sent..", null, Response::HTTP_OK);
        }
        if ($edited === true )
            $user->save();
        return $this->formResponse($edited === true ? "Updated" : "No changes.", null, Response::HTTP_OK);
    }

}
