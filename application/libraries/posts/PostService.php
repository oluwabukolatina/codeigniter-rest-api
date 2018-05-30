<?php

namespace TinaBlog\Libraries\Post;

defined('BASEPATH') or exit('No direct script access allowed');

class PostService {

  private $CI;

  public function __construct() {

    $this->CI = &get_instance();

  }

  public function store(array $data) : array {

    $CI = &get_instance();

    $result = $CI->db->insert("posts", [

            'title' => $data['title'],

             'body' => $data['body']

    ]);

    if(!$result) {

        $response["status"] = false;

        $response["error"]["message"] = "Sorry we're unable to add new post now. Please try again or contact support";

        $response["error"]["code"] = 500;

        return $response;

    }

    $response["status"] = true;

    $response["post"] = $result;

    $response["message"] = "Post created successfully";

    $response["code"] = 201;

    return $response;

  }

  public function updatePost(array $data, $id) : array {

    $CI = &get_instance();

    $post_id = $CI->db->where('id', $id);

    $result = $CI->db->set("posts", [

      'id' => $post_id,

      'title' => $data['title'],

      'body' => $data['body']

    ]);

    // $result = $CI->db->update("posts", [
    //
    //   'title' => $data['title'],
    //
    //   'body' => $data['body']
    //
    // ])->where('id', $id);

  }

  public function get($id = null)
  // public function get($id = FALSE)
  {

    $CI = &get_instance();

    log_message("debug", "CI IS NULL === " . json_encode(is_null($CI)));

    log_message("debug", "CI input IS NULL === " . json_encode(is_null($CI->input)));

    // if(! empty($id))

    if(!is_null($id))
        $this->CI->db->where("id", $id);

        $result = $CI->db->select("*")

                                ->from('posts')

                                ->get()->result_array();




    if(empty($result))
    {

      $response["status"] = false;

      $response["error"]["message"] = "Posts not found";

      $response["error"]["code"] = 404;

      return $response;

    }

      $response["status"] = true;

      $response["posts"] = $result;

      $response["message"] = "found";

      $response["error"] = 201;

      return $response;

  }

  public function delete($id)
  {

    $CI = &get_instance();

    $this->CI->db->delete('posts', array('id' => $id));

  }

  // public function updates($data, $id) : array {
  public function updates(array $data, $id) : array {
  // public function updates($id, $data)
  //
  // {

    $CI = &get_instance();

    $this->CI->db->where('id', $id);

    $result = $CI->db->update("posts", [

      'title' => $data['title'],

      'body' => $data['body']

    // ])->where('id', $id);
    ]);

    // $result = $CI->db->where('id', $id)->update("posts", [
    //
    //   'title' => $data['title'],
    //
    //   'body' => $data['body']
    //
    // ]);

    if(!$result) {

        $response["status"] = false;

        $response["error"]["message"] = "unable";

        $response["error"]["code"] = 500;

        return $response;

    }

    $response["status"] = true;

    $response["post"] = $result;

    $response["message"] = "edited";

    $response["code"] = 201;

    return $response;

  }

    //
    //
    // return $this->ci->db->set('posts', $result);

    // $data = array(
    //
    //   'title' => $_POST['title'],
    //
    //   'body' => $_POST['body']
    //
    // );
    //
    // $this->db->where('id', $id);
    //
    // $this->db->set('posts', $data);

    // $updateData = [];

    // $result = $CI->db->update('posts', [
    //
    //   $updateData['title'] = $_POST['title']
    // ]);

    // if(array_key_exists("title", $data)) {
    //
    // $updateData["title"] = $data["title"]
    //
    // }
    // if(array_key_exists('title', $data[
    //   $updateData['title'] = $data['title']
    // ]));
    //
    // if(array_key_exists('title', $data[
    //   $updateData['body'] = $data['body']
    // ]));
    //
    // $result = $CI->db->set('posts', $updateData);










}
