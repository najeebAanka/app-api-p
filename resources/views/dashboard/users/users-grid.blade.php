<?php
$page_title = "Users";
$route = "users";
$parent = -1;
$back_link = -1;

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

                        </div>
                    </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                    
                                        <h5>All {{$page_title}}</h5>
                                 
                                         
                                    </div>


                                           <?php if(\App\Models\User::where('user_type' ,2)->count() == 0){
                                      
                                          ?>
                                    <h3>No users yet</h3>
                                    <?php
                                      }else { // has subcategories ?>
                                    
                                    
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>ID</th> 
                                            <th>Name</th> 
                                            <th>Phone</th> 
                                            <th>Email</th> 
                                            <th>Gender</th> 
                                                    <th>Join date</th> 
                                            
                                        </tr>
                                        <?php
                                        $items = \App\Models\User::where('user_type' ,2);

                                        $start = 0;
                                        if (isset($_GET['start']))
                                            $start = $_GET['start'];
                                        $total = $items->count();
                                        $items = $items->take(20)->offset($start)->orderBy('id' ,'desc')->get();
                                        foreach ($items as $item) {
                                            ?> 
                                        
                                        
                                             <tr>
                                                 <td> {{$item->id}}</td>
                                                 <td> {{$item->name}}</td>
                                                 <td> {{$item->phone}}</td>
                                                 <td> {{$item->email}}</td>
                                                 <td> {{$item->gender}}</td>
                                                 <td> {{$item->created_at}}</td>
                                            
                                        </tr>
                                        
                                         

                                        <?php } ?>

                                    </table>
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
                <script>

                    function openEdit(...params){
              
                    $('#id_edit').val(params[0]);
                    $('#id_delete').val(params[0]);
                    $('#name_en_edit').val(params[1]);
                    $('#name_ar_edit').val(params[2]);
                    $('#desc_en_edit').val(params[3]);
                    $('#desc_ar_edit').val(params[4]);
                    $('#preview_edit').attr( 'src' ,params[5]);
                    
                    $('#editModal').modal('show');
                    }



                </script>


                <!-- Plugins JS Ends-->
                </body>
                </html>