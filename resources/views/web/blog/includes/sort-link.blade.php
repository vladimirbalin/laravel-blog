<a class="link-primary text-decoration-none"
   href="{{ route($baseRouteName, \Arr::collapse(
                                            [request()->query(),
                                            ['sort' => $sortBy]]
                                           ))
         }}">{{ $linkText }}</a>
