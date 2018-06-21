<?php

namespace Dawn\Auth\http\middleware;


use Dawn\Auth\auth\AuthenticationException;
use Dawn\Auth\auth\AuthManager;
use Dawn\Auth\facade\Auth;
use think\App;
use think\Request;

class Authenticate
{
    public $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, \Closure $next, $guard)
    {
        // 添加中间件执行代码

        try {
            $this->authenticate($guard);
        } catch (AuthenticationException $e) {
            return response(['code' => 401, 'message' => $e->getMessage()], 401,[],'json');
        }
        $request->hook('auth', function () use ($guard) {
            return $this->auth->guard($guard);
        });
        $response = $next($request);
        return $response;
    }

    public function authenticate($guard)
    {

        $this->auth->guard($guard);
        if ($this->auth->guard($guard)->check()) {
            return $this->auth->shouldUse($guard);
        }
        throw new AuthenticationException('Unauthenticated:' . $guard);
    }
}
