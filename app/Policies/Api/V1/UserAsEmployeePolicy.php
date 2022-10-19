<?php

namespace App\Policies\Api\V1;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserAsEmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function mustEmployee(User $user)
    {
        //
        return $user->role === "Employee"  ? Response::allow() : Response::deny('You do not have access permission',403);
    }
}
