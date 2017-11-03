@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h2>{{$quote->title}}</h2>
        <p>{{$quote->subject}}</p>
        <p>ditulis oleh: <a href="/profile/{{$quote->user->id}}">{{$quote->user->name}}</a> </p>

        <p><a href="/quotes" class="btn btn-primary btn-lg">Daftar Quotes</a></p>

        @if ($quote->isOwner())
                <p><a href="/quotes/{{$quote->id}}/edit" class="btn btn-warning btn-md">Edit</a></p>
                <form method="POST" action="/quotes/{{$quote->id}}">
                        {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
        @endif
    </div>

    @foreach($quote->comments as $comment)
        <h4>{{$comment->subject}}</h4>
        <p>ditulis oleh: <a href="/profile/{{$comment->user->id}}">{{$comment->user->name}}</a> pada: {{$comment->created_at}} </p>
        <hr>
    @endforeach
 

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/quotes-comment/{{$quote->id}}">
        <div class="form-group">
            <label for="subject">Isi Komentar</label>
            <textarea name="subject" rows="8" cols="80" class="form-control">{{old('subject')}}</textarea>
        </div>

        {{ csrf_field() }}

        <button type="submit" class="btn btn-default btn-block">Komentar</button>     
    </form>

</div>
@endsection
