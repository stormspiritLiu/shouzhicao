<?php
/**
 * Created by PhpStorm.
 * User: LiuZhelin
 * Date: 2019/2/28
 * Time: 16:34
 */

namespace App\Domain;

use App\Model\User as UserModel;
use App\Model\User\Game as UserGameModel;
use App\Model\Recharge as RechargeModel;

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

    /** 用户注册
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $phoneNum 手机号
     * @return mixed
     */
    public function register($username,$password,$phoneNum)
    {
        $model = new UserModel();
        return $model->register($username,$password,$phoneNum);
    }

    /** 用户钻石充值
     * @param int $user_id 用户id
     * @param int $amount 充值数额
     * @return mixed
     */
    public function recharge($user_id, $amount)
    {
        $model = new UserModel();
        $result = $model->recharge($user_id, $amount);
        if($result['code'] == 1){
            //充值成功，更新用户充值表
            $rechargeModel = new RechargeModel();
            $rechargeModel->insert(array(
                'userId'    => $user_id,
                'amount'    => $amount,
                'time'      => date("Y-m-d H:i:s",time())
            ));
        }
        return $result;
    }

    /** 我的收藏
     * @param int $user_id 用户id
     * @param int $game_id 游戏id
     * @return mixed
     */
    public function like($user_id, $game_id)
    {
        $model = new UserGameModel();
        return $model->like($user_id,$game_id);
    }

    public function nickname($user_id, $new_name)
    {
        $model = new UserModel();
        return $model->nickname($user_id,$new_name);

    }

    public function avatar($user_id, $avatar){
        $model = new UserModel();
        $model->avatar($user_id, $avatar);
    }
}