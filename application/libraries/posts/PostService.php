<?php

namespace TinaBlog\Libraries\Post;

defined('BASEPATH') or exit('No direct script access allowed');

class PostService {

  private $CI;

  public function __construct() {

    $this->CI = &get_instance();

  }

  public function store(array $data) : array {

    $result = $this->CI->db->insert("posts", [

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

  public function updatePost($id, $data)
  {

      $updateData = [];

      $updateData['title'] = $data['title'];

      $updateData["body"] = $data['body'];

      $updateString = $this->CI->db->update_string("posts", $updateData, ["id" => $id]);

      $result = $this->CI->db->query($updateString);

      if ($result) {

          $response['status'] = true;

          $response['message'] = 'post has been updated';

          $response['code'] = 201;

          return $response;

      }

      $response['status'] = false;

      $response['message'] = "operation not successfull";

      $response['code'] = 500;

      return $response;

  }

  public function get($id = null)
  {

    log_message("debug", "CI IS NULL === " . json_encode(is_null($CI)));

    log_message("debug", "CI input IS NULL === " . json_encode(is_null($CI->input)));

//     if(! empty($id))

    if(!is_null($id))
        $this->CI->db->where("id", $id);

    $result = $this->CI->db->select("*")

                        ->from('posts')

                        ->get()->result_array();

      $response["status"] = true;

      $response["posts"] = $result;

      $response["message"] = "Operation Successful";

      $response["code"] = 200;

      return $response;

  }

  public function delete($id)
  {
    $result = $this->CI->db->delete('posts', array('id' => $id));

      log_message("debug", "CI IS NULL === " . json_encode($result));

      //  $result = $this->CI->db->query("delete from `posts` where id = $id");

    if($result) {

        $response["status"] = true;

        $response["message"] = "deleted";

        $response["code"] = 200;
        
        return $response;

    }


      $response["status"] = false;

      $response["message"] = "Sorry we're unable to delete post now. Please try again or contact support";

      $response["code"] = 500;

    return $response;

  }








}
