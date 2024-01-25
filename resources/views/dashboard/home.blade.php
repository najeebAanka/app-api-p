<?php
$page_title = "Admin | Home";
?>
<!DOCTYPE html>
<html lang="en">
    @include('dashboard.shared/header-css')

    <body>
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
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="card">
                                
                                    <div class="card-body">


                                        <div class="row">
                                            <div class="col-md-5 col-sm-12">
                                                <button style="float: right" class="btn btn-light"]
                                                        onclick="getNotifications(this)"><i class="fa fa-refresh"></i></button>
                                                <h5 style="margin: 1rem">Welcome to test Dashboard</h5>  
                                                <hr />
                                                <div class="row" id="updates-container">
                                                    <p id="wai" style="    padding: 2rem;
                                                       color: #ccc;
                                                       font-size: 2rem;">No updates</p>
                                                    <p style="    padding: 2rem;
                                                       color: #000;
                                                       ">test is live , ready to receive requests. You will receive all latest notifications right away!.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                
                                                <div class="row">
                                                    <div class="col-12">

                                                        <div style="width : 100%;height: 36rem" id="map"></div>

                                                    </div>
                                                    <?php
                                                    $list = DB::select("SELECT count(*) as total , categories.id from bookings join"
                                                                    . " booking_services on booking_services.booking_id=bookings.id "
                                                                    . "join services "
                                                                    . "on services.id=booking_services.service_id join categories on "
                                                                    . "services.category_id=categories.id WHERE status='pending'  "
                                                                    . "group by categories.id limit 0,9");

                                                    foreach ($list as $ls) {
                                                        $item = \App\Models\Category::find($ls->id)
                                                        ?>

                                                        <div class="col-xl-6 col-xxl-4  col-lg-12 col-md-12 col-sm-12 mt-3">




                                                            <div class="" style="height: auto">

                                                                <a href="{{url('admin/booking-requests?category='.$ls->id)}}">  

                                                                    <p style="background-color: #f7ffee;
                                                                       color: green;
                                                                       padding: 1rem;
                                                                       border-radius: 1rem;">

                                                                        <img
                                                                            style="width: 50px;float: right"
                                                                            src="{{$item->buildIcon()}}" />
                                                                        <b>{{$item->title_en}}</b><br />

                                                                        <span class="animated-p">{{$ls->total}} Pending requests</span></p>
                                                                </a>
                                                                <div>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <?php
                                                    }

                                                    if (count($list) == 0) {
                                                        ?>
                                                        <p style="    padding: 2rem;
                                                           color: #ccc;
                                                           font-size: 2rem;">No requests currently</p>

                                                    <?php } ?>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                </div>
                <!-- footer start-->
                @include('dashboard.shared/footer')    
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAV8VEG1RLclapyZ92xOujbsX1lRnIksdc"></script>
                <script>

                                                            var latests = <?php
                                                    $latest = DB::select("SELECT addresses.lat ,addresses.lng ,bookings.id,bookings.requested_date ,"
                                                                    . " employees.name as label from addresses join bookings on "
                                                                    . "bookings.address_id=addresses.id join employees on "
                                                                    . "employees.id=bookings.selected_professional where bookings.status = "
                                                                    . "'approved' GROUP by id , lat ,lng ,label ,requested_date order by bookings.id desc limit 0 ,10");
                                                    $arr = [];
                                                    foreach ($latest as $la) {
                                                        $t = new stdClass();
                                                        $t->lat =floatval($la->lat);
                                                        $t->lng = floatval($la->lng);
                                                        $t->label = $la->label;
                                                        $t->id = $la->id;
                                                        $t->requested_date = $la->requested_date;
                                                        $arr[] = $la;
                                                    }
                                                    echo json_encode($arr);
                                                    ;
                                                    ?>;


                                                            loading = 0;


                                                            function _f() {

                                                                if (loading == 1)
                                                                    return;
                                                                loading = 1;
                                                                _http("GET", "{{ url('api/v1/admin/admin-notifications') }}", [], function (res) {
                                                                loading = 0; // loading is zero  --> 
                                                                        var data = JSON.parse(res).data;
                                                                        var updates = data.updates;
                                                                        var all = "";
                                                                        var alarm = false;
                                                                        for (var i = 0; i < updates.length; i++) {
                                                                var rec = updates[i];
                                                                        all += ' <div class="mt-3 ' + (rec.alarm ? "animated-p" : "") + 
                                                                                ' col-md-12 col-xl-12 col-lg-12 col-sm-12  "  >\n\
                                                                                 <div class="notification-box ' + (rec.alarm ? "green-light-bg" : "") + '" onclick="handleClick(' + rec.target_type + ' ,' + rec.target_id + ')"> <p >' + rec.contents + '<br/> <i >' + rec.time + '</i> </p></div></div>';
                                                                        alarm |= rec.alarm;
                                                                }
                                                                if (alarm){
                                                                playSound('{{url('dist/assets/audio/t.ogg')}}');
                                                                }
                                                                document.getElementById('updates-container').innerHTML = (all == "" ? "<p>No updates</p>" : all);
                                                                });
                                                                }
                                                                ;
                                                                function getNotifications(c) {
                                                                    c.style.display = 'none';
                                                                    document.getElementById('wai').innerHTML = 'Loading... ';
                                                                    setInterval(() => {
                                                                        _f();
                                                                    }, 6000);

                                                                }

                                                                function handleClick(t, i) {
                                                                    if (t == <?= App\Models\ActivityTracker::TARGET_BOOKING ?>){
                                                                    window.open('{{url('admin/single-booking')}}/' + i, '_blank').focus();
                                                                }

                                                            }

                                                            var map;

                                                            function initMap() {
                                                                var coordinates = {
                                                                    lat: 25.2048,
                                                                    lng: 55.2708
                                                                };
                                                                map = new google.maps.Map(document.getElementById('map'), {
                                                                    zoom: 9,
                                                                    center: coordinates,
                                                                    scrollwheel: true
                                                                });


                                                                for (var i = 0; i < latests.length; i++) {
                                                                    addMarker(parseFloat(latests[i].lat), parseFloat(latests[i].lng), latests[i].label ,latests[i].id
                    ,latests[i].requested_date                                                        
                    );
                                                                }

                                                            }

                                                            google.maps.event.addDomListener(window, "load", initMap);


                                                            function addMarker(lati, long, label_name ,id ,date) {

                                                                var marker = new google.maps.Marker({
                                                                    position: {
                                                                        lat: lati,
                                                                        lng: long
                                                                    },
                                                                    map: map,
                                                                    icon: {
                                                                        url: "{{url('dist/assets/img')}}/red-dot.png",
                                                                        labelOrigin: new google.maps.Point(160, -10),
                                                                        size: new google.maps.Size(64, 64),
                                                                        anchor: new google.maps.Point(32, 64) ,
                                                                     
                                                                    },
                                                                    label: {
                                                                        text: label_name + " ("+date+")",
                                                                        fontSize: "12px",
                                                                        className: "map-label"
                                                                    }
                                                                });
                                                                
                                                                  marker.addListener('click', function() {
        window.open('{{url('admin/single-booking')}}/' + id, '_blank').focus();
    });

                                                            }


                </script>
                </body>
                </html>