<?php
/**
 * Created by PhpStorm.
 * User: LiuZhelin
 * Date: 2019/3/3
 * Time: 11:13
 */

namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class Game extends NotORM
{
    /** 根据id获取游戏单条信息
     * @param string $id 游戏id
     * @return mixed
     */
    public function findByID($id)
    {
        $sql = 'SELECT g.*,m.name as music_name,m.path,m.time  '
            . 'FROM yiyon_game AS g LEFT JOIN yiyon_game_music AS gm '
            . 'ON g.id = gm.gameId '
            . 'LEFT JOIN yiyon_music as m '
            . 'ON gm.musicId = m.id '
            . 'where g.id=? '
        ;
        return $this->getORM()->queryAll($sql, array($id));
    }

    /** 根据id获取游戏指令数据
     * @param string $id 游戏id
     * @return mixed
     */
    public function findGameInstruction($id)
    {
        $sql = 'SELECT gi.instruction  '
            . 'FROM yiyon_game AS g LEFT JOIN yiyon_game_instruction AS gi '
            . 'ON g.id = gi.gameId '
            . 'where g.id=? '
        ;
        return $this->getORM()->queryAll($sql, array($id));
    }

    /** 游戏ID列表接口
     * @return mixed
     */
    public function gameIdList(){
        return $this->getORM()->select('id, level, small_level')->fetchAll();
    }

    /** 用户游戏通关情况接口
     * @param int $userId 用户Id
     * @param int $gameId 游戏Id
     * @return mixed
     */
    public function gameList($userId,$gameId)
    {
        $sql = 'SELECT ug.bestScore,ug.star,ug.updateTime,ug.like  '
            . 'FROM yiyon_game AS g LEFT JOIN yiyon_user_game AS ug '
            . 'ON g.id = ug.gameId '
            . 'where ug.userId=? and ug.gameId=? '
        ;
        return $this->getORM()->queryAll($sql, array($userId,$gameId));
    }

}