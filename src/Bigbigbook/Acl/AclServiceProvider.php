<?php namespace Bigbigbook\Acl;

use Illuminate\Support\ServiceProvider;

use Bigbigbook\Acl\Acl;
use Bigbigbook\Acl\Command;
use Bigbigbook\Acl\Laravel\LaravelAclPersistenceService;

class AclServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('bigbigbook/acl');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerAcl();
	}
    
    /**
	 * Register the ACL service provider.
	 *
	 * @return void
	 */
    protected function registerAcl()
	{
		$this->app['acl'] = $this->app->share(function($app)
		{
			return new Acl(
				new LaravelAclPersistenceService('acl', Command::GRANT, Command::GRANT)
			);
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
