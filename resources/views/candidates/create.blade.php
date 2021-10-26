@extends('customAuth.dashboard')

@section('content')


	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">


 <div class="container mt-5">

        <!-- Success message -->
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif



          @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif

       <form action="{{route('candidate.store')}}" method="POST" enctype= "multipart/form-data">

        <input type="hidden" name="party_id" value="{{$party->id}}">
        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">

        {{-- {{dd(auth()->user()->id)}} --}}


        @csrf


            <div class="form-group">
                <label>Your Name</label>
                <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}" readonly>
            </div>

            <div class="form-group">
                <label>NIC (National ID Card # )</label>   
                
                <input type="text" class="form-control" name="candidate_id">
            </div>
              @error('party_logo')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div>
                    <span style="color: red"> <b>Note: </b> You can vote only Once. Thank You !</span>
                </div> <br>

            <input type="submit" value="Cast" class="btn btn-dark btn-block">
        </form>


{{-- 
<script type="text/javascript">
    document.querySelector('#create-form').addEventListener('submit', (e) => {
  e.preventDefault();
  var formData = new FormData(e.target);
  fetch("{{ route('candidate.store') }}", { 
    method: 'POST',
    body: formData
  }).then(() => console.log('success'));
});
</script> --}}



    </div>
@endsection