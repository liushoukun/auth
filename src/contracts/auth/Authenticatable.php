<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/7/007 14:32
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Dawn\Auth\contracts\auth;


interface Authenticatable
{

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed   $identifier
     * @param  string  $token
     */
    public function retrieveByToken($identifier, $token);
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     */
    public function retrieveById($identifier);

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier();

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword();




}