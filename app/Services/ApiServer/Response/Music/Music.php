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

    public static function play($params){
        if(isset($params['id'])){
            $id = $params['id'];
            if(!empty($id)){
                $url = "http://tingapi.ting.baidu.com/v1/restserver/ting?method=baidu.ting.song.play&songid=". $id;
                $data = json_decode( file_get_contents($url));
                $song = new Song();
                $song->name = $data->songinfo->title;
                $song->id = $data->songinfo->song_id;
                $song->singer = $data->songinfo->author;
                $song->src = $data->bitrate->file_link;
                $song->lrc = $data->songinfo->lrclink;
                $song->pic_small = $data->songinfo->pic_small;
                $song->pic_big = $data->songinfo->pic_big;
                $song->pic_premium = $data->songinfo->pic_premium;
                return [
                    'code'=>'200',
                    'data'=>$song,
                    'msg'=>'success',
                    'status'=>true
                ];
            }else{
                return [
                    'code' => '2004',
                    'msg' => 'id不能为空',
                    'status' => false
                ];
            }
        }else{
            return [
                'code' => '2003',
                'msg' => '缺少id参数',
                'status' => false
            ]
        }
    }
}