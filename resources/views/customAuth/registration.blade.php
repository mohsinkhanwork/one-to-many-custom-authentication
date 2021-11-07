@extends('customAuth.dashboard')

@section('content')


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
                                
                                <select name="country" id="countySel" size="1" class="form-control">
                                <option value="" selected="selected">Select Country</option>
                                </select>
                  
                            </div>

                             <div class="form-group mb-3">

                            <select name="state" id="stateSel" size="1" class="form-control">
                            <option value="" selected="selected">Please select Country first</option>
                            </select>
                   
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

<script>
var stateObject = {
"India": { 
            "Delhi": [],
            "Kerala": [],
            "Goa" : [],
},

"Pakistan": {
            
            "Peshawar": [],
            "pindi": [],
}, 


}
 $(document).ready(function () {

    var countySel = document.getElementById("countySel"),
        stateSel = document.getElementById("stateSel");

    for (var country in stateObject) {

    countySel.options[countySel.options.length] = new Option(country, country);

  }

countySel.onchange = function () {

    stateSel.length = 1; // remove all options bar first
    if (this.selectedIndex < 1) 
    return; // done 
        
    console.log(countySel.value);

    for (var state in stateObject[this.value]) {

    stateSel.options[stateSel.options.length] = new Option(state, state);


}

}

countySel.onchange(); // reset in case page is reloaded
  
    stateSel.onchange = function () {
    if (this.selectedIndex < 1) 

    return; // done

    console.log(stateSel.value); 


}

});
</script>




@endsection