<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Aws\DynamoDb\DynamoDbClient;
use Aws\Exception\AwsException;

use Aws\Sns\Message;
use Illuminate\Support\Facades\Log;

class TestController extends BaseController
{
    protected  $dynamoClient;
    public function __construct()
    {
        $this->dynamoClient = new DynamoDbClient([
            'region' => 'ap-northeast-1',
            'version'  => 'latest',
        ]);
    }

    function index(){

        // Specify the table name
        $tableName = 'dev_orders';

        // Define the query parameters
        $params = [
            'TableName' => $tableName,
            'KeyConditionExpression' => 'facilityId = :facilityId AND s_name = :otherKey',
            'ExpressionAttributeValues' => [
                ':facilityId' => ['S' => 'facility_hoge'],
                ':otherKey' => ['S' => 'お肉#0'],
            ],
        ];

//        try {
//            // Execute the query
//            $result = $this->dynamoClient->query($params);
//
//            // Access the items from the result
//            $items = $result['Items'];
//
//            // Process or return the items as needed
//            echo '<pre>';
//            // Process or return the items as needed
//            var_dump($items);
//            echo    '</pre>';
//        } catch (\Exception $e) {
//            // Handle exceptions (e.g., log the error)
//            echo '<pre>';
//            return response()->json(['error' => $e->getMessage()], 500).'</pre>';
//        }
        try {

        $this->dynamoClient->putItem([
            'TableName' => $tableName,
            'Item' => [
                'facilityId' => ['S' => 'facility_hoge'],
                'uuid' => ['S' => 'phucnn'],
                'categoryName' => ['S' => 'お肉_2'],
                'roomNo' => ['N' => '123'],
                'orderStatus' => ['S' => 'd'],
                'categoryInfo' => ['S' => 'x'],
                's_name' => ['S' => 'お肉#2'],
                'imagePath' => ['S' => 'c'],
                'guestName' => ['S' => 'phucnn'],
                'productInfo' => ['S' => 'e'],
                'price' => ['N' => '10000'],
                'productName' => ['S' => 'test'],
            ],
        ]);

            echo "Item inserted successfully!<br/>";
        } catch (\Exception $e) {
            echo "Error inserting item: " . $e->getMessage();
        }

    }

}
