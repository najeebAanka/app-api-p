<!DOCTYPE html>
<html lang="en">
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
                   
                        <h2 style="    color: #ccc;">Showing : <?=isset($_GET['category'])?App\Models\Category::find($_GET['category'])->title_en:"All"?> Requests</h2>
                        <hr />
                        <div class="row">


                            <?php 
                            
                            $params  = [];
                            $wheres = "";
                            if(isset($_GET['category'])){
                              $params['category']=$_GET['category']; 
                              $wheres.= " and categories.id=:category";
                            }
                            $start = 0;
                              if(isset($_GET['start'])){
                              $start = $_GET['start'];
                            }
                            $total = App\Models\Booking::count();
                            $selects = 'bookings.id ,bookings.created_at ,'
                                    . ' bookings.status ,users.name  , users.phone '
                                    . ' , users.email, addresses.country  '
                                    . ',addresses.address1 ,categories.title_en , bookings.grand_total';
                            $all = DB::select('SELECT '.$selects.' , if(bookings.status'
                                    . '  = "pending", 1, 0) AS is_pending from bookings'
                                    . ' join users on users.id = bookings.user_id join addresses on'
                                    . ' bookings.address_id = addresses.id join booking_services on '
                                    . 'booking_services.booking_id=bookings.id join services on '
                                    . 'services.id=booking_services.service_id join categories '
                                    . 'on categories.id=services.category_id where bookings.id>0 '.$wheres.' GROUP by'
                                    . ' '.$selects.' order by is_pending DESC ,bookings.id DESC limit '.$start.' ,20 ' ,$params );
                            
                            
                            foreach ($all as $emp) {
                                ?>
                                <div class="col-md-6 col-lg-4 col-xl-3 col-sm-12" >
                                    <a style="color: #000" href="{{url('admin/single-booking/'.$emp->id)}}">
                                        <div class="prof-row" style="position: relative"> 
                                   
                                        <span class="p-orp {{$emp->status}}">{{strtoupper($emp->status)}}</span>
                                        <p class="name-service">{{$emp->title_en}}</p>

                                        <p class="sender">{{$emp->name}} - {{$emp->email}} - {{$emp->phone}}   

                                        </p>
                                        <p class="address">{{$emp->address1}} 

                                        </p>
                                        <p class="time-elapsed">{{time_elapsed_string($emp->created_at)}}

                                        </p>
                                       

                                
                                        </div>  </a>   
                                </div>

                            <?php } ?>            





                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                       <div class="table-responsive">

                                        @include('dashboard.shared/pagination-footer')    
                                    </div>
                </div>


            </div>

       

            <!-- footer start-->
            @include('dashboard.shared/footer')    
        </div>

        <script>

            function openEdit(...params) {

            $('#id_edit').val(params[0]);
            $('#id_delete').val(params[0]);
            $('#name_en_edit').val(params[1]);
            $('#name_ar_edit').val(params[2]);
            $('#desc_en_edit').val(params[3]);
            $('#desc_ar_edit').val(params[4]);
          
            $('#editModal').modal('show');
            
            }



        </script>


        <!-- Plugins JS Ends-->
    </body>
</html>