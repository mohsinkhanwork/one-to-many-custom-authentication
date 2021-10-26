@extends('customAuth.dashboard')

@section('content')

	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

 <div class="container mt-5">

   

       <form id="party_update_form" enctype= "multipart/form-data"> 
        @csrf

        @method('PUT')

            <div class="form-group">
                <label>Party Name</label>
                <input type="text" class="form-control" value="{{$party->name}}" name="name">
                 
            </div>

            <div class="form-group">
                <div>
                    
                    <img src="{{asset('party_logo/'. $party->party_logo)}}" width="125px" height="125">

                </div>

                <label>Change Party Logo</label>

                <input type="file" class="form-control"  value="{{ $party->party_logo }}" name="party_logo">
               
            </div>

            <button type="submit" class="btn btn-dark btn-block">  submit </button>
        </form>
    </div>


<script type="text/javascript">
    
$(document).ready(function(){

        $('#party_update_form').on('submit', function(e){
            e.preventDefault();

             $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

             $.ajax({

                url: "{{ route('party.update', [$party->id]) }}",
                type: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    // alert('updated');

                    swal({
                      title: "Good job!",
                      text: "Party Updated SuccessFully!",
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
 
                        if(err.errors.name == null ){               //name error is null

                            var swal1 = JSON.stringify(err.errors.party_logo).replace(/[\[\]"]+/g, '');

                             swal({
                      title: "Sorry..!",
                      text: swal1,
                      icon: "warning",
                      button: "OK",
                      dangerMode: true,
                    });
                        } else if(err.errors.party_logo == null ){               //party logo error is null

                           var swal2 = JSON.stringify(err.errors.name).replace(/[\[\]"]+/g, '');
                             swal({
                      title: "Sorry..!",
                      text: swal2,
                      icon: "warning",
                      button: "OK",
                      dangerMode: true,
                    });
                        }

                        else {                                      //all fields have errors.

                             var swal3 = JSON.stringify(err.errors.name + err.errors.party_logo ).replace(/[\[\]"]+/g, '');

                             swal({
                      title: "Sorry..!",
                      text: swal3,
                      icon: "warning",
                      button: "OK",
                      dangerMode: true,
                    });
                             
                    }
                }
             });
        });
});

</script>


@endsection