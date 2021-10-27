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

.dropdown .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background-color: red;
  color: white;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {
    background-color: #ddd;
}

.show {
    display: block;
}
</style>

 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


@if(auth()->user()->role == 'admin')

<div style="display: flex;">
<div>
<a class="btn btn-success" href="{{route('party.create')}}"> Add Party </a>

</div>

<div style="margin-left: auto; margin-right: 20% ;">

<div class="dropdown">

  <button onclick="myFunction()" class="dropbtn">
  Notifications
  @if($candidate_delete_request_Noti)

    <span class="badge"> {{count($candidate_delete_request_Noti)}} </span>

  @elseif($candidate_delete_request_Noti == '')

  
  @endif

  </button>

  <div id="myDropdown" class="dropdown-content">
 @if($candidate_delete_request_Noti != '')
  @foreach($candidate_delete_request_Noti as $key => $deleteRequest)
    <a href="{{ url('/candidateIndex/'. $deleteRequest->party_id)}}" target="_blank"> 
        {{-- {{$key}} --}}
        {{-- {{$deleteRequest->delete_request}} --}}
        {{-- {{$deleteRequest->candidate_id}} --}}
        Delete Candidate Request for <b>{{$deleteRequest->Party->name}}</b>  Party.
    </a>
    
@endforeach
@endif

  </div>


</div>




</div>



</div>


<table class="table table-sm">



<thead>
    <th>Party Name</th>
    <th>Party Logo</th>
    <th>Candidates</th>
    <th>Action</th>


</thead>
<tbody>

    @foreach($parties as $party)
        <tr>
            <td>{{$party->name}}</td>
            <td><img src="{{ asset('party_logo/'. $party->party_logo) }}" alt="image" width="100" height="100"></td>
            <td>
                <a class="btn btn-primary" href="{{route('candidate.can_index', [$party->id])}}"> Show Candidates </a>

            </td>
            <td>


          
                <a href="{{ route('party.edit', [$party->id])}}"><i class="fas fa-edit"></i></a>
                <a href="{{ route('party.show', [$party->id])}}"><i class="fas fa-eye"></i></a>

               <meta name="csrf-token" content="{{ csrf_token() }}">
    
                <button class="deleteRecord btn btn-danger" data-id="{{ $party->id }}" > Delete Party </button>



             </td>
        </tr>
    @endforeach

</tbody>

</table>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>


<script type="text/javascript">
    
$(".deleteRecord").click(function(){

    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    var parent = $(this).parent();

      swal({
                      title: "Wait..!",
                      text: "Are You sure, You want to delete Party?",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {

                        if (willDelete) {
    $.ajax({
        url: "delete_party/"+id,
        type: 'DELETE',
        data: {
            "id": id,
            "_token": token,
        },
        success: function (){

                 swal({
                      title: "Good job!",
                      text: "Party Deleted Successfully!",
                      icon: "success",
                      button: "Ok",
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

             swal("Your Party is safe");
       }
});
   
});

</script>



@elseif(auth()->user()->role == 'candidate')


<div style="display: flex;">


<div style="margin-left: auto; margin-right: 0 ;">

       
</div>
</div>

@if( Session::has('success'))
  <div class="alert alert-success">
    <p>{{ Session::get('success') }}</p>
  </div>
  @endif

<table class="table table-sm">



<thead>
    <th> Party Name</th>
    <th> Party Logo</th>
    <th> Cast Your vote </th>
    <th> See Party Details </th>


</thead>
<tbody>

    @foreach($parties as $party)
        <tr>
            <td>{{$party->name}}</td>
            <td><img src="{{ asset('party_logo/'. $party->party_logo) }}" alt="image" width="100" height="100"></td>
            <td><a class="btn btn-primary" href="{{route('candidate.can_index', [$party->id])}}"> Cast Vote </a></td>
            <td>

                <a href="{{ route('party.show', [$party->id])}}"><i class="fas fa-eye"></i></a>

            


             </td>
        </tr>
    @endforeach

</tbody>

</table>


@elseif(auth()->user()->role == 'user') 



<div>
  hello user
</div>






@endif


@endsection