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
                        <button style="float: right" class="btn btn-success"
                                data-bs-toggle="modal" data-original-title="test" data-bs-target="#CreateNewModal"
                                >Create new frequency option</button>
                        <h2 style="    color: #ccc;">{{$category->title_en}} | Frequencies</h2>
                        <a href="{{url('admin/category/'.$category->id)}}">Back to {{$category->title_en}}</a>
                        <hr />
                        <div class="row">


                            <?php $all = App\Models\FrequencyOption::where('category_id', $category->id)->get(); ?>




                            <?php
                            foreach ($all as $emp) {
                                ?>
                                <div class="col-md-6" >
                                    <div class="prof-row"> 
                                   

                                        <p class="name">{{$emp->title_en}}</p>

                                        <p>{{$emp->description_en}} 

                                        </p>
                                        </a>

                                        <hr />


                                        <form method="post" action="{{url('backend/frequencies/delete')}}">
                                            <input  type="hidden" name="id" value="{{$emp->id}}" />
                                            {{csrf_field()}}
                                            <button class="btn btn-danger btn-xs" type="submit"
                                                    onclick="return confirm('Are you sure ?')"
                                                    >Remove</button>
                                            <button type="button" class="btn btn-xs btn-warning"
                                                    onclick="openEdit('{{$emp->id}}'
                                                                ,'{{$emp->title_en}}'
                                                                    ,'{{$emp->title_ar}}'
                                                                        ,'{{$emp->description_en}}'
                                                                            ,'{{$emp->description_ar}}'
                                                                                         ,'{{$emp->title_ha}}'
                                                                        ,'{{$emp->description_ha}}'
                                                                              
                                                                                                )" 
                                                    >Edit</button>

                                        </form>

                                    </div>     
                                </div>

                            <?php } ?>            





                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                </div>


            </div>

            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form class="form theme-form" method="post" action="{{url('backend/frequencies/update')}}"
                              enctype="multipart/form-data"
                              >
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="-1" id="id_edit" />
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit item</h5>


                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

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
                        <form class="form theme-form" method="post" action="{{url('backend/frequencies/delete')}}"

                              >
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id_delete" value="-1" />

                            <div class="modal-footer">
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to proceed ? ')" type="submit">Delete This item</button>
                            </div>             
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="CreateNewModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form class="form theme-form" method="post" action="{{url('backend/frequencies/insert')}}"
                              enctype="multipart/form-data"
                              >
                            {{ csrf_field() }}
                            <input type="hidden" name="category_id" value="{{$category->id}}" />

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create new Time frequency</h5>


                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

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
                                                <textarea class="form-control" name="desc_en" type="text" 
                                                          placeholder="Description..." rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Description (Arabic)</label>
                                                <textarea class="form-control" name="desc_ar" type="text" 
                                                          placeholder="Description..." rows="3"></textarea>
                                            </div>
                                        </div>
                                             <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Description (Hausa)</label>
                                                <textarea class="form-control" name="desc_ha" type="text" 
                                                          placeholder="Description..." rows="3"></textarea>
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



            <!-- footer start-->
         
        </div>
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
          
              $('#name_ha_edit').val(params[5]);
            $('#desc_ha_edit').val(params[6]);
          
            $('#editModal').modal('show');
            
            }



        </script>


        <!-- Plugins JS Ends-->
    </body>
</html>