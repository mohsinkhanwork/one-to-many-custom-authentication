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
                <label class="switch">
                  <input id="on_off{{$key}}" type="checkbox" name="publish" value="{{$party->id}}">
                  <div class="slider"></div>
                </label>
                <p id="info{{$key}}"></p>
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
<script type="text/javascript">
    $(document).ready(function(){
    $('#on_off0 ').on('change',function(e){

    e.preventDefault();

     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    var publish = $('#on_off0').val();

        if(this.checked){

            $.ajax({

                  url: "publish/party/"+publish,
                  type: 'GET',
                  data: {

                    "publish": publish,
                  },
                  success: function(data) {

                     swal({
                      title: "Good job!",
                      text: "Party published Successfully!",
                      icon: "success",
                      button: "Ok",
                    });
                  },

                  error: function(data) {

                    alert('error');
                  },

            });

            // $("#info0").text("U checked me, place some code here, 1st id");
        }
        else{
            
            $.ajax({

                  url: "un_publish/party/"+publish,
                  type: 'GET',
                  data: {

                    "publish": publish,
                  },
                  success: function(data) {

                     swal({
                      title: "Good job!",
                      text: "Party Un published Successfully!",
                      icon: "success",
                      button: "Ok",
                    });
                  },

                  error: function(data) {

                    alert('error');
                  },

            });

            // $("#info0").text("U unchecked me, another piece of code here");
         
        }
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $('#on_off1 ').on('change',function(e){

    e.preventDefault();

     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    var publish = $('#on_off1').val();

        if(this.checked){

            $.ajax({

                  url: "publish/party/"+publish,
                  type: 'GET',
                  data: {

                    "publish": publish,
                  },
                  success: function(data) {

                     swal({
                      title: "Good job!",
                      text: "Party published Successfully!",
                      icon: "success",
                      button: "Ok",
                    });

                  },

                  error: function(data) {

                    alert('error');
                  },

            });

            // $("#info0").text("U checked me, place some code here, 1st id");
        } else {

                 $.ajax({

                  url: "un_publish/party/"+publish,
                  type: 'GET',
                  data: {

                    "publish": publish,
                  },
                  success: function(data) {

                     swal({
                      title: "Good job!",
                      text: "Party Un published Successfully!",
                      icon: "success",
                      button: "Ok",
                    });
                  },

                  error: function(data) {

                    alert('error');
                  },

            });

            // $("#info1").text("U unchecked me, another piece of code here");

        }
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $('#on_off2 ').on('change',function(e){

    e.preventDefault();

     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    var publish = $('#on_off2').val();

        if(this.checked){

            $.ajax({

                  url: "publish/party/"+publish,
                  type: 'GET',
                  data: {

                    "publish": publish,
                  },
                  success: function(data) {

                     swal({
                      title: "Good job!",
                      text: "Party published Successfully!",
                      icon: "success",
                      button: "Ok",
                    });
                  },

                  error: function(data) {

                    alert('error');
                  },

            });

            // $("#info0").text("U checked me, place some code here, 1st id");
        }
        else{
            
             $.ajax({

                  url: "un_publish/party/"+publish,
                  type: 'GET',
                  data: {

                    "publish": publish,
                  },
                  success: function(data) {

                     swal({
                      title: "Good job!",
                      text: "Party Un published Successfully!",
                      icon: "success",
                      button: "Ok",
                    });
                  },

                  error: function(data) {

                    alert('error');
                  },

            });

            // $("#info2").text("U unchecked me, another piece of code here");
           
        }
    });
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
    <th> Cast Your vote </th>
    <th> See Party Details </th>


</thead>
<tbody>

    @foreach($publish_parties as $publish_party)
        <tr>
            <td>{{$publish_party->name}}</td>
            <td><img src="{{ asset('party_logo/'. $publish_party->party_logo) }}" alt="image" width="100" height="100"></td>
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