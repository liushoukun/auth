<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 会话设置
// +----------------------------------------------------------------------

return [
    'name'=>'AFAGOU',
    'id'             => '',
    'var_session_id' => 'token',  // SESSION_ID的提交变量,解决flash上传跨域
    'type'       => 'redis',     // 驱动方式 支持redis memcache memcached
    'prefix'     => 'afagou',     // SESSION 前缀
    'auto_start' => true,     // 是否自动开启 SESSION

    'host'         => 'redisip', // redis主机
    'port'         => 6379, // redis端口
    'password'     => '', // 密码
    'select'       => 0, // 操作库
    'expire'       => 7200, // 有效期(秒)
    'timeout'      => 0, // 超时时间(秒)
    'persistent'   => true, // 是否长连接
    'session_name' => 'think', // sessionkey前缀
];
