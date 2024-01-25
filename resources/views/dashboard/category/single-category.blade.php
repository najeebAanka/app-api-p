<?php

$category = \App\Models\Category::find(Route::input('id'));
if(!$category){
    //handle 404 later
    die('not found');
}

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
                        <img src="{{$category->buildIcon()}}"  id="preview_edit" style="width : 60px;float: right;padding: 1rem"/>
                        <h1 style="    color: #ccc;
   ">{{$category->title_en}}</h1>
      <a href="{{url('admin/categories?parent='.$category->parent_id)}}">Back to Categories</a>
    <hr />
                        <div class="row">

                                    <div class="col-md-5" >
                                        
                                        <div class="card" >
                            <form class="form theme-form" method="post" action="{{url('backend/categories/update')}}"
                                  enctype="multipart/form-data"
                                  >
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$category->id}}" id="id_edit" />
                         
                                <div class="card-body" style="text-align: left">

                              
                              
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Name (English)</label>
                                                    <input id="name_en_edit"  value="{{$category->title_en}}" class="form-control" name="title_en" type="text" placeholder="Name...">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Name (Arabic)</label>
                                                    <input class="form-control" value="{{$category->title_ar}}"  id="name_ar_edit"  name="title_ar" type="text" placeholder="Name...">
                                                </div>
                                            </div>
                                               <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Name (Hausa)</label>
                                                    <input class="form-control" value="{{$category->title_ha}}"  id="name_ha_edit"  name="title_ha" type="text" placeholder="Name...">
                                                </div>
                                            </div>
                                        </div>
                                       <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Base price (Optional)</label>
                                                    <input id="base_price_edit"  value="{{$category->base_price}}" class="form-control" name="base_price" type="text" placeholder="Base price...">
                                                </div>
                                            </div>
                                          
                                        </div>
                                    
                                    
                                               <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-12">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (English)</label>
                                                                <textarea  class="form-control" name="desc_en" id="desc_en_edit"  type="text" placeholder="Description..." rows="3">{{$category->description_en}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (Arabic)</label>
                                                                <textarea class="form-control" name="desc_ar" id="desc_ar_edit"  type="text" placeholder="Description..." rows="3">{{$category->description_ar}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (Hausa)</label>
                                                                <textarea class="form-control" name="desc_ha" id="desc_ha_edit"  type="text" placeholder="Description..." rows="3">{{$category->description_ha}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                    
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Icon</label>
                                                    <input class="form-control" name="image" type="file" onchange="readURL(this, 'preview_edit')">
                                                </div>
                                            </div>
                                      

                                        </div>
                                        
                                        
                                                
                                                 
                                        

                              



                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="submit">Save changes</button>
                                </div>
                            </form>
                              <form class="form theme-form" method="post" action="{{url('backend/categories/delete')}}"
                                        
                                              >
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" id="id_delete"  value="{{$category->id}}" />
                                            
                                 <div class="modal-footer">
                                     <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to proceed ? ')" type="submit">Delete Category</button>
                                </div>             
                              </form>
                        </div>     
                            </div>
         
                            
                           <div class="col-md-7">
                               <div class="card card-body">
                               <div class="row">
                                        <div class="col-md-6">
                                                <div class="single-card-square">
                                                    <a href="{{url('admin/category/'.$category->id.'/services')}}"> <img src="{{url('dashboard/extras/icons8-tools-100.png')}}" /></a>
                                                    <a href="{{url('admin/category/'.$category->id.'/services')}}">  <p>Services (<?= \App\Models\Service::where('category_id' ,$category->id)->count()?>)</p></a>
                                              
                                                </div>

                                            </div>
                                   
                                       <div class="col-md-6">
                                                <div class="single-card-square">
                                                    <a href="{{url('admin/category/'.$category->id.'/professionals')}}"> <img src="{{url('dashboard/extras/icons8-cleaner-100.png')}}" /></a>
                                                    <a href="{{url('admin/category/'.$category->id.'/professionals')}}">  <p>Professionals (<?= \App\Models\CategoryEmployee::where('cat_id' ,$category->id)->count()?>)</p></a>
                                              
                                                </div>

                                            </div>
                                   
                                       <div class="col-md-6">
                                                <div class="single-card-square">
                                                    <a href="{{url('admin/category/'.$category->id.'/frequencies')}}"> <img src="{{url('dashboard/extras/icons8-clock-100.png')}}" /></a>
                                                    <a href="{{url('admin/category/'.$category->id.'/frequencies')}}">  <p>Frequencies (<?= \App\Models\FrequencyOption::where('category_id' ,$category->id)->count()?>)</p></a>
                                              
                                                </div>

                                            </div>
                                   
                                       <div class="col-md-6">
                                                <div class="single-card-square">
                                                    <a href="{{url('admin/category/'.$category->id.'/params')}}"> <img src="{{url('dashboard/extras/icons8-parameter-100.png')}}" /></a>
                                                    <a href="{{url('admin/category/'.$category->id.'/params')}}">  <p>Extra Questions (<?= \App\Models\Parameter::where('category_id' ,$category->id)->count()?>)</p></a>
                                              
                                                </div>

                                            </div>
                                   
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