<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/7/007 16:33
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Dawn\Auth\auth;

use InvalidArgumentException;

trait CreatesUserProviders
{
    /**
     * The registered custom provider creators.
     *
     * @var array
     */
    protected $customProviderCreators = [];

    /**
     * Create the user provider implementation for the driver.
     *
     * @param  string|null $provider
     * @return \Illuminate\Contracts\Auth\UserProvider|null
     *
     * @throws \InvalidArgumentException
     */
    public function createUserProvider($provider = null)
    {


        if (is_null($config = $this->getProviderConfiguration($provider))) {
            return;
        }
        $driver = $config['driver'];
        switch ($driver) {
            case 'database':
                return;
                return $this->createDatabaseProvider($config);
            case 'eloquent':
                return $this->createEloquentProvider($config);
            default:
                throw new InvalidArgumentException(
                    "Authentication user provider [{$driver}] is not defined."
                );
        }
    }

    /**
     * Get the user provider configuration.
     *
     * @param  string|null $provider
     * @return array|null
     */
    protected function getProviderConfiguration($provider)
    {
        if ($provider = $provider ?: $this->getDefaultUserProvider()) {
            return $this->app->config("auth.providers.$provider");
        }
    }

    /**
     * Create an instance of the database user provider.
     *
     * @param  array $config
     * @return \Illuminate\Auth\DatabaseUserProvider
     */
    protected function createDatabaseProvider($config)
    {
//        $connection = $this->app['db']->connection();
//
//        return new DatabaseUserProvider($connection, $this->app['hash'], $config['table']);
    }

    /**
     * Create an instance of the Eloquent user provider.
     *
     * @param  array $config
     * @return \Illuminate\Auth\EloquentUserProvider
     */
    protected function createEloquentProvider($config)
    {
        return new $config['model'];
    }

    /**
     * Get the default user provider name.
     *
     * @return string
     */
    public function getDefaultUserProvider()
    {
        return $this->app->config("auth.defaults.provider");
    }
}