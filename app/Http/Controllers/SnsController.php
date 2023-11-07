<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;

use Aws\Sns\Message;
use Illuminate\Support\Facades\Log;

class SnsController extends BaseController
{
    protected  $SnsClient;
    protected  $topic;

    public function __construct()
    {
        $this->SnsClient = new SnsClient([
            'region' => 'ap-northeast-1',
            'version' => '2010-03-31'
        ]);
        $this->topic = 'arn:aws:sns:ap-northeast-1:779541610094:sample-push';
    }

    function index(){
        $result = [];
        try {
            $result = $this->SnsClient->listSubscriptionsByTopic([
                'TopicArn' => $this->topic, // REQUIRED
            ]);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
        return view('sns', ['result' => $result]);
    }

    function subscribe(Request $request){
        $result = [];
        $protocol = $request->query('protocol', 'email');
        $endpoint = $request->query('endpoint');
        if(empty($endpoint)){
            abort(405);
        }

        try {
            $result = $this->SnsClient->subscribe([
                'Protocol' => $protocol,
                'Endpoint' => $endpoint,
                'ReturnSubscriptionArn' => true,
                'TopicArn' => $this->topic,
            ]);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
        return json_encode($result);
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
