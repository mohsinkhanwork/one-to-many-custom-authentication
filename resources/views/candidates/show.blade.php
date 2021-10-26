@extends('customAuth.dashboard')

@section('content')

	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">



<div class="col-7" style="display: flex; justify-content: center;">

<div class="card" style="width: 18rem;">
   
  <div class="card-body">
    <h4 class="card-title"> Name: {{$candidate->name}}</h4>
    <h3 class="card-title"> ID: {{$candidate->candidate_id}}</h3>
 
    <p class="card-text">

    Details of the Candidate <span style="font-weight: bold;">(confidential)</span> :-
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