<?php

namespace App\Policies;

use App\Http\Controllers\DispatchController;
use App\Models\Dispatch;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class DispatchPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        $dispatchUserAbilities = (new DispatchController)->currentDispatchUser()->getData()->grade->abilities;
        $userAbilities = $user->grade->abilities;
        return $userAbilities >= $dispatchUserAbilities;
    }
}
