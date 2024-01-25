

            @if ($message = Session::get('error'))
                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">{{ $message }}
                      <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                    </div>
            
            @endif
        
            
            @if ($message = Session::get('message'))
              <div class="alert alert-primary dark alert-dismissible fade show" role="alert">{{ $message }}
                      <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                    </div>
          
            @endif
      

