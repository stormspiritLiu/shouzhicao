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
            return "该用户名已注册";
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
        if($this->getORM()->where('id=?', $user_id)->fetchAll() == NULL){
            return array('code' => -1,'message' => '用户不存在');
        } else{
            $row = $this->getORM()->where('id', $user_id)->update(
                array('diamond' => new \NotORM_Literal("diamond + $amount"))
            );
            if($row == 1){
                return array('code' => 1,'message' => '充值成功');
            }
        }
    }

    public function nickname($user_id,$new_name)
    {
        if($this->getORM()->where('id=?', $user_id)->fetchAll() == NULL){
            return array('code' => -1,'message' => '用户不存在');
        }
        if ($this->getORM()->where('name=?', $new_name)->fetchAll() != NULL) {
            return array('code' => -1,'message' => '用户名已存在');
        }
        $result = $this->getORM()->where('id=?', $user_id)->update(array('name' => $new_name));
        if($result == 1){
            return array('code' => 1,'message' => '更新成功');
        } else if($result == 0){
            return array('code' => 0,'message' => '无更新，或者数据没变化');
        } else{
            return array('code' => -1,'message' => '更新异常、失败');
        }

    }

    public function avatar($user_id,$avatar)
    {
        return $this->getORM()->where('id', $user_id)->update(array('avatar' => $avatar));
    }
}