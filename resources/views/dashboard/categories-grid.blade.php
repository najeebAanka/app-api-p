<?php
$page_title = "Categories";
$route = "categories";
$parent = -1;
if (isset($_GET['parent'])) {
    $parent = $_GET['parent'];
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
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Name (English)</label>
                                                    <input id="name_en_edit" class="form-control" name="title_en" type="text" placeholder="Name...">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Name (Arabic)</label>
                                                    <input class="form-control" id="name_ar_edit"  name="title_ar" type="text" placeholder="Name...">
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
                            <div class="modal fade" id="CreateNewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                                <b>{{$page_title}}</b>
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
                                        <a href="#" style="float: right" data-bs-toggle="modal" data-original-title="test" data-bs-target="#CreateNewModal"
                                           ><i class="bookmark-search" data-feather="plus"></i></a>
                                        <h5>All {{$page_title}}</h5>
                                    </div>


                                    <div class="row">

                                        <?php
                                        $items = \App\Models\Category::where('parent_id', $parent)->select(['id', 'title_en', 'title_ar', 'icon']);

                                        $start = 0;
                                        if (isset($_GET['start']))
                                            $start = $_GET['start'];
                                        $total = $items->count();
                                        $items = $items->take(20)->offset($start)->get();
                                        foreach ($items as $item) {
                                            ?> 
                                            <div class="col-xl-3  col-lg-3 col-md-6 col-sm-6">
                                                <div class="single-card-square">
                                                    <a href="{{url('admin/categories-grid?parent='.$item->id)}}"> <img src="{{$item->buildIcon()}}" /></a>
                                                    <a href="{{url('admin/categories-grid?parent='.$item->id)}}">  <p>{{$item->title_en}}</p></a>
                                                    <div>
                                                        <button onclick="openEdit('{{$item->id}}'
                                                  ,'{{$item->title_en}}'
                                                      ,'{{$item->title_ar}}'
                                                          ,'{{$item->buildIcon()}}'
                                                              )" class="btn btn-light btn-sm"><i class="fa fa-pencil" ></i></button>  
                                                   
                                                        <a href="{{url('admin/categories-grid?parent='.$item->id)}}" class="btn btn-light btn-sm"><i class="fa fa-eye"></i></a>  

                                                    </div>
                                                </div>

                                            </div>

                                        <?php } ?>

                                    </div>



                                    <div class="table-responsive">

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
        </div>
                <!-- Plugins JS start-->
                <script>

                    function openEdit(...params){
              
                    $('#id_edit').val(params[0]);
                    $('#id_delete').val(params[0]);
                    $('#name_en_edit').val(params[1]);
                    $('#name_ar_edit').val(params[2]);
                    $('#preview_edit').attr( 'src' ,params[3]);
                    
                    $('#editModal').modal('show');
                    }



                </script>


                <!-- Plugins JS Ends-->
                </body>
                </html>