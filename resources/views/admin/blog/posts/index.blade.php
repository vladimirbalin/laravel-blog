@extends('layouts.admin')

@section('content')
    <div class="container content">
        <x-session-message/>
        <table class="table table-sm table-hover">
            <thead>
            <tr style="background-color: #afc2e8">
                <th>#</th>
                <th>Author</th>
                <th>Category</th>
                <th>Title</th>
                <th>Is published</th>
                <th>Published at</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($paginator as $post)
                @php /** @var \App\Models\BlogPost $post */ @endphp
                <tr data-post-id="{{$post->id}}"
                    @if($post->isNotPublished()) style="background-color: #ececec" @endif>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->category->title }}</td>
                    <td>
                        <a class="link-info text-decoration-none" href="{{ route('admin.blog.posts.edit', $post->id) }}">
                            {{ \Illuminate\Support\Str::limit($post->title, 30) }}
                        </a>
                    </td>
                    <td>
                        <label class="switch">
                            <input type="checkbox"
                                   name="status"
                                   class="pt-2 status"
                                   data-route="{{ route('admin.blog.posts.ajax', $post->id) }}"
                                   @if($post->isPublished()) checked="checked" @endif>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td class="published_at">{{ $post->getPublishedAtShortened() ?? 'Not published' }}</td>
                    <td>
                        <a href="{{ route('admin.blog.posts.edit', $post->id) }}"
                           class="btn btn-outline-dark btn-sm mx-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-pencil" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.blog.posts.destroy', $post->id)  }}"
                           onclick="event.preventDefault();
                               document.getElementById('destroy-post-form-{{$post->id}}').submit();"
                           class="btn btn-danger btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.blog.posts.destroy', $post->id) }}"
                              method="POST"
                              id="destroy-post-form-{{ $post->id }}">
                            @method('DELETE')
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            @php /** @var \Illuminate\Pagination\Paginator $paginator */ @endphp
            @if($paginator->total() > $paginator->count())
                {{ $paginator }}
            @endif
            <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary">Create post</a>
        </div>
    </div>
@endsection
