@extends('dashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-span-12">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>description</th>
                        <th>price</th>
                    </tr>
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->price}}</td>
                        </tr>
                </table>

                <div style="border: 1px blue; padding:20px ">
                   <b>your card number : {{auth()->user()->card_number ?? ''}}</b>
                </div>
                <form  action="{{route('payment.buy', $product->id)}}"  method="POST">
                    {{ csrf_field() }}
                    <input type="submit" value="BUY">
                </form>
            </div>
        </div>
    </div>

@endsection