@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h2>{{$user->name}}</h2>
            <ul class="list-group">
                @foreach($user->quotes as $quote)

                    <li class="list-group-item"> <a href="/quotes/{{$quote->slug}}">{{$quote->title}}</a> </li>
                
                @endforeach
            </ul>
        </div> 
    </div>
</div>
@endsection
