<?php
$page_title = "Categories";
$route = "categories";
$parent = -1;
$back_link = -1;
if (isset($_GET['parent']) && $_GET['parent']!=-1) {
    $parent = $_GET['parent'];
    $cat = \App\Models\Category::find($parent);
    $page_title =    $cat ->title_en;
    $back_link  =    $cat->parent_id;
}
?>
<!DOCTYPE html>
<html lang="en">
    @include('dashboard.shared/header-css')
    <style>




    </style>
    <body>
           <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form class="form theme-form" method="post" action="{{url('backend/'.$route.'/update')}}"
                                  enctype="multipart/form-data"
                                  >
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="-1" id="id_edit" />
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit item</h5>


                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <b id="modal-title">{{$page_title}}</b>
                                    <hr />

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Name (English)</label>
                                                    <input id="name_en_edit" class="form-control" name="title_en" type="text" placeholder="Name...">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Name (Arabic)</label>
                                                    <input class="form-control" id="name_ar_edit"  name="title_ar" type="text" placeholder="Name...">
                                                </div>
                                            </div>
                                              <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Name (Hausa)</label>
                                                    <input class="form-control" id="name_ha_edit"  name="title_ha" type="text" placeholder="Name...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Icon</label>
                                                    <input class="form-control" name="image" type="file" onchange="readURL(this, 'preview_edit')">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3" style="background-color: #ccc;min-height: 300px;
                                                     text-align: center;line-height: 300px;">
                                                    <img id="preview_edit" style="max-width : 100%;"/>
                                                </div>
                                            </div>

                                        </div>
                                        
                                        
                                                
                                                        <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (English)</label>
                                                                <textarea class="form-control" name="desc_en" id="desc_en_edit"  type="text" placeholder="Description..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (Arabic)</label>
                                                                <textarea class="form-control" name="desc_ar" id="desc_ar_edit"  type="text" placeholder="Description..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                              <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (Hausa)</label>
                                                                <textarea class="form-control" name="desc_ha" id="desc_ha_edit"  type="text" placeholder="Description..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                        

                                    </div>




                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="submit">Save changes</button>
                                </div>
                            </form>
                              <form class="form theme-form" method="post" action="{{url('backend/'.$route.'/delete')}}"
                                        
                                              >
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" id="id_delete" value="-1" />
                                            
                                 <div class="modal-footer">
                                     <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to proceed ? ')" type="submit">Delete Category</button>
                                </div>             
                              </form>
                        </div>
                    </div>
                </div>
                            <div class="modal fade" id="CreateNewModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form class="form theme-form" method="post" action="{{url('backend/'.$route.'/insert')}}"
                                              enctype="multipart/form-data"
                                              >
                                            {{ csrf_field() }}
                                            <input type="hidden" name="parent_id" value="{{$parent}}" />
                                                   
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Create new item</h5>


                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <b>Subcategory under {{$page_title}}</b>
                                                <hr />

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Name (English)</label>
                                                                <input class="form-control" name="title_en" type="text" placeholder="Name...">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Name (Arabic)</label>
                                                                <input class="form-control" name="title_ar" type="text" placeholder="Name...">
                                                            </div>
                                                        </div>
                                                           <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Name (Hausa)</label>
                                                                <input class="form-control" name="title_ha" type="text" placeholder="Name...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                        <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (English)</label>
                                                                <textarea class="form-control" name="desc_en" type="text" placeholder="Description..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (Arabic)</label>
                                                                <textarea class="form-control" name="desc_ar" type="text" placeholder="Description..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                                 <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (Hausa)</label>
                                                                <textarea class="form-control" name="desc_ha" type="text" placeholder="Description..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Icon</label>
                                                                <input class="form-control" name="image" type="file" onchange="readURL(this, 'preview')">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3" style="background-color: #ccc;min-height: 300px;">
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
        
