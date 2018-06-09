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

    private $guzzle;

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
    public function testCreatePost()
    {
        $data = array (
            "title" => 'this is a title',
            "body" => "this is a body"
        );
        $response = $this->guzzle->post(self::$baseUrl . "post/add", ['body' => json_encode($data)]);
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
        $response = $this->guzzle->post(self::$baseUrl . "post/update/" . $postId, ['body' => json_encode($data)]);
        $this->assertEquals($response->getStatusCode(), 200);
        $response = json_decode($response->getBody(), true);
        $this->assertTrue($response['status']);
    }
    public function testPosts()
    {
        $response = $this->guzzle->get(self::$baseUrl . "posts");
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
        $response = $this->guzzle->post(self::$baseUrl . "post/delete/" . $postId);
        $this->assertEquals($response->getStatusCode(), 200);
        $response = json_decode($response->getBody(), true);
        $this->assertTrue($response["status"]);
    }

    public function getOnePost($postId)
    {
        $response = $this->guzzle->get(self::$baseUrl . "post/" . $postId);
        $this->assertEquals($response->getStatusCode(), 200);
        $response = json_decode($response->getBody(), true);
        $this->assertTrue($response["status"]);
        $this->assertNotEmpty($response['message']);

    }

//    public function deleteOnePost($postId)
//    {
//        $response = $this->guzzle->delete(self::$baseUrl . "post/delete". $postId);
//        $this->assertEquals($response->getStatusCode(), 200);
//        $response = json_encode($response->getBody(), true);
//        $this->assertTrue($response['status']);
//
//    }










}
