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
            )
        );
    }
    /**
     * 登录接口
     * @desc 根据账号和密码进行登录操作,测试数据 username=test，password=test123
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
     * 登录接口
     * @desc 进行注册操作
     */
    public function register() {
        $username = $this->username;   // 账号参数
        $password = $this->password;   // 密码参数
        $phoneNum = $this->phoneNum;   // 密码参数

        $domain = new UserDomain();

        return $domain->register($username,$password,$phoneNum);
    }
} 
