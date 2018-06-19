<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/11/011 17:26
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Dawn\Auth\facade;


use think\Facade;

class Hash extends Facade
{
    protected static function getFacadeClass()
    {
        return \DawnApi\hashing\HashManager::class;
    }


}