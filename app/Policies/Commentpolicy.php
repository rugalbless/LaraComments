<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class Commentpolicy
{

    public function update(User $user, Comment $comment): bool
    {
        return $comment->user()->is($user);
    }
    public function delete(User $user, Comment $comment): bool
    {
        return $comment->user()->is($user);
    }

}





