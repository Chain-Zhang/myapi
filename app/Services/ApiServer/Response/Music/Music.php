<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/19
 * Time: 下午11:56
 */

namespace App\Services\ApiServer\Response\Music;


use App\Models\Song;

class Music
{
    public static function run($params){
        $url='http://music.163.com/api/playlist/detail?id=37880978&updateTime=-1';
        $html = file_get_contents($url);
        return json_decode($html);
    }

    public static function query($params){
        if(isset($params['keyword'])){
            $keyword = $params['keyword'];
            if(!empty($keyword)){
                $url = 'http://tingapi.ting.baidu.com/v1/restserver/ting?method=baidu.ting.search.catalogSug&query=' . $keyword;
                $html = file_get_contents($url);
                $songs = array();
                foreach(json_decode($html)->song as $item){
                    $song = new Song();
                    $song->name = $item->songname;
                    $song->singer = $item->artistname;
                    $song->id = $item->songid;
                    array_push($songs, $song);
                }
                return [
                    'code'=>'200',
                    'data'=>$songs,
                    'msg'=>'success',
                    'status'=>true
                ];
            }
            else{
                return [
                    'code' => '2001',
                    'msg' => 'keyword不能为空',
                    'status' => false
                ];
            }
        }
        else{
            return [
                'code' => '2002',
                'msg' => '缺少keyword参数',
                'status' => false
            ];
        }

    }
}