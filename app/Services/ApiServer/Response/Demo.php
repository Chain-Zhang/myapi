<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/18
 * Time: 下午11:00
 */

namespace App\Services\ApiServer\Response;


class Demo
{
    public static function run($params){
        return [
            'status' => true,
            'code'   => '200',
            'data'   => $params,
            'msg'    => 'success'
        ];
    }
}