<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends \App\Http\Controllers\Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $errors = [];

    public function index(Request $request) { // get all categories .. 
        //
        $lang = $this->getLangCode();
        $data = \App\Models\Category::select('id', 'title_' . $lang . ' as name', 'description_' . $lang . ' as description', 'icon');
        if ($request->has('parent')) {
            $data = $data->where('parent_id', $request->get('parent'));
        }
        if ($request->has('filter') && $request->get('filter') == 'home') {
            $cats = \App\Models\Service::select(['category_id'])->groupBy('category_id')->get();
            $list = [];
            foreach ($cats as $c)
                $list[] = $c->category_id;
            $data = $data->whereIn('id', $list);
        }
        $data = $data->get();

        foreach ($data as $d) {
            $d->icon = $d->buildIcon();
            $d->has_sub_categories = \App\Models\Category::where('parent_id', $d->id)->count() > 0;
            $d->has_services = \App\Models\Service::where('category_id', $d->id)->count() > 0;
            $d->has_frequency = $d->has_frequency();
            $d->has_extra_params = \App\Models\Parameter::where('category_id', $d->id)->count() > 0;
        }


        return $this->formResponse("ok", $data, Response::HTTP_OK);
    }

    function haversineGreatCircleDistance(
            $latitudeFrom, $longitudeFrom, $latitudeTo = 25.101693822292894, $longitudeTo = 55.17379361102811, $earthRadius = 6371000) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    public function calculate_price_internal(Request $request) {

        $lang = $this->getLangCode();
        $info = "";
        $category = \App\Models\Category::find($request->category);
        $info .= "<p><b>" . __('web.service') . " : </b> " . $category['title_' . $lang] . " <i style='color : red'>5% Discount !</i></p>";
        $category_price = $category->base_price;
        $price = $category_price;
        if ($request->location_value) {
            if (!$request->location_type || !in_array($request->location_type, ["full", "address_id"])) {
                $this->errors[] = "Location type is not provided or invalid , should be either 'full' or 'address_id' ";
            }
            $lat = -1;
            $lng = -1;
            if ($request->location_type == "address_id") {

                if (\App\Models\Address::find($request->location_value)->count() > 0) {
                    $address = \App\Models\Address::find($request->location_value);

                    $lat = $address->lat;
                    $lng = $address->lng;
                } else {
                    $this->errors[] = "This address id is not valid";
                }
            }
            if ($request->location_type == "full") {

                if (!$request->location_value["lat"]) {
                    $this->errors[] = "Location lATITUDE is not set";
                }
                if (!$request->location_value["lng"]) {
                    $this->errors[] = "Location Longitude is not set";
                }
                $lat = $request->location_value["lat"];
                $lng = $request->location_value["lng"];
            }
            if ($lng > 0 && $lat > 0) {
                $distance = $this->haversineGreatCircleDistance($lat,
                                $lng) / 1000;

                $info .= "<p><b>" . __('web.distance') . " : </b> " . number_format($distance, 2) . " KM" . "</p>";
                ;

                $distance_factor = $distance / 100 * $category_price;
                $price += $distance_factor;
            }
        }



        if ($request->services) {
            foreach ($request->services as $s) {

                if (!isset($s["id"])) {
                    $this->errors[] = "Service ID is not provided";
                }
                if (!isset($s["value"])) {
                    $this->errors[] = "Service quantity is not provided";
                }
                $service = \App\Models\Service::find($s["id"]);
                if (!$service) {
                    $this->errors[] = "Service is invalid";
                }
                $quantity = (int) $s["value"];
                if ($quantity > $service->max_quantity) {
                    $this->errors[] = "Maximum quantity exceeded from service " . $service->title_en;
                }

                $info .= "<p><b>" . __('web.task') . " : </b> " . $service['title_' . $lang] . " (" . $quantity . ")" . "</p>";
                $sp = $service->new_price;
                $price += $sp * $s["value"];
            }
        }

        if ($request->parameters) {
            foreach ($request->parameters as $s) {

                if (!isset($s["id"])) {
                    $this->errors[] = "Parameter ID is not provided";
                }
            
                $service = \App\Models\Parameter::find($s["id"]);

                if (!$service) {
                    $this->errors[] = "Parameter is invalid";
                }

                if (\App\Models\ParameterOption::where('param_id', $s["id"])->count() > 0) {
                    
                        if (!isset($s["value"])) {
                    $this->errors[] = "Parameter value is not provided";
                }

                    
                    $option = \App\Models\ParameterOption::find($s["value"]);
                    if (!$option) {
                        $this->errors[] = "Parameter option is invalid";
                    }

                    $sp = $option->added_price;
                    $price += $sp;
                    $info .= "<p><b>" . $service['title_' . $lang] . "</b> " . $option['title_' . $lang] . "</p>";
                } else {
                    $info .= "<p><b>" . $service['title_' . $lang] . "</b> " . $s["value"] . "</p>";
                }
            }
        }

        if (count($this->errors) == 0) {
            $obj = new \stdClass();
            $obj->price = number_format($price, 2);
            $obj->vat = number_format($price * 0.05, 2);
            $obj->total = number_format($obj->vat + $obj->price, 2);

            $obj->details = $info;

            $obj->currency = $this->getCurrencyName();
            return $obj;
        } else {
            return null;
        }
    }

    public function calculate_price(Request $request) {

        // $data   = json_encode($request);
        if (!$request->category) {
            return $this->formResponse("Category is not set", null, Response::HTTP_BAD_REQUEST);
        }
        $price = $this->calculate_price_internal($request);

        if ($price)
            return $this->formResponse("ok", $price, Response::HTTP_OK);
        else
            return $this->formResponse("You have an error in your request", $this->errors, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }



    public function show($id) {
        //
        $lang = $this->getLangCode();
        $category = \App\Models\Category::select('id', 'title_' . $lang . ' as name', 'description_' . $lang . ' as description', 'icon')->find($id);
        if ($category) {
            $category->icon = $category->buildIcon();
            $category->services = \App\Models\Service::select('id', 'title_' . $lang . ' as name',
                            'description_' . $lang . ' as description', 'media_url'
                            , 'old_price', 'new_price', 'max_quantity')->where('category_id', $id)->get();

            foreach ($category->services as $d) {
                $d->media_url = $d->buildIcon();
                $d->currency = $this->getCurrencyName();
            }
            $category->fequency_options = \App\Models\FrequencyOption::select('id', 'title_' . $lang . ' as name', 'description_' . $lang . ' as description')
                            ->where('category_id', $id)->get();
            $category->has_professionals = \App\Models\CategoryEmployee::where('cat_id', $id)->count() > 0;
            $category->params = \App\Models\Parameter::select(['id', 'title_' . $lang . ' as name', 'description_' . $lang . ' as description'])
                            ->where('category_id', $id)->get();

            foreach ($category->params as $par) {
                $par->options = \App\Models\ParameterOption::where('param_id', $par->id)->select(['id', 'title_' . $lang . ' as name'])->get();
            }
            return $this->formResponse("ok", $category, Response::HTTP_OK);
        } else {
            return $this->formResponse("Resource not found", null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
