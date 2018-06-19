<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/7/007 15:37
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Dawn\Auth\auth;


use Dawn\Auth\contracts\auth\Guard;
use Dawn\Auth\contracts\auth\Authenticatable;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use think\Request;

class TokenGuard implements Guard
{
    use GuardHelpers;

    public $request;
    public $inputKey;

    public function __construct(
        Authenticatable $userProvider,
        Request $request,
        $inputKey = 'token')
    {
        $this->request = $request;
        $this->provider = $userProvider;
        $this->inputKey = $inputKey;
    }


    public function guest()
    {
        // TODO: Implement guest() method.
    }

    public function id()
    {
        // TODO: Implement id() method.
    }

    public function validate(array $credentials = [])
    {
        // TODO: Implement validate() method.
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
        $token = $this->getTokenForRequest();
        if (!empty($token)) {
            $token = (new Parser())->parse($token);
            $sign = new Sha256();
            $data = new ValidationData();
            $key = config('auth.app_key', '');
            if ($token->verify($sign, $key) && $token->validate($data)) {
                $user = $this->provider->retrieveById($token->getClaim('uid'));
            } else {
                throw new AuthenticationException('token error');
            }
        }
        return $this->user = $user;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        $token = $this->request->param($this->inputKey);
        if (empty($token)) {
            $token = $this->request->getInput($this->inputKey);
        }
        if (empty($token)) {
            $token = $this->bearerToken();
        }
        return $token;
    }


    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    protected function bearerToken()
    {
        $header = $this->request->header('Authorization', '');
        if (strpos($header, 'Bearer ') !== false) {
            return mb_substr($header, 7);
        }
    }

}