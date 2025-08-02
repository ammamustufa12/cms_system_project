<?php

namespace App\Observers;

use A17\Twill\Models\User;
use App\Helpers\ActivityLogger;

class UserObserver
{
    public function created(User $user)
    {
        ActivityLogger::log('created', $user, "User '{$user->name}' created.");
    }

    public function updated(User $user)
    {
        $changes = $user->getChanges();
        ActivityLogger::log('updated', $user, "User '{$user->name}' updated.", $changes);
    }

    public function deleted(User $user)
    {
        ActivityLogger::log('deleted', $user, "User '{$user->name}' deleted.");
    }
}
