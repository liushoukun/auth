<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/7/007 12:03
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Dawn\Auth\facade;


use Dawn\Auth\auth\AuthManager;
use think\Facade;

/**
 * Class Auth
 * @see \Dawn\Auth\auth\AuthManager
 * @mixin \Dawn\Auth\auth\AuthManager
 */
class Auth extends Facade
{
    protected static function getFacadeClass()
    {
      return AuthManager::class;
    }


}