<?php
/**
 * Created by PhpStorm.
 * User: oluwa
 * Date: 6/9/2018
 * Time: 10:55 AM
 */
namespace TinaBlog\Tests;
use GuzzleHttp\Client;
//use PHPUnit_Framework_TestCase;
//use UserControllerTest;
class UserControllerTest extends \PHPUnit_Framework_TestCase
{
    private static  $baseUrl;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->guzzle = new Client([
            "header" => [
                "ContentType" => "application/json"
            ]
        ]);
        self::$baseUrl = "localhost/talentbaseapi/index.php/";
    }
    public function Users()
    {
        $response = $this->guzzle->get( self::$baseUrl . "users");

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

        $this->assertNotEmpty($response["message"]);

        if(!empty($response['users']))
        {

            $this->testGetOneUser($response["users"]["id"]);
        }

    }


    public function GetOneUser($id)
    {

    }


}
