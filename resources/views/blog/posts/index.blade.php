<table>
    @foreach($items as $post)
        <tr>
            <td>{{$post->id}}</td>
            <td>{{$post->title}}</td>
        </tr>
    @endforeach
</table>
