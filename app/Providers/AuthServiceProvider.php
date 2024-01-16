<?php

namespace App\Providers;

use App\Models\Ngdu;
use App\Models\User;
use App\Policies\WellPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Well;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => WellPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('view-wells', function (User $user) {
            return $user->viewAllWells();
        });

        Gate::define('control-wells', function (User $user) {
            return $user->canEdit();
        });

        Gate::define('view-well', function (User $user, Well $well) {
            return $user->isAdmin() || $user->ngdu_id == $well->Ngdu_Id;
        });

        Gate::define('training', function (User $user) {
            return $user->isAdmin() || $user->isTrainer();
        });
    }
}
