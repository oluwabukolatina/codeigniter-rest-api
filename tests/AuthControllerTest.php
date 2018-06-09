<?php
/**
 * Created by PhpStorm.
 * User: oluwa
 * Date: 6/9/2018
 * Time: 11:27 AM
 */

namespace TinaBlog\Tests;

use GuzzleHttp\Client;

use PHPUnit_Framework_TestCase;

class AuthControllerTest extends PHPUnit_Framework_TestCase
{

    private static $baseUrl;

    private $guzzle;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->guzzle = new Client([

            "headers" => [

                "ContentType" => "application/json"
            ]

        ]);

        self::$baseUrl = "localhost/talentbaseapi/index.php/";

    }

    public function testRegister()
    {
        $data = array(
            'name' => 'tina',
            'email' => 'oluwatina@gmail.com',
            'password' => '11111111'
        );

        $response = $this->guzzle->post(self::$baseUrl . "register", ['body' => json_encode($data)]);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response['status']);

        $this->assertNotEmpty($response['message']);


    }

//    public function testLogin()
//    {
//        $data = [
//
//            'email' => 'tina@g.com',
//
//            'password' => 'iiwiwi'
//
//        ];
//
//        $response = $this->guzzle->post(self::$baseUrl . "login", ['body' => json_encode($data)]);
//
//        $this->assertEquals($response->getStatusCode(), 200);
//
//        $response = json_decode($response->getBody(), true);
//
//    }






}
