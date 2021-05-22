@php /** @var \Illuminate\Support\ViewErrorBag $errors */ @endphp

{{--        Session message start --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show my-4" role="alert">
        @foreach($errors->all() as $error)
            <span>{{$error}}</span><br>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show my-4" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
{{--        Session message end --}}