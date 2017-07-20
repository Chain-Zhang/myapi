<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/18
 * Time: 下午10:55
 */

namespace App\Services\ApiServer;


use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\PrefixApp;

class App
{
    /**
     * appid
     * @var [type]
     */
    protected $app_id;

    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key_prefix = 'api:app:info:';

    /**
     * 初始化
     * @param [type] $app_id [description]
     */
    public function __construct($app_id)
    {
        $this->app_id = $app_id;
    }

    /**
     * 获取当前对象
     * @param  string $app_id appid
     * @return object
     */
    public static function getInstance($app_id)
    {
        static $_instances = [];

        if (array_key_exists($app_id, $_instances))
            return $_instances[$app_id];

        return $_instances[$app_id] = new self($app_id);
    }

    /**
     * 获取app信息
     * @return PrefixApp
     */
    public function info()
    {
        $cache_key = $this->cache_key_prefix . $this->app_id;
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        }

        $app = PrefixApp::where(['status' => 1, 'app_id' => $this->app_id])->first();
        if ($app)
            Cache::put($cache_key, $app, Carbon::now()->addMinutes(60));  // 写入缓存

        return $app;
    }
}