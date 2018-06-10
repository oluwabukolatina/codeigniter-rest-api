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

    private static $guzzle;

    private static $email;

    private static $password;

    private static $name;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $randomSuffix = strtoupper(bin2hex(random_bytes(6)));

        self::$guzzle = new Client([

            "headers" => [

                "ContentType" => "application/json"
            ]

        ]);

        self::$baseUrl = "localhost/talentbaseapi/index.php/";

        self::$name = "naomi" . $randomSuffix;

        self::$email = 'naomi@g.com' . $randomSuffix;

        self::$password = '11111111' . $randomSuffix;

        echo "\nSetup Before class called;\n";

    }


    public function testRegister()
    {
        $data = array(

            'name' => self::$name,

            'email' => self::$email,

            'password' => self::$password

        );

        print_r($data);

        $response = self::$guzzle->post(self::$baseUrl . "register", ['body' => json_encode($data)]);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response['status']);

        $this->assertNotEmpty($response['message']);

    }

    public function testLogin()
    {
        $data = [

            'email' => self::$email,

            'password' => self::$password

        ];

        print_r($data);
        //is what is being returned from the postman
        $response = self::$guzzle->post(self::$baseUrl . "login", ['body' => json_encode($data)]);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

        $this->assertNotEmpty($response['message']);

    }






}
