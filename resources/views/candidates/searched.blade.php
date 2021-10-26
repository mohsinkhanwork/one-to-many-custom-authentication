@extends('customAuth.dashboard')

@section('content')

    <style>
.dropbtn {
  background-color: #3498DB;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  width: 456px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>




	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@if(auth()->user()->role == 'admin')

	<div style="display: flex;">
<div>
<a class="btn btn-success" href="{{route('party.index')}}"> Main Page </a>
</div>




</div>
	
   {{--  <div style="display: flex;">
<div style="width: 50%;text-align: right;margin-right: 10%;">
    <h1>Party Name</h1>
    @isset($candidate_id)
    @foreach($candidate_id as $candidate_idd)
    <p>{{$candidate_idd->Party->name}}</p>
    @endforeach
    @endisset
</div>


<div style="width: 50%;text-align: left;">
    <h1>Party Logo</h1>
    @isset($candidate_id)
    @foreach($candidate_id as $candidate_idd)
    <p><img src="{{ asset('party_logo/'. $candidate_idd->Party->party_logo) }}" alt="image" width="150" height="150"></p>
    @endforeach
    @endisset
</div>
</div> --}}

@if( Session::has('success'))
  <div class="alert alert-success">
    <p>{{ Session::get('success') }}</p>
  </div>
  @endif

   <div class="alert alert-success deleted_searched">
    <p></p>
  </div>

<table class="table table-sm">



<thead>
    <th>#</th>
    <th>Candidate Name</th>
    <th>Candidate ID</th>
    <th>Party</th>
    <th>Action</th>
    

</thead>
<tbody>
    
    @php $i=1; @endphp
@if($candidate_id != '')
    @foreach($candidate_id as $candidate_idd)
        <tr>
            <td>{{$i}}</td> 
            <td>{{$candidate_idd->name}}</td>
            <td>{{$candidate_idd->candidate_id}}</td>
            <td>{{$candidate_idd->Party->name}}</td>
            
            <td>






               <meta name="csrf-token" content="{{ csrf_token() }}">

                  <button class="delete_candidate btn btn-danger" data-id="{{ $candidate_idd->id }}"> delete candidate </button>    

             </td> 
        </tr>
 @php $i++; @endphp
 @endforeach
@endif
  
</tbody>

</table>



@endif

<script type="text/javascript">

$(".delete_candidate").click(function(){

  var id = $(this).data("id");
  var token = $("meta[name='csrf-token']").attr("content");
  var parent = $(this).parent();

  swal({

                title: "Wait..!",
                text: "are you sure ? ",
                icon: "warning",
                buttons: true,
                dangerMode: true,   
              }).then((willdelete) => {

                if (willdelete) {


                  $.ajax({
                      url: "delete_candidate/"+id,
                      type: 'DELETE',
                      data: {

                        "id": id,
                        "_token": token
                      },
                      success: function() {

                        swal({

                          title: "Great..!",
                          text: "you have deleted the candidate successfully",
                          icon: "success",
                          button: "OK", 

                        });

                         parent.slideUp(300, function () {
                         parent.closest("tr").remove();
                         });

                      },
                      error: function() {

                        alert('error');
                      },
                  });

                } else {

                  swal("Good, Your candidate is safe");
                }

              }); 
});
  


</script>


@endsection

