<?php

namespace Dawn\Auth\auth;


use http\Exception\InvalidArgumentException;
use think\App;

class AuthManager
{
    use  CreatesUserProviders;

    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];


    /**
     * Create a new Auth manager instance.
     *
     * @return void
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Get the user resolver callback.
     *
     * @return \Closure
     */
    public function userResolver()
    {
        return $this->userResolver;
    }


    /**
     * Attempt to get the guard from the local cache.
     *
     * @param  string $name
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->guards[$name] ?? $this->guards[$name] = $this->resolve($name);
    }

    /**
     * Resolve the given guard.
     *
     * @param  string $name
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {

        $config = $this->getConfig($name);


        if (is_null($config)) {
            throw new InvalidArgumentException("Auth guard [{$name}] is not defined.");
        }

        $driverMethod = 'create' . ucfirst($config['driver']) . 'Driver';

        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($name, $config);
        }
        throw new InvalidArgumentException("Auth driver [{$config['driver']}] for guard [{$name}] is not defined.");

    }


    /**
     * Create a token based authentication guard.
     *
     * @param  string $name
     * @param  array $config
     * @return \Illuminate\Auth\TokenGuard
     */
    public function createTokenDriver($name, $config)
    {
        // The token guard implements a basic API token based guard implementation
        // that takes an API token field from the request and matches it to the
        // user in the database or another persistence layer where users are.

        $guard = new TokenGurd(
            $this->createUserProvider($config['provider']),
            $this->app['request']
        );

        return $guard;
    }


    public function getUserProviderConfig($name)
    {

        return $this->app->config("auth.providers.{$name}");
    }

    /**
     * Get the guard configuration.
     *
     * @param  string $name
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app->config("auth.guards.{$name}");
    }

    /**
     * Get the default authentication driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app->config("auth.defaults.guard");
    }

    /**
     * Set the default guard driver the factory should serve.
     *
     * @param  string $name
     * @return void
     */
    public function shouldUse($name)
    {
        $name = $name ?: $this->getDefaultDriver();
        $this->setDefaultDriver($name);
        $this->userResolver = function ($name = null) {
            return $this->guard($name)->user();
        };
    }

    /**
     * Set the default authentication driver name.
     *
     * @param  string $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app->config('auth.defaults.guard', $name);
    }


    /**
     * Dynamically call the default driver instance.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->guard()->{$method}(...$parameters);
    }
}
