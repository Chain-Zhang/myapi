<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/18
 * Time: 下午11:00
 */

namespace App\Services\ApiServer\Response;


class Demo extends BaseResponse implements InterfaceResponse
{
    protected $method = 'demo';


    public function run(&$params){
//        return [
//            'status' => true,
//            'code'   => '200',
//            'data'   => [
//                'current_time' => date('Y-m-d H:i:s')
//            ]
//        ];
        return $params;
    }
}