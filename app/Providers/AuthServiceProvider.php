<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Employee;
use App\Models\EmployeeAcademicRecords;
use App\Models\EmployeeBioData;
use App\Models\EmployeeGuarantors;
use App\Models\EmployeeNextOfKins;
use App\Models\User;
use App\Policies\Api\V1\EmployeeAcademicRecordsPolicy;
use App\Policies\Api\V1\EmployeeBioDataPolicy;
use App\Policies\Api\V1\EmployeeGuarantorsPolicy;
use App\Policies\Api\V1\EmployeeNextOfKinsPolicy;
use App\Policies\Api\V1\EmployeePolicy;
use App\Policies\Api\V1\UserAsEmployeePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Employee::class => EmployeePolicy::class,
        EmployeeAcademicRecords::class => EmployeeAcademicRecordsPolicy::class,
        EmployeeBioData::class => EmployeeBioDataPolicy::class,
        EmployeeGuarantors::class => EmployeeGuarantorsPolicy::class,
        EmployeeNextOfKins::class => EmployeeNextOfKinsPolicy::class,
        User::class => UserAsEmployeePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
