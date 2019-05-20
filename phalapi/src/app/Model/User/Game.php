<?php
/**
 * Created by PhpStorm.
 * User: 刘柘林
 * Date: 2019/5/5
 * Time: 16:52
 */

namespace App\Model\User;

use PhalApi\Model\NotORMModel as NotORM;

class Game extends NotORM
{
    public function like($user_id, $game_id)
    {
        $orm = $this->getORM();
        $like = $orm->where('userId=? AND gameId=?',$user_id,$game_id)->fetchOne();
        if($like != null){
            if($like['like'] == 0){
                $orm->where('userId=? AND gameId=?',$user_id,$game_id)->update(array('like' => 1));
                return array('code' => 1, 'message' => '已收藏');
            } else{
                $orm->where('userId=? AND gameId=?',$user_id,$game_id)->update(array('like' => 0));
                return array('code' => 1, 'message' => '已取消收藏');
            }
        } else{
            $orm->insert(array(
                'userId' => $user_id,
                'gameId' => $game_id,
                'like'   => 1,
                'updateTime'   => date("Y-m-d H:i:s", time())
            ));
            return array('code' => 1, 'message' => '已收藏');
        }
    }

    public function findByTwoID($user_id, $game_id){
        return $this->getORM()->where('userId=? AND gameId=?',$user_id,$game_id)->fetchOne();
    }
}