<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/18
 * Time: 下午10:21
 */

namespace App\Services\ApiServer;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class Server
{
    protected $params = [];

    protected $callBack;

    protected $method;

    protected $app_id;

    protected $app_secret;

    protected $format = 'json';

    protected $sign_method = 'md5';

    protected $error_code_show = false;

    public function __construct(Error $error)
    {
        $this->params = Request::all();
        $this->error = $error;
    }

    public function run(){
        Log::info('请求参数:');
        Log::info($this->params);
        $rules = [
            'app_id' => 'required',
            'method' => 'required',
            'format' => 'in:,json',
            'sign_methos' => 'in:,md5',
//            'nonce'       => 'required|string|min:1|max:32|',
//            'sign'        => 'required',
        ];
        $messages = [
            'app_id.required' => '1001',
            'method.required' => '1003',
            'format.in'       => '1004',
            'sign_method.in'  => '1005',
//            'nonce.required'  => '1010',
//            'nonce.string'    => '1011',
//            'nonce.min'       => '1012',
            'nonce.max'       => '1012',
//            'sign.required'   => '1006'
        ];
        $v = Validator::make($this->params, $rules, $messages);

        if ($v->fails()){
            return $this->response(['status' => false, 'code' => $v->messages()->first()]);
        }

        // A.2 赋值对象
        $this->format      = !empty($this->params['format']) ? $this->params['format'] : $this->format;
        $this->sign_method = !empty($this->params['sign_method']) ? $this->params['sign_method'] : $this->sign_method;
        $this->app_id      = $this->params['app_id'];
        $this->method      = $this->params['method'];

        $this->callBack = array_key_exists('callback', $this->params) ? $this->params['callback'] : '';
        if (!empty($sign))
            unset($this->params['callback']);

        $app = App::getInstance($this->app_id)->info();
        if (!$app){
            return $this->response(['status' => false, 'code' => '1002']);
        }
//        $this->app_secret = $app->app_secret;

        // C. 校验签名
//        $signRes = $this->checkSign($this->params);
//        if (! $signRes || ! $signRes['status']) {
//            return $this->response(['status' => false, 'code' => $signRes['code']]);
//        }

        // D. 校验接口名
        // D.1 通过方法名获取类名
        $className = self::getClassName($this->method);

        // D.2 判断类名是否存在
        $classPath = __NAMESPACE__ . '\\Response\\' . $className;
        if (!$className || !class_exists($classPath)) {
            return $this->response(['status' => false, 'code' => '1008']);
        }

        // D.3 判断方法是否存在
        if (! method_exists($classPath, 'run')) {
            return $this->response(['status' => false, 'code' => '1009']);
        }

        $this->classname = $classPath;

        // E. api接口分发
        $class = new $classPath;
        return $this->response((array) $class->run($this->params));
    }

    /**
     * 校验签名
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    protected function checkSign($params)
    {
        $sign = array_key_exists('sign', $params) ? $params['sign'] : '';

        if (empty($sign))
            return array('status' => false, 'code' => '1006');

        unset($params['sign']);

        if ($sign != $this->generateSign($params))
            return array('status' => false, 'code' => '1007');

        return array('status' => true, 'code' => '200');
    }

    /**
     * 生成签名
     * @param  array $params 待校验签名参数
     * @return string|false
     */
    protected function generateSign($params)
    {
        if ($this->sign_method == 'md5')
            return $this->generateMd5Sign($params);

        return false;
    }

    /**
     * md5方式签名
     * @param  array $params 待签名参数
     * @return string
     */
    protected function generateMd5Sign($params)
    {
        ksort($params);

        $tmps = array();
        foreach ($params as $k => $v) {
            $tmps[] = $k . $v;
        }

        $string = $this->app_secret . implode('', $tmps) . $this->app_secret;

        return strtoupper(md5($string));
    }


    /**
     * 通过方法名转换为对应的类名
     * @param  string $method 方法名
     * @return string|false
     */
    protected function getClassName($method)
    {
        $methods = explode('.', $method);

        if (!is_array($methods))
            return false;

        $tmp = array();
        foreach ($methods as $value) {
            $tmp[] = ucwords($value);
        }

        $className = implode('', $tmp);
        return $className;
    }

    /**
     * 输出结果
     * @param  array $result 结果
     * @return response
     */
    protected function response(array $result)
    {
        if (! array_key_exists('msg', $result) && array_key_exists('code', $result)) {
            $result['msg'] = $this->getError($result['code']);
        }

        if ($this->format == 'json') {
            if (empty($this->callBack))
                return json_encode($result);
                //return response()->json($result);
            else
                return $this->callBack."(".json_encode($result).")";
        }

        return false;
    }

    /**
     * 返回错误内容
     * @param  string $code 错误码
     * @return string
     */
    protected function getError($code)
    {
        return $this->error->getError($code, $this->error_code_show);
    }
}