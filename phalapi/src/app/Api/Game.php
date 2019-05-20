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
                'userId' => array('name' => 'userId', 'require' => true, 'desc' => '玩家Id'),
            ),
            'unlock' => array(
                'userId' => array('name' => 'userId', 'require' => true, 'desc' => '玩家Id'),
                'gameId' => array('name' => 'gameId', 'require' => true, 'desc' => '游戏Id'),
            ),
            'complete' => array(
                'userId' => array('name' => 'userId', 'require' => true, 'desc' => '玩家Id'),
                'gameId' => array('name' => 'gameId', 'require' => true, 'desc' => '游戏Id'),
                'score' => array('name' => 'score', 'require' => true, 'desc' => '指令集正确个数'),
                'star' => array('name' => 'star', 'require' => true, 'desc' => '通关达成星星，30%达成度1星，60% 2星，90% 3星')
            )
        );
    }

    /**
     * 根据id获取游戏单条信息
     * @desc 测试数据 id=1
     * @param int $id 游戏id
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
     * @return int id               游戏id
     * @return string name          游戏名称
     * @return int level            游戏等级
     * @return int award            通关代币奖励
     * @return int experience       通关经验值
     * @return int difficulty       难度等级(1：简单，2：中等，3：困难)
     * @return float price          游戏价格
     * @return string music_name    音乐名称
     * @return string path          音乐路径
     * @return int time             音乐时长
     * @return array playRecord     玩家游戏记录
     * @return int bestScore        最高得分
     * @return int star             星星获得数
     * @return int like             收藏情况(1收藏 0未收藏)
     * @desc 查询用户的所有游戏状态
     */
    public function gameList() {
        $userId = $this->userId;
        $domain = new GameDomain();

        return $domain->gameList($userId);
    }

    public function unlock(){
        $userId = $this->userId;
        $gameId = $this->gameId;
        $domain = new GameDomain();
        return $domain->unlock($userId, $gameId);
    }


}