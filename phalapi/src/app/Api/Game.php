<?php
/**
 * Created by PhpStorm.
 * User: LiuZhelin
 * Date: 2019/3/3
 * Time: 11:10
 */

namespace App\Api;

use PhalApi\Api;
use App\Domain\Game as GameDomain;

/**
 * 游戏模块接口服务
 */
class Game extends Api
{
    public function getRules() {
        return array(
            'findById' => array(
                'id' => array('name' => 'id', 'require' => true, 'desc' => '游戏Id'),
            ),
            'gameList' => array(
                'userId' => array('name' => 'userId', 'require' => true, 'desc' => '用户Id'),
            )
        );
    }

    /**
     * 根据id获取游戏单条信息
     * @desc 测试数据 id=1
     * @param string $id 游戏id
     * @return int id  游戏id
     * @return string name  游戏名
     * @return int level 等级
     * @return int experience 通关经验值
     * @return int difficulty 关卡难度
     * @return string music_name 音乐名称
     * @return string path 音乐路径
     * @return int time 音乐时长
     */
    public function findByID(){
        $id = $this->id;
        $domain = new GameDomain();
        return $domain->findByID($id);
    }

    /**
     * 游戏列表接口
     * @desc 查询用户的所有游戏状态
     */
    public function gameList() {
        $userId = $this->userId;   // 用户Id
        $domain = new GameDomain();

        return $domain->gameList($userId);
    }
}