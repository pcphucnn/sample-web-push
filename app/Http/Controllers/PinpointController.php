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
            'version' => '2010-03-31'
        ]);
    }

    function index(){
        $result = [];
        try {
            $result = $this->pinpointClient->getApp([
                'ApplicationId' => 'd15c9c0db73b4832826bdb4e762b464f', // REQUIRED
            ]);
            dd($result);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
        return view('pinpoint', ['result' => $result]);
    }


}
