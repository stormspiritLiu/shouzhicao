<?php
/**
 * Created by PhpStorm.
 * User: LiuZhelin
 * Date: 2019/3/3
 * Time: 11:13
 */

namespace App\Domain;

use App\Model\Game as GameModel;

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
            $like = $model->gameList($userId, $value['id']);
            if($like == null){
                $game[0]['lock'] = 0;
                $game[0]['like'] = 0;
            } else{
                $game[0]['lock'] = 1;
                $game[0]['like'] = $like[0]['like'];
            }

            array_push($result, $game[0]);
        }
        return $result;
    }
}