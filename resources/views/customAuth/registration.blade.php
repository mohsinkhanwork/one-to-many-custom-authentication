@extends('customAuth.dashboard')

@section('content')

<style type="text/css">
    #page-loader {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 10000;
    display: none;
    text-align: center;
    width: 100%;
    padding-top: 25px;
    background-color: rgba(255, 255, 255, 0.7); 
    /*background-color: rgba(255, 255, 255, 0.7); */
}
</style>
 <div id="page-loader">
                            <h3> Loading page... Please wait</h3>
                            <img src="http://css-tricks.com/examples/PageLoadLightBox/loader.gif" alt="loader">
                            <p><small> <b> You will be redirected after a while. Thank You</b> </small></p>
                        </div>
<main class="signup-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Register User</h3>
                    <div class="card-body">

                        <form id="custom_register" method="POST" action="#">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Name" id="name" class="form-control" name="name"
                                    required autofocus>
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="email" placeholder="Email" id="email_address" class="form-control"
                                    name="email" required autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" placeholder="Password" id="password" class="form-control"
                                    name="password" required>
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="remember"> Remember Me</label>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                            <div class="checkbox">
                                <label> Candidate? <br>
                                    <input type="checkbox" name="role" value="candidate">
                                     Yes 
                                 </label>
                            </div>
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
                


<script type="text/javascript">

$( document ).ajaxStart(function() {
     document.getElementById("page-loader").style.display = 'block';
    
    });

$( document ).ajaxStop(function() {
     document.getElementById("page-loader").style.display = 'none';
    
    });
    
$(document).ready(function() {

$('#custom_register').on('submit', function(e) {
            e.preventDefault();
             var $this = $(this);

            $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
                });


            $.ajax({
                        type: $this.attr('method'),
                        url: "{{  route('register.custom')}}",
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        success: function (data) {
                            // alert('suceess');

                            swal({
                      title: "Congratulations..!",
                      text: "Your Password is also sent to your email",
                      icon: "success",
                      button: "OK",
                    }).then((willDelete) => {

                        if (willDelete) {
                                    
                            window.location = "{{ url('/party') }}";
      
                      }
                         });

                     },
                        error: function(xhr) {

                            var err = JSON.parse(xhr.responseText);

                            // var status = JSON.parse(xhr.responseText);
                            // var swal2 = JSON.stringify(status.message).replace(/[\[\]"]+/g, '');
                            // alert(swal2);


                            if(err.errors.email != null) {

                                var swal1 = JSON.stringify(err.errors.email).replace(/[\[\]"]+/g, '');

                            swal({
                                  title: "Sorry..!",
                                  text: swal1,
                                  icon: "warning",
                                  button: "OK",
                                  dangerMode: true,
                                });
                            } else {

                                alert('error_else');
                            }   

                        },
                    });
});
});

</script>




@endsection