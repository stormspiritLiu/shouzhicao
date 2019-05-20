<?php
/**
 * Created by PhpStorm.
 * User: LiuZhelin
 * Date: 2019/3/3
 * Time: 11:13
 */

namespace App\Domain;

use App\Model\Game as GameModel;
use App\Model\User\Game as UserGameModel;

class Game
{
    /** 根据id获取游戏单条信息
     * @param string $id 游戏id
     * @return mixed
     */
    public function findByID($id){
        $model = new GameModel();
        $data = $model->findByID($id);
        $data['0']['instruction'] = $model->findGameInstruction($id);
        return $data;
    }

    /**
     * 游戏列表接口
     * @return mixed
     */
    public function gameList($userId) {
        $model = new GameModel();
        $gameIdList = $model->gameIdList();
        $result = array();
        foreach ($gameIdList as $value){
            $game = $model->findByID($value['id']);
            $playRecord = $model->gameList($userId, $value['id']);
            if($playRecord == null){
                $game[0]['playRecord'] = null;
            } else{
                $game[0]['playRecord'] = $playRecord[0];
            }

            array_push($result, $game[0]);
        }
        return $result;
    }

    /**
     * 游戏解锁接口
     * @desc 用户请不要多次解锁同一个游戏
     * @return mixed
     */
    public function unlock($userId, $gameId) {
        $model = new UserGameModel();
        $user_game = $model->findByTwoID($userId, $gameId);
        if($user_game == null){
            $model->insert(array(
                'userId' => $userId,
                'gameId' => $gameId,
                'updateTime' => date("Y-m-d H:i:s", time())
            ));
            return array('code' => 1, 'message' => '游戏已解锁');
        } else{
            return array('code' => 0, 'message' => '错误，用户早已解锁过此游戏');
        }
    }
}