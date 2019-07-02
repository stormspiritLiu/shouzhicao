<?php


namespace App\Api;


use PhalApi\Api;
use App\Domain\Fingerprint as FingerprintDomain;

/**
 * 指纹模块接口服务
 */
class Fingerprint extends Api
{
    public function getRules()
    {
        return array(
            'getFingerPrint' => array(
                'userId' => array('name' => 'userId', 'require' => true, 'type' => 'int', 'desc' => '用户ID'),
                'machineId' => array('name' => 'machineId', 'require' => true, 'type' => 'string', 'desc' => '机器ID'),
            ),
            'setFingerPrint' => array(
                'userId' => array('name' => 'userId', 'require' => true, 'type' => 'int', 'desc' => '用户ID'),
                'machineId' => array('name' => 'machineId', 'require' => true, 'type' => 'string', 'desc' => '机器ID'),
                'fingerId' => array('name' => 'fingerId', 'require' => true, 'type' => 'int', 'desc' => '手指编号', 'min' => 0, 'max' => 9),
                'fingerValue' => array('name' => 'fingerValue', 'require' => true, 'type' => 'int', 'desc' => '手指位置', 'min' => -1, 'max' => 99),
            )
        );
    }

    /**
     * 获取指纹信息接口
     * @desc 测试数据 userId=1，machineId=1
     * @return int id
     * @return int userId 用户ID
     * @return string machineId  机器ID
     * @return int f0  手指0的值
     */
    public function getFingerPrint(){
        $fDomain = new FingerprintDomain();
        return $fDomain->getFingerPrint($this->userId, $this->machineId);
    }

    /**
     * 录入指纹信息接口
     * @desc 之前无该用户和机器信息则新建，有则更新
     * @return array code 0为失败，1为成功
     */
    public function setFingerPrint(){
        $fDomain = new FingerprintDomain();
        return $fDomain->setFingerPrint($this->userId, $this->machineId, $this->fingerId, $this->fingerValue);
    }
}