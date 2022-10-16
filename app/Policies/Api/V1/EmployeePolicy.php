<?php

namespace App\Policies\Api\V1;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    use HandlesAuthorization;

    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
        return $user->role == "HR" || $user->role == "ADMIN" ? Response::allow() : Response::deny('You do not have access permission',403);
    }



    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        //

        return $user->role == "HR" || $user->role == "ADMIN" ? Response::allow() : Response::deny('You do not have access permission',403);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        return $user->role == "HR" || $user->role == "ADMIN" ? Response::allow() : Response::deny("You do not have access permission",403);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Employee $employee)
    {
        //
        return $user->role == "HR" || $user->role == "ADMIN" ? Response::allow() : Response::deny("You do not have access permission",403);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Employee $employee)
    {
        //
        return $user->role == "HR" || $user->role == "ADMIN" ? Response::allow() : Response::deny("You do not have access permission",403);
    }

    public function restoreActive(User $user, Employee $employee)
    {
        //
        return $user->role == "HR" || $user->role == "ADMIN" ? Response::allow() : Response::deny("You do not have access permission",403);
    }
}