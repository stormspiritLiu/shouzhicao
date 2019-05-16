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
    public function gameList() {
        $model = new GameModel();
        $gameIdList = $model->gameIdList();
        $result = array();
        foreach ($gameIdList as $value){
            $game = $this->findByID($value['id']);
            array_push($result, $game[0]);
        }
        return $result;
    }
}