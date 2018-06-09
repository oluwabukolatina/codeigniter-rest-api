<?php

/**
 * Created by PhpStorm.
 * User: oluwa
 * Date: 6/8/2018
 * Time: 5:40 PM
 */
namespace TinaBlog\Tests;

use GuzzleHttp\Client;

use PHPUnit_Framework_TestCase;

//use PhpUnit\Framework\TestCase;

class PostControllerTest extends PHPUnit_Framework_TestCase
{

    private static $baseUrl;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->guzzle = new Client([

            "header" => [

                "Content-Type" => "application/json"

            ]

        ]);

        self::$baseUrl = "localhost/talentbaseapi/index.php/";

    }

    public function testPosts()
    {

        $response = $this->guzzle->get(self::$baseUrl . "posts");

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

        $this->assertNotEmpty($response['message']);

    }
}
