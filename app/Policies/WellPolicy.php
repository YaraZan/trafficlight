<?php

namespace App\Policies;

use App\Models\Ngdu;
use App\Models\User;
use App\Models\Well;
use Illuminate\Auth\Access\Response;

class WellPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->viewAllWells();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Well $well): bool
    {
        return $user->isAdmin() || $user->ngdu_id == $well->Ngdu_Id;
    }

}
