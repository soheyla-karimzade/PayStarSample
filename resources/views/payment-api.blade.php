@extends('dashboard')
@section('content')
    <form  id='paymentApiForm' action="{{$redirect_url}}"  method="{{$redirect_url_method}}">
        {{ csrf_field() }}
        <input type="text" name="token" value="{{$redirect_params}}">
        <input type="submit" value="send">
    </form>
@endsection
@section('script')
<script>
    $(function(){
        $(document).ready(function() {
            $("#paymentApiForm").submit();
        });
    });
</script>
@endsection