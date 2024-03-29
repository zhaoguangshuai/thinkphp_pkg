<?php
namespace app\index\controller;

use think\Controller;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class Wechat extends Controller
{
    protected $config = [
        'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
        'app_id' => 'wxbf34ee861a89cc1c', // 公众号 APPID
        'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
        'mch_id' => '1520538211',
        'key' => 'mF2suE9sU6Mk1Cxxxxxxxxxxx',
        'notify_url' => 'http://yanda.net.cn/notify.php',
        'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
        'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => './logs/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ];

    //微信JSAPI支付
    public function payJsapi()
    {
        //dump(PHP_SAPI);exit;
        /*$order = [
            'out_trade_no' => time(),
            'total_fee' => '1', // **单位：分**
            'body' => 'test body - 测试',
            'openid' => session('openid'),
        ];

        $pay = Pay::wechat($this->config)->mp($order);*/
        //var_dump($_SERVER);exit;
        $this->assign('openid', session('openid'));
        return $this->fetch();

        // $pay->appId
        // $pay->timeStamp
        // $pay->nonceStr
        // $pay->package
        // $pay->signType
    }

    public function notify()
    {
        $pay = Pay::wechat($this->config);

        try{
            $data = $pay->verify(); // 是的，验签就这么简单！

            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $pay->success()->send();// laravel 框架中请直接 `return $pay->success()`
    }

    //jssdk测试开发
    public function demoJssdk()
    {


        return $this->fetch();
    }

}
