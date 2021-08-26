<?php

namespace App\Http\Controllers\Web\Blog;

use App\Events\UserFollowedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('blog.profile.show', $profile->id)->with(['success' => 'All is ok']);
    }

    public function follow($id)
    {
        $currentUser = Auth::user();
        $followedUser = User::find($id);

        if ($currentUser->isNotFollows($id)) {
            $currentUser->followUser($id);
            event(new UserFollowedEvent($currentUser, $followedUser));

            return back()->with(['success' => "You are now following {$followedUser->name}!"]);
        }
        return back()->withErrors(["You are already following {$followedUser->name}."]);
    }

    public function unfollow($id)
    {
        $currentUser = Auth::user();
        $unfollowedUser = User::find($id);

        if ($currentUser->isFollows($id)) {
            $currentUser->unfollowUser($id);
            return back()->with(['success' => "You are no longer following {$unfollowedUser->name}"]);
        }

        return back()->withErrors(["You cant unfollow user, whom you are not following"]);
    }

    public function notifications()
    {
        return [
            'lastFive' => auth()->user()->unreadNotifications()
                ->limit(5)->get()->sortBy('created_at')->keyBy((function () {
                    global $val;
                    return (int)$val++;
                }))->toArray(),

            'count' => auth()->user()->unreadNotifications()->count()
        ];
    }

    public function markAsReadAllNotifications()
    {
        auth()->user()->unreadNotifications()->get()->markAsRead();
        return back();
    }
}
