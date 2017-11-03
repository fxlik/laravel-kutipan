@extends('layouts.app')

@section('content')
<div class="container">

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/quotes">
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" class="form-control" value="{{old('title')}}" placeholder="Judul Quote">
        </div>
        <div class="form-group">
            <label for="subject">Isi Kutipan</label>
            <textarea name="subject" rows="8" cols="80" class="form-control">{{old('subject')}}</textarea>
        </div>

        {{ csrf_field() }}

        <button type="submit" class="btn btn-default btn-block">Submit</button>
    </form>
</div>
@endsection
