@extends('customAuth.dashboard')

@section('content')


	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<a class="btn btn-primary" href="{{route('party.index')}}"> Back  </a>

<div class="col-7" style="display: flex; justify-content: center;">

<div class="card" style="width: 18rem;">
    <div style="width: 100%; border: 1px solid darkgrey;text-align: center;">
 <img src="{{asset('party_logo/'. $party->party_logo )}}" width="125px" height="125px"> 
  </div>
  <div class="card-body">
    <h4 class="card-title"> Name: {{$party->name}}</h4>
 
    <p class="card-text">

    Details of the Party: -
    <details>
         <summary>Please click me for the details </summary>
         <br>
         <div style="">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
        </div>

    </details>
    </p>
    <a href="#" class="btn btn-primary">Dummy button</a>
  </div>
</div>
</div>


@endsection