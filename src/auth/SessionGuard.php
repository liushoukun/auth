<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/21/021 11:34
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Dawn\Auth\auth;


use Dawn\Auth\contracts\auth\Guard;
use Dawn\Auth\contracts\auth\Authenticatable;

use think\facade\Session;
use think\Request;
class SessionGuard implements Guard
{
    use GuardHelpers;
    public $request;
    public function __construct(
        Authenticatable $userProvider,
        Request $request)
    {
        $this->request = $request;
        $this->provider = $userProvider;

    }


    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (!is_null($this->user)) {
            return $this->user;
        }
        $user = null;
        $user = Session::get('user');
        if ($user) {
            $user = $this->provider->retrieveById($user[$this->provider->getAuthIdentifier()]);
        } else {
            throw new AuthenticationException('not user');
        }
        return $this->user = $user;
    }


    public function validate(array $credentials = [])
    {
        // TODO: Implement validate() method.
    }

    public function setUser(Authenticatable $user)
    {
        // TODO: Implement setUser() method.
    }


}