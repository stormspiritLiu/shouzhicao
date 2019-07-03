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
            ),
            'setALLFingerPrint' => array(
                'userId' => array('name' => 'userId', 'require' => true, 'type' => 'int', 'desc' => '用户ID'),
                'machineId' => array('name' => 'machineId', 'require' => true, 'type' => 'string', 'desc' => '机器ID'),
                'f0' => array('name' => 'f0', 'require' => true, 'type' => 'int', 'desc' => '手指0', 'min' => -1, 'max' => 99),
                'f1' => array('name' => 'f1', 'require' => true, 'type' => 'int', 'desc' => '手指1', 'min' => -1, 'max' => 99),
                'f2' => array('name' => 'f2', 'require' => true, 'type' => 'int', 'desc' => '手指2', 'min' => -1, 'max' => 99),
                'f3' => array('name' => 'f3', 'require' => true, 'type' => 'int', 'desc' => '手指3', 'min' => -1, 'max' => 99),
                'f4' => array('name' => 'f4', 'require' => true, 'type' => 'int', 'desc' => '手指4', 'min' => -1, 'max' => 99),
                'f5' => array('name' => 'f5', 'require' => true, 'type' => 'int', 'desc' => '手指5', 'min' => -1, 'max' => 99),
                'f6' => array('name' => 'f6', 'require' => true, 'type' => 'int', 'desc' => '手指6', 'min' => -1, 'max' => 99),
                'f7' => array('name' => 'f7', 'require' => true, 'type' => 'int', 'desc' => '手指7', 'min' => -1, 'max' => 99),
                'f8' => array('name' => 'f8', 'require' => true, 'type' => 'int', 'desc' => '手指8', 'min' => -1, 'max' => 99),
                'f9' => array('name' => 'f9', 'require' => true, 'type' => 'int', 'desc' => '手指9', 'min' => -1, 'max' => 99),
            )
        );
    }

    /**
     * 获取指纹信息接口
     * @desc 测试数据 userId=1，machineId=1
     * @return array
     * @return int code 0不存在，1存在
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

    /**
     * 一次性录入指纹信息接口
     * @desc 之前无该用户和机器信息则新建，有则更新
     * @return array code 0为失败，1为成功
     */
    public function setAllFingerPrint(){
        $fDomain = new FingerprintDomain();
        $data = array(
            'f0' => $this->f0,
            'f1' => $this->f1,
            'f2' => $this->f2,
            'f3' => $this->f3,
            'f4' => $this->f4,
            'f5' => $this->f5,
            'f6' => $this->f6,
            'f7' => $this->f7,
            'f8' => $this->f8,
            'f9' => $this->f9,
        );
        return $fDomain->setAllFingerPrint($this->userId, $this->machineId, $data);
    }
}