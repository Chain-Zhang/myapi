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
    public static function run($params){
        $url='http://music.163.com/api/playlist/detail?id=37880978&updateTime=-1';
        $html = file_get_contents($url);
        return json_decode($html);
    }

    public static function query($params){
        $keyword = $params['keyword'];
        if(!empty($keyword)){
            $url = 'http://tingapi.ting.baidu.com/v1/restserver/ting?method=baidu.ting.search.catalogSug&query=' . $keyword;
            $html = file_get_contents($url);
            $songs = array();
            for($i = 0; $i < $html->song->count(); $i++){
                array_push($songs, {'name':$html->song[$i]->songname, 'singer':$html->song[$i]->artistname})
            }
            return [
                'code'=>'200',
                'data'=>$songs,
                'msg'=>'success',
                'status'=>true
            ];
        }
    }
}