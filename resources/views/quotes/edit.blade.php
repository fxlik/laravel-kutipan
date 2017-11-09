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

    <form method="POST" action="/quotes/{{$quote->id}}">
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" class="form-control" 
                value="{{(old('title')) ? old('title') : $quote->title}}" placeholder="Judul Quote">
        </div>
        <div class="form-group">
            <label for="subject">Isi Kutipan</label>
            <textarea name="subject" rows="8" cols="80" class="form-control">{{(old('subject')) ? old('subject') : $quote->subject}}</textarea>
        </div>

        <div id="tag_wrapper">
            <label for="">Tag (maximal 3)</label>
            <div id="add_tag">Add tag</div>

            @foreach($quote->tags as $oldtags)
                <select name="tags[]" id="tag_select">
                    <option value="0">Tidak ada</option>
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}" 
                            @if ($oldtags->id == $tag->id)
                                selected="selected"
                            @endif
                            > {{$tag->name}} w</option>
                    @endforeach
                </select>
            @endforeach

            <script src="{{ asset('js/tag.js') }}" type="text/javascript"></script>
        </div>
        <br>

        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">

        <button type="submit" class="btn btn-primary btn-block">Edit Kutipan</button> <br>
        <p><a href="/quotes/{{$quote->slug}}" class="btn btn-warning btn-block">Batal</a></p>
    </form>
</div>
@endsection
