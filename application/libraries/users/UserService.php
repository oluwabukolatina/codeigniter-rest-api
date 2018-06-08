<?php

namespace TinaBlog\Libraries\User;

defined('BASEPATH') or exit('No direct script access allowed');

class UserService {

  private $CI;

  public function __construct() {

    $this->CI = &get_instance();

  }
  public function get($id = null)
  // public function get($id = FALSE)
  {

//    $CI = &get_instance();

    log_message("debug", "CI IS NULL === " . json_encode(is_null($CI)));

    log_message("debug", "CI input IS NULL === " . json_encode(is_null($CI->input)));

    // if(! empty($id))

    if(!is_null($id))
        $this->CI->db->where("id", $id);

        $result = $CI->db->select("*")

                                ->from('users')

                                ->get()->result_array();



    if(empty($result))
    {

      $response["status"] = false;

      $response["error"]["message"] = "Users not found";

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

    $result = $this->CI->db->query("delete from `users` where id = $id");

    if($result) {

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












}
