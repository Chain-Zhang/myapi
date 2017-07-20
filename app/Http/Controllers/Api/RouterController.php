<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/18
 * Time: 下午10:19
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiServer\Error;
use App\Services\ApiServer\Server;

class RouterController extends Controller
{
    public function index()
    {
        $server = new Server(new Error());
        return $server->run('');
    }

    public function test()
    {
        $server = new Server(new Error());
        return $server->run('Test');
    }

    public function music()
    {
        $server = new Server(new Error());
        return $server->run('Music');
    }
}