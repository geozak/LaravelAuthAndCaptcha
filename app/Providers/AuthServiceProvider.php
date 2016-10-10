<?php

namespace App\Providers;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Validator;

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
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Validator::extend('recaptcha', function($attribute, $value, $parameters, $validator) {
            $client = new HttpClient(['base_uri' => 'https://www.google.com/recaptcha/api/']);
            $response = $client->post('siteverify',['form_params' => array(
                'secret' => env('RECAPTCHA_SECRET_KEY',''),
                'response' => $value,
                'remoteip' => request()->ip()
                )
                ]);
            $results = json_decode($response->getBody()->getContents());
            return $results->success === true;
        });
    }
}
