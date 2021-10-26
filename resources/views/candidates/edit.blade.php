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

       <form action="{{route('candidate.update', [$candidate->id])}}" method="POST" enctype= "multipart/form-data">

        <input type="hidden" name="party_id" value="{{$party->id}}">

        @method('PUT')

   @csrf

            <div class="form-group">
                <label>Candidate Name</label>
                <input type="text" class="form-control" name="name" value="{{$candidate->name}}">
            </div>

            <div class="form-group">
                <label>Candidate Party Id</label>   
                
                <input type="text" class="form-control" name="candidate_id" value="{{$candidate->candidate_id}}">
            </div>
              @error('candidate_id')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror

            <input type="submit" value="Update" class="btn btn-dark btn-block">
        </form>
    </div>
    
@endsection