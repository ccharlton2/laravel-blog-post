<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    // compare the id of the user passed in to the one that owns the post
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
