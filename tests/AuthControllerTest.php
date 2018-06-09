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

    private $email;

    private $password;

    private $name;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $randomSuffix = strtoupper(bin2hex(random_bytes(6)));

        $this->guzzle = new Client([

            "headers" => [

                "ContentType" => "application/json"
            ]

        ]);

        self::$baseUrl = "localhost/talentbaseapi/index.php/";

        $this->name = "Tina" . $randomSuffix;

        $this->email = 'naomi' . $randomSuffix;

        $this->password = '11111111' . $randomSuffix;

    }

    public function testRegister()
    {
        $data = array(

            'name' => $this->name,

            'email' => $this->email,

            'password' => $this->password

        );

//        var_dump($data);

        $response = $this->guzzle->post(self::$baseUrl . "register", ['body' => json_encode($data)]);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response['status']);

        $this->assertNotEmpty($response['message']);


    }

    public function testLogin()
    {
        $data = [

            'email' => 'naomi@naomi.com',

            'password' => '11111111'
        ]
        ;

        //is what is being returned from the postman
        $response = $this->guzzle->post(self::$baseUrl . "login", ['body' => json_encode($data)]);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

        $this->assertNotEmpty($response['message']);

    }






}
