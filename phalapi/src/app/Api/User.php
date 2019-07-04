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
            'avatar' => array(
                'user_id' => array('name' => 'user_id', 'require' => true, 'type' => 'int', 'desc' => '用户id'),
                'file' => array(
                    'name' => 'file',        // 客户端上传的文件字段
                    'type' => 'file',
                    'require' => true,
                    'max' => 10485760,        // 最大允许上传10M = 10 * 1024 * 1024,
                    'range' => array('image/jpeg', 'image/png'),  // 允许的文件格式
                    'ext' => 'jpeg,jpg,png', // 允许的文件扩展名
                    'desc' => '待上传的图片文件',
                ),
            ),
            'experience' => array(
                'user_id' => array('name' => 'user_id', 'require' => true, 'type' => 'int', 'desc' => '用户id'),
                'exp' => array('name' => 'exp', 'require' => true, 'type' => 'int', 'desc' => '用户经验值'),
                'level' => array('name' => 'level', 'require' => true, 'type' => 'int', 'desc' => '用户等级')
            ),
            'currency' => array(
                'user_id' => array('name' => 'user_id', 'require' => true, 'type' => 'int', 'desc' => '用户id'),
                'diamond' => array('name' => 'diamond', 'type' => 'int', 'desc' => '用户钻石'),
                'healthyBeans' => array('name' => 'healthyBeans', 'type' => 'int', 'desc' => '用户健康豆'),
                'energy' => array('name' => 'energy','type' => 'int', 'desc' => '用户体力')
            )
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
     * @return url avatar 头像路径
     * @return int lock 是否锁定，0：锁定，1：未锁定
     * @return int delete_time 删除时间
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

    /**
     * 图片文件上传
     * @desc 只能上传单个图片文件
     * @return int code 操作状态码，1成功，0失败
     * @return url string 成功上传时返回的图片URL
     */
    public function avatar()
    {
        $rs = array('code' => 0, 'url' => '');

        $tmpName = $this->file['tmp_name'];

        $name = md5($this->file['name'] . $_SERVER['REQUEST_TIME']);
        $ext = strrchr($this->file['name'], '.');
        $uploadFolder = sprintf('%s/public/avatar/', API_ROOT);
        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0777);
        }

        $imgPath = $uploadFolder . $name . $ext;
        if (move_uploaded_file($tmpName, $imgPath)) {
            $rs['code'] = 1;
            $rs['url'] = sprintf('http://%s/avatar/%s%s', $_SERVER['SERVER_NAME'], $name, $ext);
            $domain = new UserDomain();
            $domain->avatar($this->user_id, $rs['url']);
        }

        return $rs;
    }

    /**
     * 修改用户经验等级接口
     * @desc 完成游戏后记得调用,请不要调用不存在的user_id
     */
    public function experience() {
        $user_id = $this->user_id;
        $exp = $this->exp;
        $level = $this->level;

        $domain = new UserDomain();

        return $domain->experience($user_id, $exp, $level);
    }

    /**
     * 修改用户体力、健康豆、钻石接口
     * @desc 三个值均为选填项
     * @return int data 更新行数
     */
    public function currency() {
        $user_id = $this->user_id;

        $data = array(
            'diamond' => $this->diamond,
            'energy' => $this->energy,
            'healthyBeans' => $this->healthyBeans,
        );

        $data = array_filter($data,function ($v, $k){
            return $v !== null;
        },ARRAY_FILTER_USE_BOTH);

        $domain = new UserDomain();

        return $domain->currency($user_id, $data);
    }
} 
