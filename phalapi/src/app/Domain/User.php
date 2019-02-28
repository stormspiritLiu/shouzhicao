<?php
/**
 * Created by PhpStorm.
 * User: LiuZhelin
 * Date: 2019/2/28
 * Time: 16:34
 */

namespace App\Domain;

use App\Model\User as UserModel;

class User
{
    /**用户登录
     * @param string $username 用户名
     * @param string $password 密码
     * @return mixed
     */
    public function login($username,$password)
    {
        $model = new UserModel();
        return $model->login($username,$password);
    }
}