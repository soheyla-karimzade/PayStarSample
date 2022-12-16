@extends('dashboard')
@section('content')
<div class="container">
    <div class="row">
        <table class="table table-striped table-hover">
            <tr>
                <th>id</th>
                <th>name</th>
                <th>price</th>
                <th>author</th>
                <th>action</th>
            </tr>
            @foreach($products as $value )
                <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->description}}</td>
                    <td>{{$value->price}}</td>
                    <td>
                        <a href="/product/{{$value->id}}">view</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection