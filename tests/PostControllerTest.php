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

class PostControllerTest extends PHPUnit_Framework_TestCase
{

    private static $baseUrl;

    private static $guzzle;

    private static $body;

    private static $title;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $randomSuffix = strtoupper(bin2hex(random_bytes(6)));

        self::$guzzle = new Client([

            "header" => [

                "Content-Type" => "application/json"

            ]

        ]);

        self::$baseUrl = "localhost/talentbaseapi/index.php/";

        self::$body = "this is a body" .$randomSuffix;

        self::$title = "this is a title" .$randomSuffix;

        echo "\nSetup Before class called;\n";

    }

    public function testIndexHasUl()
    {
        $response = self::$guzzle->get(self::$baseUrl);

        $this->assertRegexp('/<h1>/', $response->getBody()->getContents());

    }

    public function testCreatePost()
    {
        echo "\nTesting Create Post . . .\n";

        $data = array (

            "title" => self::$title,

            "body" => self::$body

        );

//        var_dump($data);

        $response = self::$guzzle->post(self::$baseUrl . "post/add", ['body' => json_encode($data)]);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

        $this->assertNotEmpty($response['message']);

    }

    public function testPosts()
    {
        echo "\nTesting Fetch All Posts . . .\n";

        $response = self::$guzzle->get(self::$baseUrl . "posts");

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

        $this->assertNotEmpty($response['message']);

        if(!empty($response["posts"])) {

            $this->getOnePost($response["posts"][0]["id"]);

            $this->updateOnePost($response["posts"][0]["id"]);

            $this->deleteOnePost($response["posts"][0]["id"]);

        }

        echo "\nDone\n";

    }

    public function updateOnePost($postId)
    {
        $data = array(

            "title" => self::$title,

            "body" => self::$body

        );

        $response = self::$guzzle->post(self::$baseUrl . "post/update/" . $postId, ['body' => json_encode($data)]);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response['status']);

    }

    public function deleteOnePost($postId)
    {
        $response = self::$guzzle->post(self::$baseUrl . "post/delete/" . $postId);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

    }
    public function getOnePost($postId)
    {
        $response = self::$guzzle->get(self::$baseUrl . "post/" . $postId);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

        $this->assertNotEmpty($response['message']);

    }











}
