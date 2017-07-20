<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/18
 * Time: 下午10:59
 */

namespace App\Services\ApiServer\Response;


Interface InterfaceResponse
{
    /**
     * 执行接口
     * @return array
     */
    public function run(&$params);

    /**
     * 返回接口名称
     * @return string
     */
    public function getMethod();
}