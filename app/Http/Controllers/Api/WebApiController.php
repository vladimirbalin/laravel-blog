<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class WebApiController extends Controller
{
    public function toggleLike(
        Request  $request,
        BlogPost $post
    ): array
    {
        if (! $request->ajax()) {
            throw new BadRequestException('You can only make ajax requests to this route');
        }

        $post = $post->toggleLike();

        return [
            'success' => true,
            'count' => $post->likesCount
        ];
    }
}
