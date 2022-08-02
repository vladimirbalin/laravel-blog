<a class="text-black text-decoration-dotted {{ $isActive($sortBy) ? 'active-sort' : '' }}"
   href="{{ route($baseRouteName, \Arr::collapse([
                                                    request()->query(),
                                                     ['sort' => $sortBy]
                                                 ]
                                    ))
        }}">
    {{ $slot }}
</a>
