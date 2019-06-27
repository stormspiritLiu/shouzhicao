<?php


namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class Fingerprint extends NotORM
{
    public function getFingerPrint($userId, $machineId){
        return $this->getORM()
            ->select("*")
            ->where("userId", $userId)
            ->where("machineId", $machineId)
            ->fetchOne();
    }

    public function setFingerPrint($userId, $machineId, $fingerId, $fingerValue){
        $record = $this->getORM()
            ->where("userId", $userId)
            ->where("machineId", $machineId)
            ->count();
        if($record == 1){
            //执行更新操作
            $data = array('f'.$fingerId => $fingerValue);
            return $this->getORM()
                ->where("userId", $userId)
                ->where("machineId", $machineId)
                ->update($data);
        } else{
            //执行插入操作
            $data = array(
                'userId' => $userId,
                'machineId' => $machineId,
                'f'.$fingerId => $fingerValue
            );
            return $this->getORM()->insert($data);
        }
    }
}