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
use Lcobucci\JWT\Builder;
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
            try{
                $token = (new Parser())->parse($token);
            }catch (\Exception $exception){
                throw new AuthenticationException('token error');
            }

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
            $token = $this->bearerToken();
        }
        return $token;
    }



    public function setUser(Authenticatable $user)
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

    public static function token(Authenticatable $user, $exp = 7200)
    {
        try {
            $authId = $user[$user->getAuthIdentifier()];
        } catch (\Exception $e) {
            throw new HttpResponseException(response(['code' => 401, 'message' => 'Unauthenticated'], 401, [], 'json'));
        }
        $iss = config('auth.jwt.iss', 'http://*');
        $sign = new Sha256();
        $builder = new Builder();
        $key = config('auth.app_key', '');
        $token = $builder
            ->setIssuer($iss)// 配置发行者（ISS声明）
            // ->setId('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item jwt的唯一身份标识，主要用来作为一次性token,从而回避重放攻击。
            ->setIssuedAt(time())// Configures the time that the token was issue (iat claim) jwt的签发时间
            ->setNotBefore(time())// Configures the time that the token can be used (nbf claim) 定义在什么时间之前，该jwt都是不可用的.
            ->setExpiration(time() + $exp)// Configures the expiration time of the token (exp claim)  jwt的过期时间，这个过期时间必须要大于签发时间
            ->set('uid', $user[$user->getAuthIdentifier()])// Configures a new claim, called "uid"
            ->sign($sign, $key)
            ->getToken(); // Retrieves the generated token
        return $token;
    }

}