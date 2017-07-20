<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/19
 * Time: 下午11:56
 */

namespace App\Services\ApiServer\Response\Music;


class Music
{
    protected $method = 'music';

    public static function run($params){
        $url='http://music.163.com/api/playlist/detail?id=37880978&updateTime=-1';
        $html = file_get_contents($url);
        return json_decode($html);
    }
}