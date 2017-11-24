<?php

namespace App\Policies;

use App\User;
use App\Models\Demand;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the demand.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Demand  $demand
     * @return mixed
     */
    public function view(User $user, Demand $demand)
    {
        //
    }

    /**
     * Determine whether the user can create demands.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the demand.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Demand  $demand
     * @return mixed
     */
    public function update(User $user, Demand $demand)
    {
        return $user->id === $demand->onwer->id;
    }

    /**
     * Determine whether the user can delete the demand.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Demand  $demand
     * @return mixed
     */
    public function delete(User $user, Demand $demand)
    {
        //
    }
}
