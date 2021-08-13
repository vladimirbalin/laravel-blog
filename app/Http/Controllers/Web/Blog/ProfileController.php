<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function show(User $profile)
    {
        return view('web.blog.profile.index', compact('profile'));
    }

    public function edit(User $profile)
    {
        return view('web.blog.profile.edit', compact('profile'));
    }

    public function update(ProfileUpdateRequest $request, User $profile)
    {
        $profile->fill($request->input());
        $profile->save();

        return redirect()->route('blog.profile.show', $profile->id);
    }
}