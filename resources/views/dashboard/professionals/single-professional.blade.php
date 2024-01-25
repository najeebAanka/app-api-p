<?php
$page_title = "Professionals";
$route = "employees";
$emp  = \App\Models\Employee::find(Route::input('id'));
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
            <div class="edit-profile">
              <div class="row">
                <div class="col-xl-4">
                  <div class="card">
                    <div class="card-header pb-0">
                      <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('backend/employees/update')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$emp->id}}" />
                        <div class="row mb-2">
                          <div class="profile-title">
                            <div class="media">                  
                                <img class="img-70 rounded-circle" id="preview" alt="" src="{{$emp->buildIcon()}}">
                              <div class="media-body">
                                <h3 class="mb-1 f-20 txt-primary">{{$emp->name}}</h3>
                                <p class="f-12">{{$emp->department}}</p>
                              </div>
                            </div>
                          </div>
                        </div>
                             <div class="mb-3">
                          <label class="form-label">Email-Address</label>
                          <input class="form-control" placeholder="Name.." value="{{$emp->name}}">
                        </div>
                        <div class="mb-3">
                          <h6 class="form-label">Bio</h6>
                          <textarea class="form-control" rows="5">{{$emp->details}}</textarea>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Email-Address</label>
                          <input class="form-control" placeholder="your-email@domain.com" value="{{$emp->email}}">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Phone</label>
                          <input class="form-control" type="text" value="{{$emp->phone}}">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Department</label>
                          <input class="form-control" placeholder="Department" value="{{$emp->department}}">
                        </div>
                             <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Professional profile picture</label>
                                                                <input class="form-control" name="image" type="file" onchange="readURL(this, 'preview')">
                                                            </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-xl-8">
                  <div class="card">
                    <div class="card-header pb-0">
                      <h4 class="card-title mb-0">{{$emp->name}}'s services</h4>
                      <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                  
                        <div class="row">
                     
                          <?php
                          $count = 0;
                                    foreach (\App\Models\CategoryEmployee::where('emp_id', $emp->id)->get() as $cat) {
                                        $count++;

                                        $item = \App\Models\Category::find($cat->cat_id);
                                        ?>    
                        
                               <div class="col-xl-3  col-lg-3 col-md-6 col-sm-6">
                                                <div class="single-card-square">
                                                  <img src="{{$item->buildIcon()}}" />
                                                  <p>{{$item->title_en}}</p>
                                                    <div>
                                                 
                                                        
                                                          <form method="post" action="{{url('backend/employees/unlink')}}">
                                                                    <input  type="hidden" name="id" value="{{$cat->id}}" />
                                                                    {{csrf_field()}}
                                                                        <a href="{{url('admin/category/'.$item->id.'/professionals?ref='.$cat->id)}}" class="btn btn-success btn-xs">Time slots</a> 
                                                     
                                                                    <button class="btn btn-danger btn-xs" type="submit"
                                                                            onclick="return confirm('Are you sure ?')"
                                                                            >Remove</button>
                                                                    
                                                        </form>
                                                        
                                                    </div>
                                                </div>

                                            </div>
                        
                        
                        
                                    <?php }
                                    if( $count  == 0) {   ?>
                                         <p style="    background: #ffe9e9;
                                       padding: 1rem;">This professional is not linked to any services , please go to categories , and open professionals menu and add her
                                          in order to link her to service providing list</p>
                                        
                                        <?php }  ?> 
                                         </div>
                    </div>
                    <div class="card-footer text-end">
                             <form method="post" action="{{url('backend/employees/delete')}}">
                                                                    <input  type="hidden" name="id" value="{{$emp->id}}" />
                                                                    {{csrf_field()}}
                                                                 
                                                                    <button onclick="return confirm('Are you sure ?')" class="btn btn-danger btn xs" type="submit">Delete professional account</button>
                             </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
                    
                    
                </div>


            </div>
   

                <!-- footer start-->
                @include('dashboard.shared/footer')    
       
                <!-- Plugins JS start-->
         


                <!-- Plugins JS Ends-->
                </body>
                </html>