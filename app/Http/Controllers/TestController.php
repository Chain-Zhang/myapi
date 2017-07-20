<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/18
 * Time: 下午10:13
 */

namespace App\Http\Controllers;


class TestController extends Controller
{
    public function get_users(){
        $arr = [
            'status' => true,
            'code'   => '200',
            'data'   => [
                'current_time' => date('Y-m-d H:i:s')
            ]
        ];

        return ($_GET['callback']."(".json_encode($arr).")");
    }
}