<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class BookingController extends \App\Http\Controllers\Controller {

    private $type = "Unknown";
    private $errors = [];

    function validateCard($number) {


        $cardtype = array(
            "visa" => "/^4[0-9]{12}(?:[0-9]{3})?$/",
            "mastercard" => "/^5[1-5][0-9]{14}$/",
            "amex" => "/^3[47][0-9]{13}$/",
            "discover" => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
            "american_express" => "/^3[47]\d{13,14}$/",
        );
        if (preg_match($cardtype['american_express'], $number)) {
            $this->type = "American Express";
            return true;
        }
        if (preg_match($cardtype['visa'], $number)) {
            $this->type = "VISA";
            return true;
        } else if (preg_match($cardtype['mastercard'], $number)) {
            $this->type = "Master Card";
            return true;
        } else if (preg_match($cardtype['amex'], $number)) {
            $this->type = "AMEX";
            return true;
        } else if (preg_match($cardtype['discover'], $number)) {
            $this->type = "Discover";
            return true;
        } else {
            return false;
        }
    }

    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateRequest(Request $request) {
     
       $response = true;
       $this->errors = [];
        if (!$request->category) {
            $response = false;
            $this->errors[]="Category ID is not set";
        }
        $category = \App\Models\Category::find($request->category);

        if (!$category) {
            $response = false;
            $this->errors[]="Category is not valid";
        }

  if ($request->professionals_count) {
      
      if($request->professionals_count == 1){
      if (!$request->professional_id) {
           $response = false;
            $this->errors[]="Professional id is not set !";
      }else{ 
      
         $prof = \App\Models\Employee::find($request->professional_id);
         if(!$prof){
          $response = false;
            $this->errors[]="Professional is not set or wrong value provided";
         }else{
            if(\App\Models\CategoryEmployee::where('cat_id' ,$category->id)->where('emp_id' ,$prof->id)->count() == 0){
                 $response = false;
            $this->errors[]="This professional does not provide this service";  
            }   
         }
      }
      }
  }

        if ($request->location_value) {

            if (!$request->location_type || !in_array($request->location_type, ["full", "address_id"])) {
                $response = false;
            $this->errors[]="Location type should be eiather full or address_id";
            }

            if ($request->location_type == "address_id") {

                if (!\App\Models\Address::find($request->location_value)) {
                     $response = false;
            $this->errors[]="Address was not found ";
                } 
            }

            if ($request->location_type == "full") {

                if (!isset($request->location_value["lat"])) {
                   $response = false;
            $this->errors[]="Latitude is not set";
                }
                 if (!isset($request->location_value["address1"])) {
                   $response = false;
            $this->errors[]="Address 1 is not set";
                }
                 if (!isset($request->location_value["address2"])) {
                   $response = false;
            $this->errors[]="Address 2 is not set";
                }
                if (!isset($request->location_value["lng"])) {
                     $response = false;
            $this->errors[]="Longitude is not set";
                }
            }
        } else {
            $response = false;
            $this->errors[]="Location value is not set";
        }



        if ($request->services) {
            foreach ($request->services as $s) {

                if (!isset($s["id"])) {
                   $response = false;
            $this->errors[]="Service ID is not set";
                }
                if (!isset($s["value"])) {
                     $response = false;
            $this->errors[]="Service valude is not set";
                }
                $service = \App\Models\Service::find($s["id"]);
                if (!$service) {
                 $response = false;
            $this->errors[]="Service was not found";
                }else{
                $quantity = (int) $s["value"];
                if ($quantity > $service->max_quantity) {
                     $response = false;
            $this->errors[]="Maximum quantity exceeded for a service";
                }
                }
            }
        }

        if ($request->parameters) {
            foreach ($request->parameters as $s) {

                if (!isset($s["id"])) {
                    $response = false;
            $this->errors[]="Parameter ID is not set";
                }
                if (!isset($s["value"])) {
                     $response = false;
            $this->errors[]="Parameter value is not set";
                }

                $service = \App\Models\Parameter::find($s["id"]);

                if (!$service) {
                     $response = false;
            $this->errors[]="Parameter was not found";
                }

                if (\App\Models\ParameterOption::where('param_id', $s["id"])->count() > 0) {
                    $option = \App\Models\ParameterOption::find($s["value"]);
                    if (!$option) {
                       $response = false;
            $this->errors[]="Option id is not found";
                    }
                }
            }
        }
        
        
            if (!$request->payment) {
         $response = false;
            $this->errors[]="Payment is not set";
        }
        if (!$request->payment["card_no"]) {
             $response = false;
            $this->errors[]="Card number is not set";
        }
        if (!$this->validateCard($request->payment["card_no"])) {
          $response = false;
            $this->errors[]="Card number is not valid or unknown";
        }
        
            if (!$request->date) {
           $response = false;
            $this->errors[]="Date is not set";
        }
        if (!$this->validateDate($request->date)) {
         $response = false;
            $this->errors[]="Date format is invalid";
        }


            if ($category->has_frequency()) {
            if (!$request->frequency_id) {
            $response = false;
            $this->errors[]="Service frequency is not set";
            }
            $f = \App\Models\FrequencyOption::find($request->frequency_id);
            if (!$f) {
             $response = false;
            $this->errors[]="Service frequency option is not valid";
            }
          
        }
        
        return $response;
    }

    function book(Request $request) {
       // die("ok");
        $lang = $this->getLangCode();
        if (!$this->validateRequest($request)) {
            return $this->formResponse("Something wrong with your request !", $this->errors, Response::HTTP_BAD_REQUEST);
        }
        $category = \App\Models\Category::find($request->category);
        $controller = new CategoryController();
        $object = $controller->calculate_price_internal($request);
        $address_id = -1;
        $user =  \Illuminate\Support\Facades\Auth::user();
        if ($request->location_type == 'full') {
            $address = new \App\Models\Address();
            $address->country = "United Arab Emirates"; 
                    //$request->location_value["country"];
            $address->address1 = $request->location_value["address1"];
            $address->address2 = $request->location_value["address2"];
            $address->lat = $request->location_value["lat"];
            $address->lng = $request->location_value["lng"];
            $address->user_id =  $user ->id;
            $address->save();
            $address_id = $address->id;
        }
        if ($request->location_type == 'address_id') {
                $address_id = $request->location_value;
        }


        $booking = new \App\Models\Booking();
        $booking->user_id =   $user ->id;
        $booking->requested_date = $request->date;
        $booking->address_id = $address_id;

        $booking->subtotal = $object->price;
        $booking->vat = $object->vat;
        $booking->grand_total = $object->total;
        if ($category->has_frequency()) {
            $f = \App\Models\FrequencyOption::find($request->frequency_id);
            $booking->frequency_type = $request->frequency_id;
        }
        
          if ($request->professional_id) {
          $booking->selected_professional =    $request->professional_id;
          }
        
        
       $booking->save();
       $booking_id = $booking->id;
       
        if ($request->services) {
            foreach ($request->services as $s){
               
               $b = new \App\Models\BookingService();
               $b->booking_id = $booking_id;
               $b->service_id = $s["id"];
               $b->quantity = $s["value"];
               $b->save();
            }
            
            
        } 
         if ($request->parameters) {
            foreach ($request->parameters as $s){
               
               $b = new \App\Models\BookingParam();
               $b->booking_id = $booking_id;
               $b->param_id = $s["id"];
               $b->param_val = $s["value"];
               $b->save();
            }
            
            
        } 



        $order = new \stdClass();

        $order->order_no =  $booking_id ;
        $order->payment_type = $this->type;
        $order->order_date = date('d-m-Y');
        $order->total = $object->total;
        
        
        
        $update = new \App\Models\ActivityTracker();
        $update->target_id =   $booking->id;
        $update->target_type = \App\Models\ActivityTracker::TARGET_BOOKING;
        $update->contents =   $user->name." sent a request for ".$category->title_en;
        $update->save();
        
      
        //uncomment when in production
         if(\App\Helpers\Environment::TEST_MODE == false){
               $emailController = new \App\Http\Controllers\Emails\EmailsController();
        $emailController->sendBookingSubmittedEmail($booking_id);
         }

        return $this->formResponse("Booked succesfully", $order, Response::HTTP_OK);
    }

}
