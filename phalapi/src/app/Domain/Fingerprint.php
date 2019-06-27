<?php


namespace App\Domain;

use App\Model\Fingerprint as FingerprintModel;

class Fingerprint
{
    public function getFingerPrint($userId, $machineId){
        $fModel = new FingerprintModel();
        return $fModel->getFingerPrint($userId, $machineId);
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
}