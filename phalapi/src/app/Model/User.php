<?php
/**
 * Created by PhpStorm.
 * User: LiuZhelin
 * Date: 2019/2/28
 * Time: 16:35
 */

namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class User extends NotORM
{
    /** 获取用户单条信息
     * @param string $username 用户名
     * @param string $password 密码
     * @return mixed
     */
    public function login($username,$password)
    {
        return $this->getORM()->where('name=? AND password=?',$username,$password)->fetchOne();
    }
}