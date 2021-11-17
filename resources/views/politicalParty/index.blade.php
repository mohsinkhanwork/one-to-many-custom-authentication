@extends('customAuth.dashboard')

@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
     


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

                         <div class="form-group mb-3">
                                
                                <select name="country" id="countySel" size="1">
                                <option value="" selected="selected">Select Country</option>
                                </select>
                  
                            </div>

                             <div class="form-group mb-3">

                            <select name="state" id="stateSel" size="1" >
                            <option value="" selected="selected">Please select Country first</option>
                            </select>
                   
                            </div>
                             <br>
                            <br>
                            <br>

                            <div class="row">

<input type="text" list="browsers" id="myBrowser" style="width: 100%; height: 48px; padding: 0 !important;" name="myBrowser" 

onkeydown = "if (event.keyCode == 13) window.location= '/search_party_name/' + this.value"/>
                                     
                                        <datalist id="browsers">
                                        @foreach($parties as $party)
                                          <option value="{{$party->name}}"> 
                                        @endforeach
                                        </datalist>
                                
                            </div>

                            <div>

                        <button onclick="searchfunc()" class="btn btn-primary">search</button>
                                
           <script type="text/javascript">
                    function searchfunc() {
                             var searchfunc1 =  $("[list='browsers']").val();

                             // console.log(searchfunc1);

                                window.location =  '/search_party_name/' + searchfunc1 
                              
                            
                            }
           </script>
                                
                            </div>

                            <br>
                            <br>
                            <br>


<table class="table table-sm">



<thead>
    <th>Party Name</th>
    <th>Party Logo</th>
    <th>Party Leader</th>
    <th>Candidates</th>
    <th> Publish </th>
    <th>Action</th>


</thead>
<tbody>

    @foreach($parties as $key => $party)
        <tr>
            <td>{{$party->name}}</td>
            <td><img src="{{ asset('party_logo/'. $party->party_logo) }}" alt="image" width="100" height="100"></td>
            <td>
                {{$party->party_leader}}
            </td>
            <td>
                <a class="btn btn-primary" href="{{route('candidate.can_index', [$party->id])}}"> Show Candidates </a>

            </td>
            <td>
                {{-- <span>

                <i class="fas fa-toggle-on fa-3x" style="color: blue;"></i>
                    
                </span>
                <span>
                <i class="fas fa-toggle-off fa-3x" style="color: black;"></i>
                    
                </span> --}}

<input data-id="{{$party->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $party->publish ? 'checked' : '' }}>
                     

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

<div class="container mt-5">
    <h2 class="mb-4">All Users List</h2>
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>role</th>
                <th>country</th>
                <th>State</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript">
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('students.list') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {data: 'country', name: 'country'},
            {data: 'state', name: 'state'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>


<script type="text/javascript">
    
    $(function() {
    $('.toggle-class').change(function() {
        var publish = $(this).prop('checked') == true ? 1 : 0; 
        var party_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/publish_party/',
            data: {'publish': publish, 'party_id': party_id},
            success: function(data){
              
              // alert('suuceess');

              if(publish == 1) {

                swal({
                      title: "Good job!",
                      text: "Party published Successfully!",
                      icon: "success",
                      button: "Ok",
                    });

              } else {

                swal({
                      title: "success!",
                      text: "Party Un published Successfully!",
                      icon: "warning",
                      button: "Ok",
                    });

              }
                
            },

            error: function(data) {

                alert('error');

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
        
    // console.log(countySel.value);

    var countryValue = countySel.value;

    $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
                });
     $.ajax({
        type:'POST',
        url:"{{ route('update_admin_country') }}",
        data:{'country':countryValue},
        success:function(data){

            swal({
                      title: "Good job!",
                      text: "Country Updated Successfully",
                      icon: "success",
                      button: "Ok",
                    });
        }
    });

    for (var state in stateObject[this.value]) {

    stateSel.options[stateSel.options.length] = new Option(state, state);


}

}

countySel.onchange(); // reset in case page is reloaded
  
    stateSel.onchange = function () {
    if (this.selectedIndex < 1) 

    return; // done

    // console.log(stateSel.value); 

    var stateValue = stateSel.value;

    $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
                });
     $.ajax({
        type:'POST',
        url:"{{ route('update_admin_state') }}",
        data:{'state':stateValue},
        success:function(data){
            swal({
                      title: "Good job!",
                      text: "City updated Successfully",
                      icon: "success",
                      button: "Ok",
                    });
        }
    });


}

});
</script>


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

            alert('error, Please Refresh the page');
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
    <th> Party Leader </th>
    <th> Cast Your vote </th>
    <th> See Party Details </th>


</thead>
<tbody>

    @foreach($publish_parties as $publish_party)
        <tr>
            <td>{{$publish_party->name}}</td>
            <td><img src="{{ asset('party_logo/'. $publish_party->party_logo) }}" alt="image" width="100" height="100"></td>
            <td>{{$publish_party->party_leader}}</td>
            <td><a class="btn btn-primary" href="{{route('candidate.can_index', [$publish_party->id])}}"> Cast Vote </a></td>
            <td>

                <a href="{{ route('party.show', [$publish_party->id])}}"><i class="fas fa-eye"></i></a>

        

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