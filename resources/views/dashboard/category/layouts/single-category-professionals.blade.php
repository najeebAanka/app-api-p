<?php
$category = \App\Models\Category::find(Route::input('id'));
if (!$category) {
    //handle 404 later
    die('not found');
}
?>
<!DOCTYPE html>
<html lang="en">
    @include('dashboard.shared/header-css')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard/assets/css/range-slider.css')}}">
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
                        <img src="{{$category->buildIcon()}}"  id="preview_edit" style="width : 60px;float: right;padding: 1rem"/>
                        <h2 style="    color: #ccc;">{{$category->title_en}} | Professionals</h2>
                        <a href="{{url('admin/category/'.$category->id)}}">Back to {{$category->title_en}}</a>
                        <hr />
                        <div class="row">

                            <div class="col-md-4" >
                                <?php
                                $all = App\Models\Employee::select(['id', 'name'])->
                                        whereNotIn('id',
                                        DB::table('category_employees')->select('emp_id')
                                        ->where('cat_id', $category->id)->get()->pluck('emp_id')
                                );

                                $all = $all->get();
                                if (count($all) > 0) {
                                    ?>
                                    <div class="card card-body">
                                        <form action="{{url('backend/employees/link')}}" method="post">
                                            <input type="hidden" name="cat_id" value="{{$category->id}}" />
                                            {{csrf_field()}}
                                            <div class="mb-3">
                                                <label class="form-label">Link a new professional to {{$category->title_en}}</label>
                                                <select class="form-control js-example-basic-single" name="emp_id">



                                                    <option selected disabled >Select a professional</option>  
                                                    <?php foreach ($all as $r) { ?>
                                                        <option value="{{$r->id}}">{{$r->name}}</option>  
                                                    <?php } ?>
                                                </select>  
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-light">Add link</button>

                                        </form> 
                                    </div>  
                                <?php } else { ?>
                                    <p style="    background: #ffe9e9;
                                       padding: 1rem;">All employees of the system are linked to this category</p>
                                   <?php } ?>
                                <p>Current linked professionals</p>
                                <div style="max-height: 45rem;overflow-y: auto">
                                    <?php
                                    foreach (\App\Models\CategoryEmployee::where('cat_id', $category->id)->get() as $cat) {

                                        $emp = \App\Models\Employee::find($cat->emp_id);
                                        ?>

                                     <div class="prof-row"> 
                                    <a href="?ref={{$cat->id}}">   <img src='{{$emp->buildIcon()}}' /></a>

                                    <a href="?ref={{$cat->id}}">    <p class="name">{{$emp->name}}</p></a>
                                    <a href="?ref={{$cat->id}}">       <p>{{$emp->department}} / <i style="color: #ccc"><?= App\Models\EmployeeTimeSlot::where('link_id' ,$cat->id)->count()?> time slots</i></p></a>
                                                
                                                
                                                 <form method="post" action="{{url('backend/employees/unlink')}}">
                                                                    <input  type="hidden" name="id" value="{{$cat->id}}" />
                                                                    {{csrf_field()}}
                                                                    <button class="btn btn-danger btn-xs" type="submit"
                                                                            onclick="return confirm('Are you sure ?')"
                                                                            >Remove</button>
                                                                    
                                                        </form>
                                                
                                            </div>     

                                    <?php } ?>            
                                </div>    
                            </div>


                            <div class="col-md-8">


                                <?php
                                if (isset($_GET['ref'])) {
                                    $link = App\Models\CategoryEmployee::find($_GET['ref']);
                                    if($link){
                                    $emp_main = App\Models\Employee::find($link->emp_id);
                                    $slots = App\Models\EmployeeTimeSlot::where('link_id', $link->id)->orderby('day_of_week')
                                            ->orderby('slot_from')->get();
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ,'Sunday'];
                                    ?>

                                    <div class="card card-body">
                                        <h5>Working time slots for {{  $emp_main->name}}</h5>
                                        <hr />
                                        <div class="card card-body">
                                    
                                                <form method="post" action="{{url('backend/employees/timeslots/add')}}">
                                                   <input type="hidden" name="link_id" value="{{$link->id}}" />
                                                   <input type="hidden" name="start_hour"  id="start_hour" value="01:00:00" />
                                                   <input type="hidden" name="end_hour" id="end_hour" value="00:00:00" />
                                            {{csrf_field()}}
                                            
                                                <div class="form-group row">
                                              
                                                    <div class="col-md-12">
                                                            <label>Select Time slot</label>
                                                        <input id="u-range-06" type="text">
                                                    </div>
                                                    
                                                   
                                                </div>
                                                <div class="form-group row">
                                              
                                                     <div class="col-md-6">
                                                         <label>Select Day</label>
                                                          <select class="form-control" name="day_of_week">
                                                            <?php for($i=1;$i<=count($days);$i++){ ?>
                                                              <option value="{{$i}}">{{$days[$i-1]}}</option> 
                                                            <?php } ?> 
                                                              
                                                          </select>
                                                    </div>
                                                  
                                                       <div class="col-md-6">
                                                               <label>Extra cost</label>
                                                               <input type="number" name="extra_cost" class="form-control" placeholder="Extra cost.." value="0.0" />
                                                    </div>
                                                </div>
                                             <div class="form-group row">
                                                    
                                                      <div class="col-md-4">
                                                          <button type="submit" class="btn btn-light">Add Slot</button>
                                                    </div>
                                                    
                                                </div>
                                                    
                                                    </form>
                                        
                                        </div>

                                        <table class="table table-bordered">
                                            <tr>

                                                <th>Day</th> 
                                                <th>From</th> 
                                                <th>To</th> 
                                            
                                          
                                                       <th>Extra cost</th> 
                                                                <th></th> 

                                            </tr>

                                            <?php foreach ($slots as $s) { // apk  ?>
                                            <tr class="day-{{$s->day_of_week}}-bg">
                                                <td style="font-weight: bold">{{$days[$s->day_of_week-1]}}</td>   
                                                    <td> {{$s->slot_from}} </td>   
                                                    <td>{{$s->slot_to}}</td>   
                                                
                                                          
                                                             <td>
                                                                <form method="post" action="{{url('backend/employees/timeslots/update')}}">
                                                                    <input type="hidden" name="id" value="{{$s->id}}" />
                                                                    {{csrf_field()}}
                                                                    <input class="in-m" type="number" value="{{$s->extra_cost}}" name="cost" />
                                                                    <button class="btn btn-success btn-xs" type="submit"
                                                                    
                                                                            >Save</button>
                                                                    
                                                        </form></td>
                                                        
                                                          <td>
                                                                <form method="post" action="{{url('backend/employees/timeslots/delete')}}">
                                                                    <input  type="hidden" name="id" value="{{$s->id}}" />
                                                                    {{csrf_field()}}
                                                                    <button class="btn btn-danger btn-xs" type="submit"
                                                                            onclick="return confirm('Are you sure ?')"
                                                                            >Remove</button>
                                                                    
                                                        </form></td>

                                                </tr>


                                            <?php } ?>   
                                        </table>
                                    </div> 





                                    <?php }else{ ?>
                                        
                                         <p style="    background-color: #fff;
                                       color: #000;
                                       padding: 1rem;
                                       text-align: center;
                                       font-size: 1rem;">Select one of the professionals to show his/her time slots</p>  
                                        
                                     <?php  } } else { ?>
                                    <p style="    background-color: #fff;
                                       color: #000;
                                       padding: 1rem;
                                       text-align: center;
                                       font-size: 1rem;">Select one of the professionals to show his/her time slots</p>
                                <?php } ?>

                            </div>




                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                </div>


            </div>


            <!-- footer start-->
            @include('dashboard.shared/footer')    
        </div>
        <!-- Plugins JS start-->
        <script src="{{asset('dashboard/assets/js/select2/select2.full.min.js')}}"></script>
        <script src="{{asset('dashboard/assets/js/select2/select2-custom.js')}}"></script>
        <script src="{{asset('dashboard/assets/js/range-slider/ion.rangeSlider.min.js')}}"></script>

        <script>
        
        
        'use strict';
        
        var times = [
             "01:00" ,"02:00"  ,"03:00" ,"04:00" ,   "05:00", "06:00", "07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00" , 
            "17:00"  ,"18:00" ,"19:00" ,"20:00"  ,"21:00" ,"22:00" ,"23:00" ,"00:00" 
            
            ];
var range_slider_custom = {
    init: function() { 
        $("#u-range-06").ionRangeSlider({
              type: "double",
            grid: false,
            from: 1,
            to : times.length-2 ,
            values: times ,
              onFinish: function (data) {
        // Called then action is done and mouse is released
        $('#start_hour').val(times[data.from]+":00");
        $('#end_hour').val(times[data.to]+":00");
    },
        });
    }
};
(function($) {
    "use strict";
    range_slider_custom.init();
})(jQuery);
        
        </script>

        <!-- Plugins JS Ends-->
        <!-- Plugins JS start-->
        <script>

function openEdit(...params) {

    $('#id_edit').val(params[0]);
    $('#id_delete').val(params[0]);
    $('#name_en_edit').val(params[1]);
    $('#name_ar_edit').val(params[2]);
    $('#desc_en_edit').val(params[3]);
    $('#desc_ar_edit').val(params[4]);
    $('#preview_edit').attr('src', params[5]);

    $('#editModal').modal('show');
}



        </script>


        <!-- Plugins JS Ends-->
    </body>
</html>