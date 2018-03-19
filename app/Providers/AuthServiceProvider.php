<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('delete-thread', function($user, $thread) {
            return $user->id == $thread->user_id;
        });

        $gate->define('update-reply', function($user, $reply) {
            return $user->id == $reply->user_id;
        });

        $gate->define('mark-reply', function($user, $thread) {
            return $user->id == $thread->user_id;
        });

        $gate->define('upload-photo', function($user, $profile) {
        return $user->id == $profile->id;
        });

        //
    }
}
