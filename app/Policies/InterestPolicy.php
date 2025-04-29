<?php

namespace App\Policies;

use App\Models\Interest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Interest $interest): bool
    {
        return $user->id === $interest->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Interest $interest): bool
    {
        return $user->id === $interest->user_id;
    }
}
