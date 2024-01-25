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
                                >Create new service</button>
                        <h2 style="    color: #ccc;">{{$category->title_en}} | Services</h2>
                        <a href="{{url('admin/category/'.$category->id)}}">Back to {{$category->title_en}}</a>
                        <hr />
                        <div class="row">


                            <?php $all = App\Models\Service::where('category_id', $category->id)->get(); ?>




                            <?php
                            foreach ($all as $emp) {
                                ?>
                                <div class="col-md-6" >
                                    <div class="prof-row"> 
                                        <img src='{{$emp->buildIcon()}}' style="max-width: 60px;" />

                                        <p class="name">{{$emp->title_en}}</p>

                                        <p>{{$emp->description_en}} 

                                        </p>
                                        </a>
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Max quantity : {{$emp->max_quantity}}</td>
                                                <td>Old price : {{$emp->old_price}}</td>
                                                <td>New price : {{$emp->new_price}}</td>
                                            </tr>

                                        </table>
                                        <hr />


                                        <form method="post" action="{{url('backend/services/delete')}}">
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
                                                                                ,'{{$emp->buildIcon()}}'
                                                                                    ,'{{$emp->max_quantity}}'
                                                                                        ,'{{$emp->old_price}}'
                                                                                            ,'{{$emp->new_price}}'
                                                                                                    
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
                        <form class="form theme-form" method="post" action="{{url('backend/services/update')}}"
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
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Icon</label>
                                                <input class="form-control" name="image" type="file" onchange="readURL(this, 'preview_edit')">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3" style="background-color: #ccc;max-height: 100px;
                                                 text-align: center;line-height: 100px;">
                                                <img id="preview_edit" style="max-width : 20%;"/>
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

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Maximum quantity</label>
                                                <input  class="form-control" name="max_q" id="max_q_edit"  type="number" placeholder="Max quantity..."  />
                                            </div>
                                        </div>


                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Old price</label>
                                                <input  class="form-control" name="old_price" id="old_price_edit"  type="text" placeholder="Old price..."  />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">New price</label>
                                                <input  class="form-control" name="new_price" id="new_price_edit"  type="text" placeholder="New price..."  />
                                            </div>
                                        </div>

                                    </div>





                                </div>




                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="submit">Save changes</button>
                            </div>
                        </form>
                        <form class="form theme-form" method="post" action="{{url('backend/services/delete')}}"

                              >
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id_delete" value="-1" />

                            <div class="modal-footer">
                                <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to proceed ? ')" type="submit">Delete This service</button>
                            </div>             
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="CreateNewModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form class="form theme-form" method="post" action="{{url('backend/services/insert')}}"
                              enctype="multipart/form-data"
                              >
                            {{ csrf_field() }}
                            <input type="hidden" name="category_id" value="{{$category->id}}" />

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create new service</h5>


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


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Maximum quantity</label>
                                                <input  class="form-control" name="max_q"   type="number" placeholder="Max quantity..."  />
                                            </div>
                                        </div>


                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Old price</label>
                                                <input  class="form-control" name="old_price"   type="text" placeholder="Old price..."  />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">New price</label>
                                                <input  class="form-control" name="new_price"   type="text" placeholder="New price..."  />
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
            $('#max_q_edit').val(params[6]);
            $('#new_price_edit').val(params[8]);
            $('#old_price_edit').val(params[7]);
            
               $('#name_ha_edit').val(params[9]);
            $('#desc_ha_edit').val(params[10]);
            
            $('#preview_edit').attr('src', params[5]);
            $('#editModal').modal('show');
            
            }



        </script>


        <!-- Plugins JS Ends-->
    </body>
</html>