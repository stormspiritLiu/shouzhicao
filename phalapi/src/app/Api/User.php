<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\User as UserDomain;

/**
 * 用户模块接口服务
 */
class User extends Api {
    public function getRules() {
        return array(
            'login' => array(
                'username' => array('name' => 'username', 'require' => true, 'desc' => '用户名'),
                'password' => array('name' => 'password', 'require' => true, 'desc' => '密码'),
            ),
            'register' => array(
                'username' => array('name' => 'username', 'require' => true, 'desc' => '用户名'),
                'password' => array('name' => 'password', 'require' => true, 'desc' => '密码'),
                'phoneNum' => array('name' => 'phoneNum', 'require' => true, 'desc' => '手机号'),
            ),
            'recharge' => array(
                'user_id' => array('name' => 'user_id', 'require' => true, 'type' => 'int', 'desc' => '用户id'),
                'amount' => array('name' => 'amount', 'require' => true, 'type' => 'int', 'desc' => '充值数额'),
            ),
            'like' => array(
                'user_id' => array('name' => 'user_id', 'require' => true, 'type' => 'int', 'desc' => '用户id'),
                'game_id' => array('name' => 'game_id', 'require' => true, 'type' => 'int', 'desc' => '游戏id'),
            ),
            'nickname' => array(
                'user_id' => array('name' => 'user_id', 'require' => true, 'type' => 'int', 'desc' => '用户id'),
                'new_name' => array('name' => 'new_name', 'require' => true, 'type' => 'string', 'desc' => '用户新昵称'),
            ),
        );
    }
    /**
     * 登录接口
     * @desc 测试数据 username=test，password=test123
     * @return int id  用户ID
     * @return string name  用户名
     * @return string phoneNum 手机号
     * @return string password 密码
     * @return int level 等级
     * @return int energy 体力
     * @return int healthyBeans 健康豆
     * @return int experience 经验值
     * @return int diamond 钻石数量
     */
    public function login() {
        $username = $this->username;   // 账号参数
        $password = $this->password;   // 密码参数

        $domain = new UserDomain();

        return $domain->login($username,$password);
    }

    /**
     * 注册接口
     * @desc 进行注册操作
     */
    public function register() {
        $username = $this->username;   // 账号参数
        $password = $this->password;   // 密码参数
        $phoneNum = $this->phoneNum;   // 密码参数

        $domain = new UserDomain();

        return $domain->register($username,$password,$phoneNum);
    }

    /**
     * 充值接口
     * @desc 钻石充值接口,测试数据 user_id=1
     * @return int code 充值结果状态码
     * @return string message 充值结果说明
     */
    public function recharge() {
        $user_id = $this->user_id;      // 用户参数
        $amount = $this->amount;        // 数额参数

        $domain = new UserDomain();

        return $domain->recharge($user_id,$amount);
    }

    /**
     * 收藏接口
     * @desc 我的收藏接口
     * @return int code 收藏结果状态码
     * @return string message 收藏结果说明
     */
    public function like() {
        $user_id = $this->user_id;
        $game_id = $this->game_id;

        $domain = new UserDomain();

        return $domain->like($user_id,$game_id);
    }

    /**
     * 修改昵称接口
     * @desc 测试数据 user_id=1
     * @return int code 收藏结果状态码
     * @return string message 收藏结果说明
     */
    public function nickname() {
        $user_id = $this->user_id;
        $new_name = $this->new_name;

        $domain = new UserDomain();

        return $domain->nickname($user_id,$new_name);
    }
} 
