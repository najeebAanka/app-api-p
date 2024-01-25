<?php
$table = $meta['table'];
$page_title = ucwords(str_replace('_'  ,' ' ,$meta['view'] ));
$schema = $meta['schema'];
?>
<!DOCTYPE html>
<html lang="en">
    @include('dashboard.shared/header-css')
    <style>
        
  
        
        
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


                            <div class="row">
                              
                                <div class="col-12">
                                 



                                    <div class="modal fade" id="CreateNewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <form class="form theme-form" method="post" action="{{url('admin/'.$meta['view'].'/insert')}}">
                                                    {{ csrf_field() }}
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">New {{$meta['view']}}</h5>
                                                      
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">



                                                        <div class="card-body">
                                                            <div class="row">
                                                                
                                                                <?php foreach ($schema as $sc){ 
                                                                    
                                                                    ?>
                                                                
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="exampleFormControlInput1">
                                                                            {{ucwords(str_replace('_'  ,' ' ,$sc ))}}
                                                                            
                                                                        </label>
                                                                        <input class="form-control" name="{{$sc}}" type="text" placeholder="Enter {{ucwords(str_replace('_'  ,' ' ,$sc ))}} ..">
                                                                    </div>
                                                                </div>
                                                                
                                                                <?php } ?>
                                                               
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



                         
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        
                                        <a href="#" data-bs-toggle="modal"  data-original-title="test" data-bs-target="#CreateNewModal"
                                           style="float: right"
                                           ><i class="bookmark-search" data-feather="plus"></i></a>
                                        
                                        <h5>All {{$page_title}}</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    @foreach($schema as $th)
                                                    <th scope="col">{{ucwords(str_replace('_'  ,' ' ,$th ))}}</th>
                                                   
                                                    @endforeach
                                                    
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                
                                                $parent_id = -1;
                                                if(isset($_GET['parent'])){
                                                    $parent_id=$_GET['parent'];
                                                }
                                                
                                                $items = DB::table($table)->select($schema);

                                                $start = 0;
                                                if (isset($_GET['start']))
                                                    $start = $_GET['start'];
                                                $total = $items->count();
                                                $items = $items->take(20)->offset($start)->get();
                                              
                                                
                                                foreach ($items as $item) {
                                                    ?>   
                                                    <tr>
                                                           @foreach($schema as $th)
                                                        <td scope="row">{{$item->$th}}</td>
                                                           @endforeach
                                                         <th scope="col"></th>
                                               

                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                        @include('dashboard.shared/pagination-footer')    
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                </div>
            </div>
                <!-- footer start-->
                @include('dashboard.shared/footer')    
                   <!-- Plugins JS start-->
        </div>
    

    <!-- Plugins JS Ends-->
                </body>
                </html>