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

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$guzzle = new Client([

            "header" => [

                "Content-Type" => "application/json"

            ]

        ]);

        self::$baseUrl = "localhost/talentbaseapi/index.php/";

        echo "\nSetup Before class called;\n";

    }

    public function testCreatePost()

    {

        $data = array (

            "title" => 'this is a title',

            "body" => "this is a body"

        );

        $response = self::$guzzle->post(self::$baseUrl . "post/add", ['body' => json_encode($data)]);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

        $this->assertNotEmpty($response['message']);

    }

    public function updateOnePost($postId)
    {

        $data = array(

            "title" => 'this is not a body',

            "body" => "this is not a title"

        );

        $response = self::$guzzle->post(self::$baseUrl . "post/update/" . $postId, ['body' => json_encode($data)]);

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response['status']);

    }

    public function testPosts()
    {
        $response = self::$guzzle->get(self::$baseUrl . "posts");

        $this->assertEquals($response->getStatusCode(), 200);

        $response = json_decode($response->getBody(), true);

        $this->assertTrue($response["status"]);

        $this->assertNotEmpty($response['message']);

        if(!empty($response["posts"])) {

            $this->getOnePost($response["posts"][0]["id"]);

            $this->deleteOnePost($response["posts"][0]["id"]);

            $this->updateOnePost($response["posts"][0]["id"]);

        }

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
