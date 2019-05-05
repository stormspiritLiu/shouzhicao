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

    /** 用户注册
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $phoneNum 手机号
     * @return mixed
     */
    public function register($username,$password,$phoneNum)
    {
        if ($this->getORM()->where('name=?',$username)->fetchAll() != NULL){
            return "该用户名已注册";;
        } else if ($this->getORM()->where('phoneNum=?',$phoneNum)->fetchAll() != NULL){
            return "该手机号已注册";
        } else{
            $data = array('name' => $username, 'phoneNum' => $phoneNum, 'password' => $password);
            return $this->getORM()->insert($data);
        }

    }

    /** 用户钻石充值
     * @param int $user_id 用户id
     * @param int $amount 充值数额
     * @return mixed
     */
    public function recharge($user_id, $amount)
    {
        $orm = $this->getORM();
        if($orm->where('id=?', $user_id)->fetchAll() == NULL){
            return array('code' => -1,'message' => '用户不存在');
        } else{
            $row = $orm->where('id', $user_id)->update(
                array('diamond' => new \NotORM_Literal("diamond + $amount"))
            );
            if($row == 1){
                return array('code' => 1,'message' => '充值成功');
            }
        }
    }
}