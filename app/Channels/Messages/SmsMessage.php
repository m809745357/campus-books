<?php
namespace App\Channels\Messages;

use App\Exceptions\ApiException;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use App\Models\Sms;
use App\Tools\YunFengNew;

class SmsMessage
{
    /**
     * 发送短信
     *
     * @param  [type] $mobile [description]
     * @param  [type] $code   [description]
     * @return [type]         [description]
     */
    public function sendSms($user, $mobile)
    {
        $config = config('easy-sms.config');

        // try {
        //     $easySms = new EasySms($config);
        //
        //     $code = rand(1000, 9999);
        //     $easySms->send($mobile, [
        //         'template' => 'SMS_76020350',
        //         'data' => [
        //             'code' => $code,
        //             'product' => 'code'
        //         ],
        //     ]);
        // } catch (NoGatewayAvailableException $e) {
        //     throw new Exception("短信发送失败");
        // }

        $user->markSmsAsRead();

        $code = '6666';

        $user->addSms(['mobile' => $mobile, 'code' => $code]);
    }
}
