<?php namespace Barnetik\LaravelLdapAuth;

use Illuminate\Support\ServiceProvider;

class LaravelLdapAuthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

        public function boot()
        {
            \Auth::extend('laravel-simple-ldap', function($app) {
                $ldapService = new Ldap($app->config['ldap']);
                $hasher = new \Illuminate\Hashing\BcryptHasher();
                $provider = new LdapAuthUserProvider($app->config, $ldapService, $hasher);
                return new \Illuminate\Auth\Guard($provider, $app['session.store']);
            });
        }
        
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
            $app = $this->app;
            \App::bind('\\Barnetik\\LaravelLdapAuth\\Ldap', function($app) {
                return new Ldap($app->config['ldap']);
            });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
