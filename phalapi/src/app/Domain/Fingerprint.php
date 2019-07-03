<?php


namespace App\Domain;

use App\Model\Fingerprint as FingerprintModel;

class Fingerprint
{
    public function getFingerPrint($userId, $machineId){
        $fModel = new FingerprintModel();
        $info = $fModel->getFingerPrint($userId, $machineId);
        if(!$info){
            return array('code' => 0);
        } else{
            return array('code' => 1, 'info' => $info);
        }
    }

    public function setFingerPrint($userId, $machineId, $fingerId, $fingerValue){
        $fModel = new FingerprintModel();
        $info = $fModel->setFingerPrint($userId, $machineId, $fingerId, $fingerValue);
        if($info === null){
            return array('code' => 0);
        } else{
            return array('code' => 1);
        }
    }

    public function setAllFingerPrint($userId, $machineId, $data){
        $fModel = new FingerprintModel();
        $info = $fModel->setAllFingerPrint($userId, $machineId, $data);
        if($info === null){
            return array('code' => 0);
        } else{
            return array('code' => 1);
        }
    }
}