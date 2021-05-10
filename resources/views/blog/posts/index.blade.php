@extends('layouts.app')

@section('content')
    <table class="m-auto">
        @foreach($items as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
            </tr>
        @endforeach
    </table>
@endsection
