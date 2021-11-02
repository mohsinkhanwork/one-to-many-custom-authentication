@extends('customAuth.dashboard')

@section('content')


    

 <div class="container mt-5">

     
<div class="alert" id="message" style="display: none"></div>
       <form  method="post" id="party_create_form"  enctype="multipart/form-data">

        @csrf

            <div class="form-group">
                <label>Party Name: </label>
                <input type="text" class="form-control" name="name" >

            </div>

            <div class="form-group">
                <label>Select Your Party Leader: </label>

                <select class="form-control" name="party_leader">
   
              <option></option>
                
                <option value="imran khan" value="imran khan"> Imran Khan </option>
                <option value="Bilawal" value="Bilawal"> Bilawal </option>
                <option value="nawaz shareef" value="nawaz shareef"> nawaz shareef </option>
            
                </select>

            </div>



            <div class="form-group">
                <label>Add Party Logo</label>
                <input type="file" class="form-control " name="party_logo">
       
            </div>

            <button type="submit" class="btn btn-dark btn-block"> submit </button>
        </form>
    </div>

<script type="text/javascript">   
$(document).ready(function(){
    $('#party_create_form').on('submit', function(e){
        e.preventDefault();

         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{route('party.store')}}",
            type: "POST",
            data:new FormData(this),
            dataType:'JSON',
            cache: false,
            contentType: false,
            processData: false,        
            success: function(data) {
           
                swal({
                      title: "Good job!",
                      text: "Party Added SuccessFully!",
                      icon: "success",
                      button: "Ok",
                    }).then((willDelete) => {

                        if (willDelete) {
                        window.location = "{{ url('/party') }}";
                    }

                    });
            },
           error: function(xhr, status, error) {

                         var err = JSON.parse(xhr.responseText);
 
                        if(err.errors.name != null ){               //name error exists

                            var swal1 = JSON.stringify(err.errors.name).replace(/[\[\]"]+/g, '');

                             swal({
                      title: "Sorry..!",
                      text: swal1,
                      icon: "warning",
                      button: "OK",
                      dangerMode: true,
                    });
                        } else if(err.errors.party_leader != null ){               //party logo error exists

                           var swal2 = JSON.stringify(err.errors.party_leader).replace(/[\[\]"]+/g, '');
                             swal({
                      title: "Sorry..!",
                      text: swal2,
                      icon: "warning",
                      button: "OK",
                      dangerMode: true,
                    });
                        } else if(err.errors.party_logo != null){               //party logo error exsists

                           var swal3 = JSON.stringify(err.errors.party_logo).replace(/[\[\]"]+/g, '');
                             swal({
                      title: "Sorry..!",
                      text: swal3,
                      icon: "warning",
                      button: "OK",
                      dangerMode: true,
                    });
                }
            },
        });
    });
});
</script>
	

@endsection