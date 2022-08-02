<div class="dropdown">
    <button class="btn btn-outline-primary dropdown-toggle"
            type="button"
            id="dropdownMenuButton"
            data-coreui-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        @php echo request()->get('category') ?? "Categories" @endphp
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @foreach($categoryDropdown as $category)
            <a class="dropdown-item
                           @if($category->slug === request()->get('category')) active @endif"
               href="{{ route('blog.posts.index',
                                            \Arr::collapse([request()->query(),
                                            ['category' => $category->slug]]))
                                 }}">
                {{ $category->title }}
            </a>
        @endforeach
    </div>
</div>
