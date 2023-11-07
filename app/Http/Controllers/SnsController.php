<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;

use Aws\Sns\Message;
use Illuminate\Support\Facades\Log;

class SnsController extends BaseController
{

    function index(){
        return view('sns');
    }

    function subscribe(){
        $SnSclient = new SnsClient([
            'region' => 'ap-northeast-1',
            'version' => '2010-03-31'
        ]);

        $protocol = 'https';
        $endpoint = url()->current();
        $topic = 'arn:aws:sns:ap-northeast-1:779541610094:sample-push';

        echo 'start subscribe<br/>';
        try {
            $result = $SnSclient->subscribe([
                'Protocol' => $protocol,
                'Endpoint' => $endpoint,
                'ReturnSubscriptionArn' => true,
                'TopicArn' => $topic,
            ]);
            Log::info($result);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
        echo '<br/>end subscribe';
        dd();
    }

    function confirm(){
        $message = Message::fromRawPostData();
        // Check the type of the message and handle the subscription.
        if ($message['Type'] === 'SubscriptionConfirmation') {
            // Confirm the subscription by sending a GET request to the SubscribeURL
            Log::info($message['SubscribeURL']);
            file_get_contents($message['SubscribeURL']);
        }
    }
}
