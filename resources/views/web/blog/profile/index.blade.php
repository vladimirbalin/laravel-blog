@extends('layouts.web')
@section('content')
    <div class="container">
        <x-session-message/>
        <h2 class="font-weight-bold text-center mb-5">User Details</h2>
        <div class="main d-flex justify-content-center text-center">
            <div class="left w-50">
                <ul class="list-group m-2">
                    <li class="list-group-item"><span>Name:</span> <b>{{ $profile->fullName }}</b></li>
                    <li class="list-group-item"><span>Phone:</span> <b>{{ $profile->phone }}</b></li>
                    <li class="list-group-item"><span>Email:</span> <b>{{ $profile->email }}</b></li>
                </ul>

                @php /** @var $currentUser \App\Models\User */
                    $currentUser = auth()->user(); @endphp

                @if($currentUser->id == $profile->id)
                    <a href="{{route('blog.profile.edit', $profile->id)}}"
                       class="btn btn-dark">Edit Profile</a>
                @elseif($currentUser->id != $profile->id && $currentUser->isFollow($profile->id))
                    <form action="{{ route('blog.profile.unfollow', $profile->id) }}"
                          method="post">
                        @csrf
                        @method('delete')
                        <button type="submit"
                                class="btn btn-sm btn-outline-primary follow">unfollow
                        </button>
                    </form>
                @elseif($currentUser->id != $profile->id && $currentUser->isNotFollow($profile->id))
                    <form action="{{ route('blog.profile.follow', $profile->id) }}"
                          method="post">
                        @csrf
                        <button type="submit"
                                class="btn btn-sm btn-outline-primary follow">follow
                        </button>
                    </form>
                @endif
            </div>
            <div class="right">
                <ul class="list-group m-2">
                    <li class="list-group-item-dark list-group-item">Follows:</li>
                    @foreach($profile->followedUsers as $user)
                        <li class="list-group-item">
                            <a class="text-decoration-none badge rounded-pill bg-light text-dark"
                               href="{{route('blog.profile.show', $user->id)}}">
                                {{ $user->fullName }}
                            </a>
                            @if(auth()->user()->id == $profile->id)
                                @include('web.blog.profile._follow-btn')
                            @endif
                        </li>
                    @endforeach
                </ul>
                <ul class="list-group">
                    <li class="list-group-item-dark list-group-item">
                        Followers
                    </li>
                    @if($profile->followers->isNotEmpty())
                        @foreach($profile->followers as $user)
                            <li class="list-group-item">
                                <a class="text-decoration-none badge rounded-pill bg-light text-dark"
                                   href="{{route('blog.profile.show', $user->id)}}">
                                    {{ $user->fullName }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">
                            No followers :(
                        </li>
                    @endif
                </ul>
            </div>
        </div>


    </div>
@endsection
