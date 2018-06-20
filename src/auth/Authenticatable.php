<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/7/007 13:50
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Dawn\Auth\auth;


use think\Model;

class Authenticatable extends Model implements \Dawn\Auth\contracts\auth\Authenticatable
{
    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
    }

    public function retrieveById($identifier)
    {
        return $this->where($this->getAuthIdentifier(), '=', $identifier)->find();

    }

    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
        return $this->getPk();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }


}