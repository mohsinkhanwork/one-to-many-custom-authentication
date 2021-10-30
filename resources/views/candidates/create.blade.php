@extends('customAuth.dashboard')

@section('content')


	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

@if(count($user_vote->candidate) > 0 )

<div class="alert alert-success" style="text-align: center;">
        <p> You have Already Casted a vote, Thank You </p>
</dir>
 
    
@else 


<div class="container mt-5">   

       <form id="candidate_form" method="POST" enctype= "multipart/form-data">
        @csrf

        <input type="hidden" name="party_id" value="{{$party->id}}" id="party_id">
        <input type="hidden" name="user_id" value="{{auth()->user()->id}}" id="user_id">

        {{-- {{dd(auth()->user()->id)}} --}}
            <div id="alertSucess" class="alert alert-success" style="display: none">

                <p> You have success fully casted a vote thank you</p>
                
            </div>

            <div id="alertDanger" class="alert alert-danger" style="display: none" >
                
            </div>

            <div class="form-group">
                <label>Your Name</label>
                <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}" readonly id="name">
            </div>

            <div class="form-group" id="NIC_form_id">
                <label>NIC (National ID Card # )</label>   
                
                <input type="text" class="form-control" name="candidate_id" id="candidate_id">
            </div>

                <div>
                    <span id="sucessNote" style="color: red"> <b>Note: </b> You can vote only Once. Thank You !</span>
                </div> <br>

            <input type="submit" value="Cast" class="btn btn-dark btn-block">
        </form>


    </div>



@endif

<script type="text/javascript">
    
$(document).ready(function(){
    $('#candidate_form').on('submit', function(e) {
         e.preventDefault();

         $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
                });

        var party_id = $('#party_id').val();
        var user_id = $('#user_id').val();
        var name = $('#name').val();
        var candidate_id = $('#candidate_id').val();

        $('.alert-success').hide();

        $.ajax({

                url: "{{route('candidate.store')}}",
                type: "POST",
                data: {

                    "party_id": party_id,
                    "user_id": user_id,
                    "name": name,
                    "candidate_id": candidate_id
                },
                success: function(data) {
                    
                    // alert('success');
                    document.getElementById("alertSucess").style.display = 'block';
                     $('.btn-block').hide();
                     $('#NIC_form_id').hide();
                     $('#sucessNote').html('vote has been casted, Thank You');
                     $('#alertSucess').fadeIn(2000).fadeOut(5000);

                     stateChange(-1);
                     function stateChange(wait) {
                        setTimeout(function(){
                            if(wait == -1) {

                            window.location=document.referrer;   
                            }
                        }, 4000);
                    }

                },
               error: function(xhr, status, error) {

                         var err = JSON.parse(xhr.responseText);
                         // alert(err);
 
                        if(err.errors.candidate_id != null ){               //means error

                            var swal = JSON.stringify(err.errors.candidate_id).replace(/[\[\]"]+/g, '');

                            // alert(swal);
                            document.getElementById("alertDanger").style.display = 'block';
                            $('#alertDanger').html(swal);
                            $('#alertDanger').fadeIn(5000).fadeOut(5000);

                        }
                },
        });
    });
});


</script>




@endsection