@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Dashboard</h3>
            </div>
            <div class="card-body">
                {{-- <h5>Welcome to User Dashboard, <strong>{{ Auth::user()->name }}</strong></h5> --}}
                <div class="form-group">
                    <label for="txt-token">Token: Please save token somewhere</label>
                    <textarea class="form-control" id="txt-token" rows="4"></textarea>
                </div>
                <div class="form-group text-right">
                  <button type="button" class="btn btn-dark" onclick="generateToken()">Generate Token</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    generateToken = () => {
        $.ajax({
        url: "{{route('generate_token')}}",
        type:"GET",
        success:function(response){
          $('#txt-token').html(response.token)
        },
       });
    }
</script>
@endsection
