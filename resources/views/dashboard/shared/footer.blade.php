  <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 footer-copyright">
                <p class="mb-0">Copyright 2021-22 © test services |  All rights reserved.</p>
              </div>
              <div class="col-md-6">
                <p class="pull-right mb-0">Last login : {{date('d-m-Y')}}</i></p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="{{url('dashboard/assets')}}/js/jquery-3.5.1.min.js"></script>
    <!-- feather icon js-->
    <script src="{{url('dashboard/assets')}}/js/icons/feather-icon/feather.min.js"></script>
    <script src="{{url('dashboard/assets')}}/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="{{url('dashboard/assets')}}/js/sidebar-menu.js"></script>
    <script src="{{url('dashboard/assets')}}/js/config.js"></script>
    <!-- Bootstrap js-->
    <script src="{{url('dashboard/assets')}}/js/bootstrap/popper.min.js"></script>
    <script src="{{url('dashboard/assets')}}/js/bootstrap/bootstrap.min.js"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{url('dashboard/assets')}}/js/script.js"></script>
<!--    <script src="{{url('dashboard/assets')}}/js/theme-customizer/customizer.js"></script>-->
    <!-- login js-->
    <!-- Plugin used-->
    <script>
    
    function readURL(input , placeholder) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#'+placeholder).attr('src', e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}
    
    
    function playSound(url) {
    const audio = new Audio(url);
    audio.play();
    } 
    
    function getRndInteger(e, t) {
    return Math.floor(Math.random() * (t - e)) + e;
}
function _http(e, t, n, r) {
    var o = new XMLHttpRequest();
    (o.onreadystatechange = function () {
        if(o.status == 401){
           console.log('Not authorized');
       return;
   }
        o.readyState == XMLHttpRequest.DONE && (200 == o.status ? r(o.responseText) : console.log("Something else other than 200 was returned " + o.responseText));

    }),
        o.open(e, t, !0),
        o.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr("content")),
        o.setRequestHeader("Accept", "application/json"),
        o.setRequestHeader("Locale", "{{Illuminate\Support\Facades\App::getLocale()}}"),
        o.setRequestHeader("Content-type", "application/x-www-form-urlencoded"),
        o.setRequestHeader("X-Requested-With", "XMLHttpRequest"),
        o.setRequestHeader("Authorization", "Bearer " + _r9("_dg-v15628")),
        (loading = !0),
        o.send(e == "GET" ? "" : n);
}
function _r9(e) {
    for (var t = e + "=", n = document.cookie.split(";"), r = 0; r < n.length; r++) {
        for (var o = n[r]; " " == o.charAt(0); ) o = o.substring(1, o.length);
        if (0 == o.indexOf(t)) return o.substring(t.length, o.length);
    }
    return null;
}

    
    
    
    
    
    </script>