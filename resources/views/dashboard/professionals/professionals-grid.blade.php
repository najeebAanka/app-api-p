<?php
$page_title = "Professionals";
$route = "employees";

?>
<!DOCTYPE html>
<html lang="en">
    @include('dashboard.shared/header-css')
    <style>




    </style>
    <body>
    
                            <div class="modal fade" id="CreateNewModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form class="form theme-form" method="post" action="{{url('backend/'.$route.'/insert')}}"
                                              enctype="multipart/form-data"
                                              >
                                            {{ csrf_field() }}
                                          
                                                   
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">New professional</h5>


                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                           

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Name</label>
                                                                <input class="form-control" name="name" type="text" placeholder="Name...">
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                    
                                                        <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">About</label>
                                                                <textarea class="form-control" name="details" type="text" placeholder="Description..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                     
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Professional profile picture</label>
                                                                <input class="form-control" name="image" type="file" onchange="readURL(this, 'preview')">
                                                            </div>
                                                             <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Email</label>
                                                                <input  class="form-control" name="email" type="text" placeholder="Email..." >
                                                            </div>
                                                             <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Phone</label>
                                                                <input class="form-control" name="phone" type="text" placeholder="Phone..." >
                                                            </div>
                                                             <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Department</label>
                                                                <input class="form-control" name="department" type="text" placeholder="Department..." value="test services">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3" style="background-color: #ccc;min-height: 320px;">
                                                                <img id="preview" style="width : 100%;"/>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>




                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-secondary" type="submit">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
        
        
         
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
                                    <div class="card-header">
                                        <div style="float: right">
                                    
                                        <a href="#" class="btn btn-success mr-2 btn-block" data-bs-toggle="modal" data-original-title="test" data-bs-target="#CreateNewModal"
                                           > Add new professional</a>
                                  
                                        
                                     
                                        </div>
                                        <h5>All {{$page_title}}</h5>
                                    </div>


                                           <?php if(\App\Models\Employee::count() == 0){
                                           
                                               
                                               ?>  
                                    <div class="text-center" style="    margin: 2rem;
    background-color: #f0f8ff;
    padding: 2rem;">
                                        <h2>Welcome to test professionals</h2>
                                        <p>We don't have any professionals added to our system for now , please proceed by adding a new professional .</p>
                                
                                          <a href="#" class="btn btn-light mr-2 ml-2" data-bs-toggle="modal" data-original-title="test" data-bs-target="#CreateNewModal"
                                           > Add a new professional now</a>
                                        </div>
                                      <?php
                                            
                                          
                                      }else { // has subcategories ?>
                                    
                                    
                                    <div class="row">

                                        <?php
                                        $items = \App\Models\Employee::select(['id', 'name', 'details', 
                                            'profile_pic']);

                                        $start = 0;
                                        if (isset($_GET['start']))
                                            $start = $_GET['start'];
                                        $total = $items->count();
                                        $items = $items->take(20)->offset($start)->get();
                                        foreach ($items as $item) {
                                            ?> 
                                            <div class="col-xl-3  col-lg-3 col-md-6 col-sm-6">
                                                <div class="single-card-square">
                                                    <a href="{{url('admin/professional/'.$item->id)}}"> <img style="    max-width: 100%;
    border-radius: 1rem;" src="{{$item->buildIcon()}}" /></a>
                                                    <a href="{{url('admin/professional/'.$item->id)}}">  <p>{{$item->name}}</p></a>
                                                    <p><?= \App\Models\CategoryEmployee::where('emp_id' ,$item->id)->count()?> services</p>
                                                </div>

                                            </div>

                                        <?php } ?>

                                    </div>
   <div class="table-responsive">

                                        @include('dashboard.shared/pagination-footer')    
                                    </div>
  <?php } ?>

                                 
                                </div>
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
         


                <!-- Plugins JS Ends-->
                </body>
                </html>