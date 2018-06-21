<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/19/019 15:57
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Dawn\Auth\http\controllers;


use app\common\model\User;
use Dawn\Auth\auth\Authenticatable;
use Dawn\Auth\auth\AuthenticationException;
use Dawn\Auth\auth\AuthManager;
use Dawn\Auth\auth\TokenGuard;
use Dawn\Auth\facade\Hash;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use think\Controller;
use think\Exception;
use think\exception\HttpResponseException;
use think\Request;


class Auth extends Controller
{



    public function token(Request $request)
    {
        $grant_type = $request->param('grant_type', 'password');
        $appid = $request->param('user_id', null);
        $password= $request->param('password', null);
        $user = User::get(1);
        $guard  = \Dawn\Auth\facade\Auth::guard('api');
        $token = $guard::token($user);

        //$token = TokenGuard::token($user);
        return json(['token_type' => 'Bearer', 'access_token' => (string)$token, 'expires_in' => $token->getClaim('exp')]);
    }
}