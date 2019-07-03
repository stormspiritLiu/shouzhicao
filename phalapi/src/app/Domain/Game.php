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
use App\Model\Reward as RewardModel;

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

    /**
     * 游戏解锁接口
     * @return mixed
     */
    public function complete(
        $userId,
        $gameId,
        $score,
        $star
    ) {
        $gModel = new GameModel();
        $game = $gModel->findByID($gameId);
        //获得经验记录
        switch ($star){
            case 1:
                $percent = 0.3;
                break;
            case 2:
                $percent = 0.7;
                break;
            case 3:
                $percent = 1;
                break;
            default:
                $percent = 0;
                break;
        }

        $rModel = new RewardModel();
        $rModel->insert(array(
            'userId'    => $userId,
            'award'     => $game['award'] * $percent,
            'experience'=> $game['experience'] * $percent,
            'source'    => 1,
            'time'      => date("Y-m-d H:i:s", time())
        ));
        //玩家游戏记录更新
        $ugModel = new UserGameModel();
        $playRecord = $ugModel->findByTwoID($userId, $gameId);
        $bestScore = max($score, $playRecord['score']);
        $bestStar = max($star, $playRecord['star']);
        if ($score > $playRecord['score'] or $star > $playRecord['star']){
            $ugModel->update($playRecord['id'], array(
                'bestScore' => $bestScore,
                'star'      => $bestStar,
                'updateTime'=> date("Y-m-d H:i:s", time())
            ));
            return array('message' => '新纪录！');
        }
        return array('message' => '再接再厉');
    }

    /**
     *
     */
    public function nextGame($level, $small_level){
        $model = new GameModel();
        $gameIdList = $model->gameIdList();
        $next1 = $next2 = 0;

        foreach ($gameIdList as $value){
            if($value['level'] == $level && $value['small_level'] - $small_level == 1){
                $next1 = $value['id'];
            }
            if($value['level'] - $level == 1 && $value['small_level'] == 1){
                $next2 = $value['id'];
            }
        }
        if ($next1){
            return $next1;
        } else if($next2){
            return $next2;
        } else{
            return -1;
        }
    }
}