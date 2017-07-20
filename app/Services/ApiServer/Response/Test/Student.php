<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/21
 * Time: 上午12:00
 */
namespace App\Services\ApiServer\Response\Test;

class Student
{
    public static function getStudents($params){
        return [
            'code'=>'200',
            'data'=>\App\Models\Student::all(),
            'msg'=>'success',
            'status'=>true
        ];
    }
}