@extends('dashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-span-12">
                <form  action="{{route('change-card-number-action')}}"  method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="card_number" placeholder="Enter your card number" value="{{(auth()->user()->card_number)?? ''}}"/>
                    <input type="submit" value="change"/>
                </form>
            </div>
        </div>
    </div>
@endsection
