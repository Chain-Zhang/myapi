<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/20
 * Time: 下午9:50
 */

namespace App\Services\ApiServer\Response;


use App\Models\Student;
use Illuminate\Support\Facades\Log;

class GetStudents extends BaseResponse implements InterfaceResponse
{
    protected $method='';
    public function run(&$params){
        return Student::all();
    }
}