<!--        
              <div class="modal fade" id="CreateNewModalServices" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form class="form theme-form" method="post" action="{{url('backend/services/insert')}}"
                                              enctype="multipart/form-data"
                                              >
                                            {{ csrf_field() }}
                                            <input type="hidden" name="category_id" value="{{$parent}}" />
                                                   
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Create new item</h5>


                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <b>New service under {{$page_title}}</b>
                                                <hr />

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Name (English)</label>
                                                                <input class="form-control" name="title_en" type="text" placeholder="Name...">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Name (Arabic)</label>
                                                                <input class="form-control" name="title_ar" type="text" placeholder="Name...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                          <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (English)</label>
                                                                <textarea class="form-control" name="desc_en" type="text" placeholder="Description..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Description (Arabic)</label>
                                                                <textarea class="form-control" name="desc_ar" type="text" placeholder="Description..." rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleFormControlInput1">Icon</label>
                                                                <input class="form-control" name="image" type="file" onchange="readURL(this, 'preview_cat')">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3" style="background-color: #ccc;min-height: 300px;">
                                                                <img id="preview_cat" style="width : 100%;"/>
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
        -->
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
                                      <?php if(\App\Models\Service::where('category_id' ,$parent)->count() == 0){ ?>  
                                        <a href="#" class="btn btn-success mr-2 btn-block" data-bs-toggle="modal" data-original-title="test" data-bs-target="#CreateNewModal"
                                           > Create subcategory here</a>
                                      <?php } ?>
                                        
                                     
                                        </div>
                                        <h5>All {{$page_title}}</h5>
                                 
                                              <a href="{{url('admin/categories?parent='.$back_link)}}">Back</a>
                                         
                                    </div>


                                           <?php if(\App\Models\Category::where('parent_id' ,$parent)->count() == 0){
                                            if(\App\Models\Service::where('category_id' ,$parent)->count() == 0){ 
                                               
                                               ?>  
                                    <div class="text-center" style="    margin: 2rem;
    background-color: #f0f8ff;
    padding: 2rem;">
                                        <h2>Welcome to {{$page_title}}</h2>
                                        <p>You can set this category to be services category by not adding any subcaegoies under it , in this case
                                        you will be forwarded to category details page , or else  , add more subcategories now.</p>
                                       <a href="{{url('admin/category/'.$parent)}}" class="btn btn-light btn-block  mr-2 ml-2"
                                         
                                           > Convert to services category</a>
                                          <a href="#" class="btn btn-light mr-2 ml-2" data-bs-toggle="modal" data-original-title="test" data-bs-target="#CreateNewModal"
                                           > Create subcategory here (Not a service category)</a>
                                        </div>
                                      <?php
                                            }
                                            else{ // has services ?>
                                    <p>Redirecting to categories details dashboard</p>
                                    <script>
                                    window.location.href = '{{url('admin/category/'.$parent)}}';
                                    
                                    </script>
                                    
                                    
                                    
                                            <?php
                                            }
                                      }else { // has subcategories ?>
                                    
                                    
                                    <div class="row">

                                        <?php
                                        $items = \App\Models\Category::where('parent_id', $parent);

                                        $start = 0;
                                        if (isset($_GET['start']))
                                            $start = $_GET['start'];
                                        $total = $items->count();
                                        $items = $items->take(20)->offset($start)->get();
                                        foreach ($items as $item) {
                                            ?> 
                                            <div class="col-xl-3  col-lg-3 col-md-6 col-sm-6">
                                                <div class="single-card-square">
                                                    <a href="{{url('admin/categories?parent='.$item->id)}}"> <img src="{{$item->buildIcon()}}" /></a>
                                                    <a href="{{url('admin/categories?parent='.$item->id)}}">  <p>{{$item->title_en}}</p></a>
                                                    <div>
                                                        <button onclick="openEdit('{{$item->id}}','{{$item->title_en}}' ,'{{$item->title_ar}}' ,'{{$item->title_ha}}','{{$item->description_en}}' ,'{{$item->description_ar}}','{{$item->description_ha}}','{{$item->buildIcon()}}')" class="btn btn-light btn-sm"><i class="fa fa-pencil" ></i></button>  
                                                   
                                                        <a href="{{url('admin/categories?parent='.$item->id)}}" class="btn btn-light btn-sm"><i class="fa fa-eye"></i></a>  

                                                    </div>
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
                <script>

                    function openEdit(...params){
              
                    $('#id_edit').val(params[0]);
                    $('#id_delete').val(params[0]);
                    $('#name_en_edit').val(params[1]);
                    $('#name_ar_edit').val(params[2]);
                     $('#name_ha_edit').val(params[3]);
                    $('#desc_en_edit').val(params[4]);
                    $('#desc_ar_edit').val(params[5]);
                    $('#desc_ha_edit').val(params[6]);
                    $('#preview_edit').attr( 'src' ,params[7]);
                    
                    $('#editModal').modal('show');
                    }



                </script>


                <!-- Plugins JS Ends-->
                </body>
                </html>