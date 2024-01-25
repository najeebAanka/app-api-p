<!DOCTYPE html>
<html lang="en">
    <?php
    $selects = ' bookings.id  ,bookings.requested_date  ,bookings.reply  ,bookings.updated_at ,bookings.selected_professional '
            . ' ,bookings.frequency_type ,bookings.grand_total ,bookings.vat ,bookings.subtotal,bookings.created_at ,'
            . ' bookings.status ,users.name  , users.phone '
            . ' , users.email, addresses.country ,addresses.lat , addresses.lng ,addresses.address2  '
            . ',addresses.address1 ,categories.title_en,categories.id as cat_id , bookings.grand_total';

    $sql = 'SELECT ' . $selects . ' , if(bookings.status'
            . '  = "pending", 1, 0) AS is_pending from bookings'
            . ' join users on users.id = bookings.user_id join addresses on'
            . ' bookings.address_id = addresses.id join booking_services on '
            . 'booking_services.booking_id=bookings.id join services on '
            . 'services.id=booking_services.service_id join categories '
            . 'on categories.id=services.category_id  where bookings.id = :id  ';
    // die($sql);
    $bookings = DB::select($sql, ['id' => Route::input('id')]);
    $booking = $bookings[0];
    ?>
    @include('dashboard.shared/header-css')
    <!-- Plugins css start-->

    <style>
        .in-m{
            border-radius: 5px;
            border: none;
            margin: 2px;
            width: 8rem;
        }
        input[type='checkbox'] {
            -webkit-appearance:none;
            width:30px;
            height:30px;
            background:white;
            cursor: pointer;
            border:2px solid #24695c;
        }
        input[type='checkbox']:checked {
            background: #24695c;
        }
        .day-1-bg{
            background-color: #ccccff
        }
        .day-2-bg{
            background-color: #ffccff
        }
        .day-3-bg{
            background-color: #ffcccc
        }
        .day-4-bg{
            background-color: #ffffcc
        }
        .day-5-bg{
            background-color: #ccffcc
        }
        .day-6-bg{
            background-color: #fff2e0
        }
        .day-7-bg{
            background-color: #f0f0f0
        }

    </style>
    <body >



        <!-- Loader starts-->
        <div class="loader-wrapper">
            <div class="theme-loader">    
                <div class="loader-p"></div>
            </div>
        </div>
        <!-- Loader ends-->
        <!-- page-wrapper Start-->
        <div class="page-wrapper" id="pageWrapper">
            @include('dashboard.shared/top-bar')                 
            <!-- Page Body Start-->
            <div class="page-body-wrapper horizontal-menu">
                @include('dashboard.shared/side-bar')  
                <div class="page-body">
                    <div class="container-fluid">
                        <div class="page-header">

                            @include('dashboard.shared/message-header')      

                        </div>
                    </div>





                    <!-- Container-fluid starts-->
                    <div class="container-fluid ">

                        <div class="row">
                            <div class="col-md-4 col-sm-6" >
                                <h4>Client information</h4>
                                <p>Some contact details</p>
                                <table class="table table-bordered " style="background-color: #fff">
                                    <tr><th>Booking No#</th><td>{{$booking->id}}</td></tr>    
                                    <tr style="    background-color: #feffd8;"><th>Desired date</th><td>{{$booking->requested_date}}</td></tr>    
                                    <tr><th>Status</th><td>{{$booking->status}}</td></tr>    
                                    <tr><th>Client name</th><td>{{$booking->name}}</td></tr>    
                                    <tr><th>Client email</th><td>{{$booking->email}}</td></tr>    
                                    <tr><th>Client phone</th><td>{{$booking->phone}}</td></tr>    
                                    <tr style="    background-color: #cef0ff;"><th>Client address</th><td>{{$booking->address1}}<br />{{$booking->address2}}<br />{{$booking->country}}</td></tr>    
                                    <tr><th>Sent</th><td>{{time_elapsed_string($booking->created_at)}}</td></tr>    



                                </table>       


                                <?php
                                $prof_name = "Auto assign";
                                if (\App\Models\CategoryEmployee::where('cat_id', $booking->cat_id)->count() > 0) {
                                    ?>   
                                    <hr />

                                    <h5>Requested professional</h5>
                                    <hr />
                                    <?php if ($booking->selected_professional == -1) { ?>

                                        <p>Auto assign</p>

    <?php
    } else {
        $item = App\Models\Employee::find($booking->selected_professional);
        $prof_name = $item->name;
        ?>

                                        <div class="single-card-square" style="margin: 0">
                                            <img style="    max-width: 100px;;
                                                 border-radius: 1rem;" src="{{$item->buildIcon()}}" />
                                            <p>{{$item->name}}</p></a>
                                        </div>

                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="col-md-4 col-sm-12" >

                                <?php if (\App\Models\Service::where('category_id', $booking->cat_id)->count() > 0) { ?>   
                                    <h4>Requested services</h4>
                                    <p>{{$booking->title_en}}</p>
                                    <?php
                                    foreach (App\Models\BookingService::where('booking_id', $booking->id)->get() as $sr) {
                                        $item = \App\Models\Service::find($sr->service_id);
                                        ?>
                                        <div class="prof-row"> 
                                            <img src='{{$item ->buildIcon()}}' style="max-width: 60px;" />
                                            <p class="name">{{$item ->title_en}}</p>
                                            <p>Requested quantity : <span style="    font-weight: bold;
                                                                          padding: 0rem 1rem;
                                                                          background-color: #ededed;
                                                                          border-radius: 1rem;"> {{$sr->quantity}} / {{$item ->max_quantity}}  </span></p>
                                        </div>     
                                    <?php } ?>
                                <?php } ?>

                                <?php if (\App\Models\Parameter::where('category_id', $booking->cat_id)->count() > 0) { ?>   
                                    <hr />

                                    <h4>Extra notes</h4>
                                    <p>Some extra notes dent by client</p>
                                    <?php
                                    foreach (App\Models\BookingParam::where('booking_id', $booking->id)->get() as $sr) {
                                        $item = \App\Models\Parameter::find($sr->param_id);
                                        ?>

                                        <div class="prof-row"> 
                                            <h5 style="color: #707070;font-style: italic">{{$item ->title_en}}</h5>
                                            <p class="name">{{$item ->description_en}}</p>

                                            <p style="color: #24695c"><b>
                                                    <?php if (App\Models\ParameterOption::where('param_id', $item->id)->count() == 0) { ?>
                                                        {{$sr->param_val}}
                                                    <?php } else { ?>   
                                                        <?= App\Models\ParameterOption::find($sr->param_val)->title_en ?>
                                                    <?php } ?>
                                                </b></p>



                                        </div>     


                                    <?php } ?>
                                <?php } ?>

                                <hr />
                                <table class="table table-bordered " style="background-color: #fff">
                                    <tr><th>Subtotal</th><td>{{$booking->subtotal}}</td></tr>    
                                    <tr><th>VAT</th><td>{{$booking->vat}}</td></tr>    
                                    <tr><th>Grand total</th><td>{{$booking->grand_total}}</td></tr>    
                                </table>    


                            </div>         

                            <div class="col-md-4 col-sm-6" >
                                <span style="float: right;padding: 1rem;font-weight: bold" class="{{$booking->status}}">{{strtoupper($booking->status)}}</span>
                                <h4>Client location</h4>
                                <p>{{$booking->address1}}</p>

                                <div style="width : 100%;height: 30rem" id="map"></div>
                                <p  style="background: #fff;
    padding: 1rem;
    margin-top: 1rem;" id="map-location"></p>



                                <form method="post" action="{{url('backend/bookings/alter')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$booking->id}}" />
                                    <div class="prof-row"  style="margin-top: 1rem;position: static">
                                        <b>Reply to user  </b> 


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <textarea name="reply" class="form-control mt-4" rows="3" placeholder="Your reply">{{$booking->reply}}</textarea>   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Current status</label>
                                                    <select class="form-control" name="status" >

                                                        <option {{$booking->status == 'pending' ? "selected":""}} value="pending" >Pending</option>
                                                        <option {{$booking->status == 'completed' ? "selected":""}} value="completed" >Completed</option>
                                                        <option {{$booking->status == 'approved' ? "selected":""}} value="approved" >Approved</option>
                                                        <option {{$booking->status == 'rejected' ? "selected":""}} value="rejected" >Rejected</option>
                                                        <option {{$booking->status == 'archived' ? "selected":""}} value="archived" >Archived</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <button class="btn btn-success m-10" style="width: 200px;">Change status</button>
                                            <p class="time-elapsed">Last updated : {{$booking->updated_at?
                                                time_elapsed_string($booking->updated_at) : "Never"}}

                                            </p>


                                        </div>  




                                </form>
 </div>





                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                </div>


            </div>



            <!-- footer start-->
            @include('dashboard.shared/footer')    
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAV8VEG1RLclapyZ92xOujbsX1lRnIksdc"></script>
        <script>


 function displayLocation(latitude,longitude){
        var request = new XMLHttpRequest();

        var method = 'GET';
        var url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+latitude+','+longitude+'&sensor=true&key=AIzaSyAV8VEG1RLclapyZ92xOujbsX1lRnIksdc';
        var async = true;

        request.open(method, url, async);
        request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
             
            var data = JSON.parse(request.responseText);
            var address = data.results[0];
           $('#map-location').html(address.formatted_address);
          }
        };
        request.send();
      };


function initMap() {
var coordinates = {
lat: {{$booking->lat}},
        lng: {{$booking->lng}}
};
var map = new google.maps.Map(document.getElementById('map'), {
zoom: 16,
        center: coordinates,
        scrollwheel: true
});
var measle = new google.maps.Marker({
position: coordinates,
        map: map,
        icon: {
        url: "https://maps.gstatic.com/intl/en_us/mapfiles/markers2/measle.png",
                size: new google.maps.Size(7, 7),
                anchor: new google.maps.Point(3.8, 3.8)
        }
});
var marker = new google.maps.Marker({
position: coordinates,
        map: map,
        icon: {
        url: "{{url('dist/assets/img')}}/red-dot.png",
                labelOrigin: new google.maps.Point(120, 94),
                size: new google.maps.Size(64, 64),
                anchor: new google.maps.Point(32, 64)
        },
        label: {
        text: '  {{$booking->address1}}-{{$booking->address2}}-{{$booking->country}} ',
                fontSize: "16px",
                className: "map-label"
        }
});

displayLocation(coordinates.lat ,coordinates.lng);

}
google.maps.event.addDomListener(window, "load", initMap);


        </script>


        <!-- Plugins JS Ends-->
    </body>
</html>