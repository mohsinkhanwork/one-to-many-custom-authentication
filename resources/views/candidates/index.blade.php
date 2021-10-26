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

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>

<style>


.topnav .search-container {
  float: right;
}

.topnav input[type=search] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px;
  margin-top: 8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  background: #ccc;
}


</style>


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@if(auth()->user()->role == 'admin')

	<div style="display: flex;">
<div>
<a class="btn btn-success" href="{{route('party.index')}}"> Main Page </a>
</div>
{{-- @if($candidate_delete_request != '') --}}
<div class="topnav">
 <div class="search-container">
    <form action="{{ route('candidate.searchCanId') }}" method="post"> @csrf
      <input type="search" placeholder="Enter Full Name of Candidate" name="q" required="true">
      <button type="submit"> Search </button>
    </form>
  </div>
</div>
{{-- @endif --}}


<div style="margin-left: auto; margin-right: 20% ;">

<div class="dropdown">
  <button onclick="myFunction()" class="dropbtn">
   Show Delete Request ID's 
    @if($candidate_delete_request)

    <span class="badge"> {{count($candidate_delete_request)}} </span>

     @elseif($candidate_delete_request == '')

  
  @endif

</button>

  <div id="myDropdown" class="dropdown-content">
 @if($candidate_delete_request != '')
  @foreach($candidate_delete_request as $key => $deleteRequest)
    <a href="{{ url('/candidateIndex/'. $deleteRequest->party_id)}}" > 
        {{-- {{$key}} --}}
        {{$deleteRequest->delete_request}}
        {{-- {{$deleteRequest->candidate_id}} --}}
        {{-- Delete Candidate Request for <b>{{$deleteRequest->Party->name}}</b>  Party. --}}
    </a>
    
@endforeach
@endif

  </div>


</div>




</div>
</div>
	
	
<div style="display: flex;">
<div style="width: 50%;text-align: right;margin-right: 10%;">
	<h1>Party Name</h1>
	<p>{{$party->name}}</p>
</div>


<div style="width: 50%;text-align: left;">
	<h1>Party Logo</h1>
	<p><img src="{{ asset('party_logo/'. $party->party_logo) }}" alt="image" width="150" height="150"></p>
</div>
</div>
@if( Session::has('success'))
  <div class="alert alert-success">
    <p>{{ Session::get('success') }}</p>
  </div>
  @endif

<table class="table table-sm">



<thead>
    <th>#</th>
    <th>Candidates</th>
    <th>Candidate ID</th>
    <th>Email</th>
    <th>Action</th>
    

</thead>
<tbody>
    
    @php $i=1; @endphp
@foreach($candidates as $candidate)
        <tr>
            <td>{{$i}}</td> 
            <td>{{$candidate->name}}</td>
            <td>{{$candidate->candidate_id}}</td>
            <td>{{$candidate->user->email}}</td>
            
            <td>

            <form action="{{ route('candidate.destroy', [$candidate->id])}}" method="POST">@csrf
                @method('DELETE')
                {{-- <a href="{{ route('candidate.can_edit', [$candidate->id, $party->id])}}"><i class="fas fa-edit"></i></a> --}}

                <a href="{{ route('candidate.show', [$candidate->id])}}"><i class="fas fa-eye"></i></a>

             <button type="submit" title="delete" style="border: none; background-color:transparent;">
                <i class="fas fa-trash fa-lg text-danger"></i>

            </button>
                

            </form>


             </td> 
        </tr>
 @php $i++; @endphp
@endforeach
  
</tbody>

</table>

</div>

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

@elseif(auth()->user()->role == 'candidate')


    <div style="display: flex;">
<div>

{{-- {{dd(auth()->user()->id)}} --}}


@if(count($user_vote->candidate) > 0)

<a class="btn btn-success" href="#"> You have casted a vote, Thank You </a>

@else

<a class="btn btn-success" href="{{route('candidate.CreateCandidate', [$party->id])}}"> Cast a vote </a>

@endif

<a class="btn btn-success" href="{{route('party.index')}}"> Go to Main Page </a>

</div>

<div style="margin-left: auto; margin-right: 0 ;">

   
</div>
</div>
    
    
<div style="display: flex;">
<div style="width: 50%;text-align: right;margin-right: 10%;">
    <h1>Party Name</h1>
    <p>{{$party->name}}</p>
</div>


<div style="width: 50%;text-align: left;">
    <h1>Party Logo</h1>
    <p><img src="{{ asset('party_logo/'. $party->party_logo) }}" alt="image" width="150" height="150"></p>
</div>
</div>
@if( Session::has('success'))
  <div class="alert alert-success">
    <p>{{ Session::get('success') }}</p>
  </div>
  @endif

<table class="table table-sm">



<thead>
    <th>#</th>
    <th>Your Name</th>
    <th>Candidate ID</th>
    <th>Action</th>
    

</thead>
<tbody>
    
    @php $i=1; @endphp
@if($user_candidates_only != '')
        <tr>
            <td>{{$i}}</td> 
            <td>{{$user_candidates_only->name}}</td>
            <td>{{$user_candidates_only->candidate_id}}</td>
            
            <td>

        
                <a href="{{ url('/request-for-deletion/'. $user_candidates_only->candidate_id) }}">Request Deleteion</a>
                | <a href="{{ route('candidate.show', [$user_candidates_only->id])}}"><i class="fas fa-eye"></i></a>



             </td> 
        </tr>
@endif
 @php $i++; @endphp

  
</tbody>

</table>

</div>


@endif


@endsection

