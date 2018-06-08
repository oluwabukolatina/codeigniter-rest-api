<?php

namespace TinaBlog\Libraries\User;

defined('BASEPATH') or exit('No direct script access allowed');

class UserService {

  private $CI;

  public function __construct() {

    $this->CI = &get_instance();

  }
  public function get($id = null)
   {

//    log_message("debug", "CI IS NULL === " . json_encode(is_null($CI)));
//
//    log_message("debug", "CI input IS NULL === " . json_encode(is_null($CI->input)));

    if(!is_null($id))
        $this->CI->db->where("id", $id);

        $result = $this->CI->db->select("*")

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

//      $response["users"] = $result;

      $response["message"] = "operation successful";

      $response["error"] = 201;

      return $response;

  }

  public function delete($id)
  {

    $result = $this->CI->db->delete("posts", array('id', $id));

    if($result) {

      $response["status"] = true;

      $response["message"] = "user has been deleted";

      $response["code"] = 200;

      return $response;

    }

    $response["status"] = false;

    $response["message"] = "sorry, we are not able to carrry out this device right now ";

    $response["error"] = 500;

    return $response;

    }












}
