<?php /** @var $post \App\Models\BlogPost */  ?>

<h2>You have been registered in {{ config('app.name') }} application, on {{config('app.url')}}.</h2>
    {{$post->category->title}}
