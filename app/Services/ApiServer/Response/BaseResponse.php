<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/18
 * Time: 下午10:58
 */

namespace App\Services\ApiServer\Response;

abstract class BaseResponse
{
    /**
     * 接口名称
     *
     * @var [type]
     */
    protected $method;

    /**
     * 返回接口名称
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}