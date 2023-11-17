<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Aws\Sns\SnsClient;
use Aws\Pinpoint\PinpointClient;
use Aws\Exception\AwsException;

use Aws\Sns\Message;
use Illuminate\Support\Facades\Log;

class PinpointController extends BaseController
{
    protected  $pinpointClient;


    public function __construct()
    {
        $this->pinpointClient = new PinpointClient([
            'region' => 'ap-northeast-1',
            'version'  => 'latest',
        ]);
    }

    function pinpoint(){
        $result = [];
        echo '<pre>';
        try {
            $result = $this->pinpointClient->getApp([
                'ApplicationId' => 'd15c9c0db73b4832826bdb4e762b464f', // REQUIRED
            ]);
            //var_dump($result);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }

//        try {
//            $result = $this->pinpointClient->updateUserEndpointsBatch([
//                'ApplicationId' => 'd15c9c0db73b4832826bdb4e762b464f', // REQUIRED
//                'EndpointBatchRequest' => [ // REQUIRED
//                        'Item' => [ // REQUIRED
//                            [
//                                "ChannelType"=> "PUSH",
//                                "Address"=> "endpoint_push_1_device_token",
//                                "Attributes"=> [
//                                    "Interests"=> [
//                                        "Music",
//                                        "Books"
//                                    ]
//                                ],
//                                "Metrics"=> [
//                                    "music_interest_level"=> 5.0,
//                                    "books_interest_level"=> 8.0
//                                ],
//                                "Id"=> "example_endpoint_push_1",
//                                "User"=>[
//                                    "UserId"=> "example_endpoint_push_1",
//                                ]
//                            ],
//                        ]
//                ]
//            ]);
//            var_dump($result);
//        } catch (AwsException $e) {
//            // output error message if fails
//            error_log($e->getMessage());
//        }



        try {
            $result = $this->pinpointClient->sendMessages([
                'ApplicationId' => 'd15c9c0db73b4832826bdb4e762b464f',
                'MessageRequest' => [
                    'Addresses' => [
                        'endpoint_push_1_device_token' => [
                            'ChannelType' => 'PUSH',
                        ],
                    ],
                    'MessageConfiguration' => [
                        'DefaultPushNotificationMessage' => [
                            'Title'       => 'Test Push Notification Title',
                            'Body'        => 'Test Push Notification Body',
                            'Action'      => 'OPEN_APP',
                            'SilentPush'  => false, // Set to true for silent push notifications
                            // Add other push notification options as needed
                        ],
                    ],
                ],
            ]);


            var_dump($result);
        } catch (AwsException $e) {
            // output error message if fails
            var_dump($e->getMessage());
            //error_log($e->getMessage());
        }
        echo '</pre>';

        dd('end');

        return view('pinpoint', ['result' => $result->toArray()]);
    }


}
