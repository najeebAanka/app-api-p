<div class="card-footer">
    <b>Total number of results : {{$total}}</b>   
 <?php
$url = Request::url(); // url without query
$query = Request::query(); // query

//Replace parameter:


$pages_count = $total/20;
for($i=0;$i<$pages_count;$i++){
    ?>
    | <a class="btn btn-light btn-xs mr-2 ml-2" href="{{$url.'?'. http_build_query(array_merge($query, ['start' => $i*20]))}}">{{$i+1}}</a> 
    <?php } ?>
</div>
