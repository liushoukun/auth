<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/11/011 17:45
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Dawn\Auth\hashing;


use think\App;
use think\Loader;

class HashManager
{

    public $driver;

    public $app;


    public function getDafaultDriver()
    {
        return $this->app->config('hashing.driver') ?? 'BcryptHasher';
    }

    public function __construct(App $app)
    {
        $this->app = $app;
        $name = $this->getDafaultDriver();
        $this->driver = Loader::factory($name, '\\DawnApi\\hashing\\', []);
    }

    public function info($hashedValue)
    {
        // TODO: Implement info() method.
    }

    public function make($value, array $options = [])
    {
        // TODO: Implement make() method.
        return $this->driver->make($value, $options);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        // TODO: Implement check() method.
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        // TODO: Implement needsRehash() method.
    }


}